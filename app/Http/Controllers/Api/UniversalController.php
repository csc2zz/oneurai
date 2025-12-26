<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

// Models
use App\Models\Project;
use App\Models\AiModel;
use App\Models\Dataset;

class UniversalController extends Controller
{
    /**
     * ✅ غيّر هذا الاسم حسب الديسك الموجود عندك في filesystems.php
     * مثال: 'wasabi' أو 's3'
     */
    private string $diskName = 'wasabi';

    // ✅ القائمة البيضاء للامتدادات المسموح بها
    private const ALLOWED_EXTENSIONS = [
        'py', 'txt', 'csv', 'json', 'zip', 'md', 'jpg', 'png',
        'pt', 'pth', 'onnx', 'bin', 'gguf', 'safetensors',
        'ipynb'
    ];

    /**
     * تحديد الموديل والمجلد بناءً على نوع الطلب
     */
protected function getConfig($type)
{
    $types = [
        // تأكد أن القيمة هنا هي ai-models كما تظهر في Wasabi
        'model'   => ['folder' => 'ai-models'], 
        'repos'    => ['folder' => 'repos'],
        'datasets' => ['folder' => 'datasets'],
    ];

    return $types[$type] ?? null;
}

    /**
     * ✅ Upload (Protected) - يرفع على Wasabi + فحص أمني
     */
    public function upload(Request $request, $type, $username, $repo_name)
    {
        $user = $request->user();
        $config = $this->getConfig($type);

        if (!$config) {
            return response()->json(['error' => "Invalid type: $type"], 400);
        }

        // Disk (Wasabi/S3)
        $disk = Storage::disk($this->diskName);

        // إعدادات اتصال VPS للفحص
        $vpsIp = '77.83.242.109';
        $namePort = '6000';
        $filePort = '5000';

        // 1) Authorization: تأكد أن المسار مطابق لاسم المستخدم
        $dbUsername = strtolower(trim($user->username ?? $user->name));
        $inputUsername = strtolower(trim($username));

        if ($dbUsername !== $inputUsername) {
            return response()->json(['error' => 'Unauthorized: Path mismatch'], 403);
        }

        // 2) Validate file
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:51200', // 50MB
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // 3) Name scanner
        try {
            $nameResponse = Http::timeout(5)->post("http://{$vpsIp}:{$namePort}/validate", [
                'name' => $repo_name,
            ]);

            if ($nameResponse->successful()) {
                $result = $nameResponse->json();
                if (($result['status'] ?? null) === 'blocked') {
                    $reason = $result['reasons'][0]['description'] ?? 'Forbidden Name';
                    return response()->json(['error' => "Name Rejected: $reason"], 403);
                }
            }
        } catch (\Exception $e) {
            Log::warning("VPS Name Scanner Unreachable: " . $e->getMessage());
            // نكمل لو السيرفر طافي
        }

        DB::beginTransaction();

        try {
            $file = $request->file('file');

            $originalExtension = strtolower($file->getClientOriginalExtension());
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

            // تنظيف اسم الملف
            $cleanName = Str::slug($originalName);
            if (empty($cleanName)) $cleanName = 'file-' . time();

            $finalFilename = "{$cleanName}.{$originalExtension}";
            $size = $file->getSize();

            // 4) Extension allowlist
            if (!in_array($originalExtension, self::ALLOWED_EXTENSIONS, true)) {
                return response()->json(['error' => 'Security Violation: File type not allowed.'], 403);
            }

            // 5) File scanner
            try {
                $scanResponse = Http::timeout(120)
                    ->attach(
                        'file',
                        file_get_contents($file->getRealPath()),
                        $file->getClientOriginalName()
                    )->post("http://{$vpsIp}:{$filePort}/scan");

                if ($scanResponse->successful()) {
                    $scan = $scanResponse->json();
                    if (($scan['status'] ?? null) === 'blocked') {
                        $reason = $scan['reasons'][0]['description'] ?? 'Malicious Content Detected';
                        Log::alert("Malicious File Blocked: User {$user->id} tried to upload {$finalFilename}");
                        return response()->json(['error' => "Security Violation: File rejected by antivirus ($reason)"], 403);
                    }
                } else {
                    Log::warning("VPS File Scanner returned error: " . $scanResponse->status());
                    return response()->json(['error' => 'Security scanner unavailable, upload rejected.'], 503);
                }

            } catch (\Exception $e) {
                Log::error("VPS Connection Error: " . $e->getMessage());
                return response()->json(['error' => 'Failed to connect to security scanner.'], 503);
            }

            // 6) DB record (project/model/dataset)
            $description = $request->input('description', "Uploaded via Oneurai Library");
            $modelClass = $config['model'];

            $data = [
                'title'       => $repo_name,
                'description' => $description,
                'is_public'   => true,
                'updated_at'  => now(),
            ];

            if ($type !== 'repos') {
                $data['username'] = $dbUsername;
            }

            if ($type === 'models') {
                $data['license']   = 'MIT';
                $data['task']      = 'other';
                $data['framework'] = 'pytorch';
                $data['language']  = 'python';
            }

            $record = $modelClass::updateOrCreate(
                ['user_id' => $user->id, 'slug' => $repo_name],
                $data
            );

            // 7) Upload to Wasabi
            $dirPath = "{$config['folder']}/{$dbUsername}/{$repo_name}";

            // ✅ ارفع على نفس الديسك (Wasabi)
            $storedPath = $disk->putFileAs($dirPath, $file, $finalFilename);

            if (!$storedPath) {
                throw new \Exception("Failed to store file on disk ($this->diskName).");
            }

            // 8) Save file row
            $fileData = [
                'path'       => $storedPath,
                'size'       => $size,
                'user_id'    => $user->id,
                'updated_at' => now(),
                'extension'  => $originalExtension,
            ];

            $record->files()->updateOrCreate(
                ['filename' => $finalFilename],
                $fileData
            );

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Uploaded successfully as {$finalFilename}",
                'type'    => $type,
                'id'      => $record->id,
                'path'    => $storedPath,
                'disk'    => $this->diskName,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            // ✅ حذف من Wasabi لو انرفع وحدث خطأ
            if (isset($storedPath) && $storedPath) {
                try {
                    if ($disk->exists($storedPath)) {
                        $disk->delete($storedPath);
                    }
                } catch (\Exception $ex) {
                    Log::warning("Failed to cleanup file on {$this->diskName}: " . $ex->getMessage());
                }
            }

            Log::error("Upload Error ($type): " . $e->getMessage());
            return response()->json(['error' => 'Server Error', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * ✅ Download (Public) - Redirect إلى رابط Wasabi مؤقت 10 دقائق
     */
public function download(Request $request, $type, $username, $repo_name, $filename) {
    $config = ['models' => 'ai-models', 'repos' => 'repos', 'datasets' => 'datasets'];
    if (!isset($config[$type])) return response()->json(['error' => 'Invalid type'], 400);

    $path = "{$config[$type]}/{$username}/{$repo_name}/{$filename}";
    $disk = Storage::disk('wasabi');

    if ($disk->exists($path)) {
        // ✅ 1. البحث باستخدام الموديل الصحيح AiModel وليس Repository
        $modelRecord = \App\Models\AiModel::where('slug', $repo_name)->first();

        // ✅ 2. التأكد من وجود الموديل قبل محاولة التسجيل
        if ($modelRecord) {
            $modelRecord->stats()->create([
                // لارفيل سيقوم بتعبئة model_id تلقائياً إذا كانت العلاقة صحيحة
                'platform'   => str_contains($request->header('User-Agent'), 'colab') ? 'colab' : 'api',
                'ip_address' => $request->ip(),
                'executed_at' => now(),
            ]);
        }

        // 3. توليد الرابط المؤقت (Temporary URL)
        return redirect()->away($disk->temporaryUrl($path, now()->addMinutes(10)));
    }

    return response()->json(['error' => 'File not found'], 404);
}
}
