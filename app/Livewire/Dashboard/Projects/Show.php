<?php

namespace App\Livewire\Dashboard\Projects;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.dashboard')]
class Show extends Component
{
    use WithFileUploads;

    public Project $project;
    public User $user;
    public $projectZip;
    public $currentPath = ''; // المسار الحالي الذي يتصفحه المستخدم

    // التحكم بالتبويبات
    public $activeTab = 'code';

    // متغيرات التعديل (للإعدادات)
    public $edit_title;
    public $edit_description;
    public $edit_visibility;

    // متغيرات الملفات
    public $newFiles = [];
    public $fileIdToDelete;

    public $isDeletingAll = false; // مؤشر: هل الحذف للكل؟
public $deleteModalMessage = ''; // رسالة المودال المتغيرة

public $readmeContent;
    public $isEditingReadme = false; // لتحديد وضع التعديل أو العرض

    public function mount($username, $slug)
    {
        $this->user = User::where('username', $username)->firstOrFail();

        $this->project = $this->user->projects()
            ->where('slug', $slug)
            ->firstOrFail();

        // التحقق من الصلاحيات للمشاريع الخاصة
        if (! $this->project->is_public) {
            $isOwner = Auth::id() === $this->user->id;
            $isMember = $this->project->members()->where('user_id', Auth::id())->exists();

            if (! $isOwner && ! $isMember) {
                abort(403, 'هذا المشروع خاص.');
            }
        }

        $this->edit_title = $this->project->title;
        $this->edit_description = $this->project->description;
        $this->edit_visibility = $this->project->is_public ? 'public' : 'private';

        $this->project = $this->project;
        // تحميل المحتوى الموجود أو وضع نص افتراضي
        $this->readmeContent = $this->project->readme_content;
    }
    
    public function uploadZipProject()
{
    // 1. التحقق من الصلاحيات والملف
    if (!in_array($this->current_role ?? 'owner', ['owner', 'admin', 'write'])) abort(403);

    $this->validate([
        'projectZip' => 'required|file|mimes:zip|max:102400', // 100MB Max
    ]);

    $zip = new ZipArchive;
    $res = $zip->open($this->projectZip->getRealPath());

    if ($res === TRUE) {
        $uploadedCount = 0;

        // الدوران على الملفات داخل الـ Zip
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            
            // تجاهل المجلدات الفارغة وملفات الماك المخفية
            if (substr($filename, -1) == '/' || str_contains($filename, '__MACOSX') || str_starts_with($filename, '.')) {
                continue;
            }

            // قراءة محتوى الملف من الذاكرة مباشرة
            $content = $zip->getFromIndex($i);
            
            // تحديد المسار الكامل (يشمل المجلدات الفرعية)
            // Wasabi سيقوم بإنشاء المجلدات تلقائياً بناءً على الاسم
            $fullPath = 'projects/' . Auth::id() . '/' . $this->project->slug . '/' . $filename;

            // ===========================================
            // هنا يمكنك إضافة كود الفحص الأمني (API) إذا أردت
            // ===========================================

            // الرفع إلى Wasabi
            Storage::disk('wasabi')->put($fullPath, $content);

            // الحفظ في قاعدة البيانات
            // نستخدم basename للحصول على اسم الملف فقط، والمسار الكامل في path
            $cleanFilename = basename($filename);
            
            $this->project->files()->create([
                'filename'  => $cleanFilename, // اسم الملف فقط
                'path'      => $fullPath,      // المسار الكامل (شامل المجلدات)
                'extension' => pathinfo($filename, PATHINFO_EXTENSION),
                'size'      => strlen($content),
                'user_id'   => Auth::id(),
            ]);

            $uploadedCount++;
        }

        $zip->close();
        $this->reset('projectZip');

        $this->dispatch('notify', 
            type: 'success', 
            title: 'تم الرفع', 
            message: "تم فك الضغط ورفع {$uploadedCount} ملف/ملفات بنجاح."
        );

    } else {
        $this->dispatch('notify', type: 'error', title: 'خطأ', message: 'لا يمكن فتح ملف الـ Zip.');
    }
}
    
public function editReadme()
    {
        // التحقق من الصلاحية
        if ($this->project->user_id !== Auth::id()) {
            abort(403);
        }
        $this->isEditingReadme = true;
    }

    // دالة إلغاء التعديل
    public function cancelEditReadme()
    {
        $this->readmeContent = $this->project->readme_content; // استعادة النص الأصلي
        $this->isEditingReadme = false;
    }
public function downloadAll()
{
    // 1. التأكد من وجود ملفات
    if ($this->project->files->isEmpty()) {
        $this->dispatch('notify', type: 'error', title: 'خطأ', message: 'المشروع فارغ.');
        return;
    }

    // 2. تجهيز ملف الـ Zip
    $zipFileName = $this->project->slug . '-' . date('Ymd-His') . '.zip';
    $zipPath = storage_path('app/public/' . $zipFileName);

    // التأكد من وجود المجلد
    if (!is_dir(dirname($zipPath))) {
        mkdir(dirname($zipPath), 0755, true);
    }

    $zip = new ZipArchive;

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

        foreach ($this->project->files as $file) {
            // التعديل هنا: قراءة محتوى الملف من Wasabi وإضافته للـ Zip
            if (Storage::disk('wasabi')->exists($file->path)) {

                // نقرأ محتوى الملف من السحابة
                $content = Storage::disk('wasabi')->get($file->path);

                // نضعه داخل الـ Zip (اسم الملف داخل الـ Zip، المحتوى)
                $zip->addFromString($file->filename, $content);
            }
        }

        $zip->close();

        // 3. التحميل
        return response()->download($zipPath)->deleteFileAfterSend(true);
    } else {
        $this->dispatch('notify', type: 'error', title: 'خطأ', message: 'فشل إنشاء الملف المضغوط.');
    }
}
    // دالة الحفظ
    public function saveReadme()
    {
        if ($this->project->user_id !== Auth::id()) {
            abort(403);
        }

        $this->validate([
            'readmeContent' => 'nullable|string|max:50000',
        ]);

        $this->project->update([
            'readme_content' => $this->readmeContent
        ]);

        $this->project->refresh();

        $this->isEditingReadme = false;

        $this->dispatch('notify',
            type: 'success',
            title: 'تم الحفظ',
            message: 'تم تحديث ملف Readme بنجاح.'
        );
    }
    
    public function getBrowserItemsProperty()
{
    // 1. تحديد المسار الأساسي للمشروع في Wasabi
    $basePath = 'projects/' . $this->project->user_id . '/' . $this->project->slug . '/';
    
    // 2. تصفية الملفات التي تبدأ بالمسار الحالي وتتبع المسار الأساسي
    // مثال: نريد الملفات داخل folder1/
    // المسار الكامل للبحث: projects/1/demo/folder1/
    $targetPath = $basePath . ($this->currentPath ? $this->currentPath . '/' : '');
    
    $items = [];
    $processedFolders = [];

    foreach ($this->project->files as $file) {
        // هل الملف يقع ضمن المسار المستهدف؟
        if (str_starts_with($file->path, $targetPath)) {
            
            // استخراج الجزء المتبقي من المسار (النسبي)
            $relativePath = substr($file->path, strlen($targetPath));
            
            // هل هذا ملف مباشر أم مجلد؟
            if (str_contains($relativePath, '/')) {
                // هذا مجلد
                $folderName = explode('/', $relativePath)[0];
                
                if (!in_array($folderName, $processedFolders)) {
                    $items[] = [
                        'type' => 'folder',
                        'name' => $folderName,
                        'path' => ($this->currentPath ? $this->currentPath . '/' : '') . $folderName,
                        'last_modified' => $file->created_at, // نأخذ تاريخ أول ملف داخله
                    ];
                    $processedFolders[] = $folderName;
                }
            } else {
                // هذا ملف
                $items[] = [
                    'type' => 'file',
                    'name' => $file->filename,
                    'file_id' => $file->id, // نحتاجه للتحميل والحذف
                    'size' => $file->size_for_humans ?? '0 B', // تأكد من وجود Accessor للحجم في المودل
                    'last_modified' => $file->created_at,
                    'extension' => $file->extension,
                ];
            }
        }
    }

    // ترتيب: المجلدات أولاً، ثم الملفات
    usort($items, function ($a, $b) {
        if ($a['type'] === $b['type']) {
            return strnatcasecmp($a['name'], $b['name']);
        }
        return $a['type'] === 'folder' ? -1 : 1;
    });

    return $items;
}

// --- دوال التنقل ---
public function navigateTo($folderPath)
{
    $this->currentPath = $folderPath;
}

public function navigateUp()
{
    if (!$this->currentPath) return;
    
    $parts = explode('/', $this->currentPath);
    array_pop($parts);
    $this->currentPath = implode('/', $parts);
}
    // خاصية لتحديد دور المستخدم الحالي
    public function getCurrentRoleProperty()
    {
        if (Auth::id() === $this->project->user_id) {
            return 'owner';
        }

        $member = $this->project->members()->where('user_id', Auth::id())->first();
        return $member ? $member->pivot->role : null;
    }

    // تحديث إعدادات المشروع
    public function updateProject()
    {
        if (!in_array($this->current_role, ['owner', 'admin'])) abort(403);

        $this->validate([
            'edit_title' => 'required|min:2|max:255',
            'edit_description' => 'nullable|string|max:1000',
            'edit_visibility' => 'required|in:public,private',
        ]);

        // ====================================================
        //  فحص الاسم الجديد عبر الـ API (Port 6000)
        // ====================================================
        try {
            // نرسل الاسم الجديد للفحص
            $response = Http::timeout(5)->post('http://77.83.242.109:6000/validate', [
                'name' => $this->edit_title,
            ]);

            // إذا رد السيرفر بنجاح (200 OK)
            if ($response->successful()) {
                $result = $response->json();

                // إذا كان الاسم محظوراً
                if (($result['status'] ?? '') === 'blocked') {
                    $reason = $result['reasons'][0]['description'] ?? 'الاسم غير مناسب.';

                    // نرسل تنبيه ونوقف العملية
                    $this->dispatch('notify',
                        type: 'error',
                        title: 'الاسم مرفوض',
                        message: "عذراً، لا يمكن استخدام هذا الاسم: {$reason}"
                    );

                    return; // 🛑 إيقاف التنفيذ هنا، ما يكمل للحفظ
                }
            }

        } catch (\Exception $e) {
            // في حال فشل الاتصال بالسيرفر، نسجل الخطأ ونكمل (أو توقف حسب رغبتك)
            Log::warning("Project name validation failed: " . $e->getMessage());
        }

        // ====================================================
        //  الحفظ في قاعدة البيانات (إذا عدى الفحص)
        // ====================================================
        $this->project->update([
            'title' => $this->edit_title,
            'description' => $this->edit_description,
            'is_public' => $this->edit_visibility === 'public',
        ]);

        $this->dispatch('notify',
            type: 'success',
            title: 'تم الحفظ',
            message: 'تم حفظ إعدادات المشروع بنجاح.'
        );
    }
    // رفع الملفات
public function uploadFiles()
{
    // 1. التحقق من الصلاحيات
    if (!in_array($this->current_role ?? 'owner', ['owner', 'admin', 'write'])) {
        abort(403);
    }

    // 2. التحقق من صحة المدخلات (مصفوفة ملفات)
    $this->validate([
        'newFiles.*' => 'file|max:51200', // 50MB لكل ملف
    ]);

    $uploadedCount = 0;

    // الدوران على كل ملف في المصفوفة
    foreach ($this->newFiles as $file) {

        $realPath = $file->getRealPath();
        $filename = $file->getClientOriginalName();

        // ====================================================
        // أ) فحص اسم الملف (API Port 6000)
        // ====================================================
        try {
            $nameResponse = Http::timeout(5)->post('http://77.83.242.109:6000/validate', [
                'name' => $filename,
            ]);

            if ($nameResponse->failed()) {
                throw new \Exception('فشل الاتصال بخدمة الأسماء');
            }

            $nameResult = $nameResponse->json();

            // إذا كان الاسم محظوراً
            if (($nameResult['status'] ?? '') === 'blocked') {
                $reason = $nameResult['reasons'][0]['description'] ?? 'الاسم غير مناسب.';

                // إشعار الخطأ (بنفس أسلوبك القديم)
                $this->dispatch('notify',
                    type: 'error',
                    title: 'اسم ملف مرفوض',
                    message: "تم رفض الملف ({$filename}): {$reason}"
                );

                continue; // نتخطى هذا الملف ونروح للي بعده
            }

        } catch (\Exception $e) {
            // خطأ تقني في فحص الاسم (اختياري: هل نوقف أم نكمل؟ هنا سنكمل مع تحذير)
            Log::warning("Name check failed for {$filename}");
        }

        // ====================================================
        // ب) الفحص الأمني (API Port 5000)
        // ====================================================
        try {
            $stream = fopen($realPath, 'r');

            $securityResponse = Http::timeout(60)
                ->attach('file', $stream, $filename)
                ->post('http://77.83.242.109:5000/scan');

            if (is_resource($stream)) fclose($stream);

            $security = $securityResponse->json();

        } catch (\Throwable $e) {
            Log::error("Security scan error for {$filename}: " . $e->getMessage());

            $this->dispatch('notify',
                type: 'error',
                title: 'فشل الاتصال',
                message: "تعذر فحص الملف ({$filename}) أمنياً."
            );
            continue; // نتخطى الملف إذا فشل الفحص الأمني (للحماية)
        }

        // إذا كان الملف محظوراً أمنياً
        if (($security['status'] ?? '') === 'blocked') {
            $reason = $security['reasons'][0]['description'] ?? 'محتوى ضار.';

            $this->dispatch('notify',
                type: 'error',
                title: 'ملف ضار',
                message: "تم رفض الملف ({$filename}): {$reason}"
            );
            continue; // نتخطى هذا الملف
        }

        // ====================================================
        // ج) فحص جودة الكود (API Port 7000)
        // ====================================================
        $issues = [];
        try {
            $stream = fopen($realPath, 'r');
            $qualityResponse = Http::timeout(30)
                ->attach('file', $stream, $filename)
                ->post('http://77.83.242.109:7000/code-check');

            if (is_resource($stream)) fclose($stream);

            if ($qualityResponse->ok()) {
                $issues = $qualityResponse->json()['issues'] ?? [];
            }
        } catch (\Throwable $e) {
            Log::warning("Quality check skipped for {$filename}");
        }

        // ====================================================
        // د) الحفظ في قاعدة البيانات
        // ====================================================
        DB::transaction(function () use ($file, $filename, $issues) {
  $path = $file->store(
    'projects/' . Auth::id() . '/' . $this->project->slug,
    'wasabi' // <--- غيرنا public إلى wasabi
);

            $this->project->files()->create([
                'filename'  => $filename,
                'path'      => $path,
                'extension' => $file->getClientOriginalExtension(),
                'size'      => $file->getSize(),
                'user_id'   => Auth::id(),
            ]);

            // عرض ملاحظات الجودة لهذا الملف (بنفس دالتك القديمة)
            if (!empty($issues)) {
                $this->sendQualityToast($filename, $issues);
            }
        });

        $uploadedCount++;
    }

    // 3. التنظيف والإنهاء
    $this->reset('newFiles');

    // إشعار النجاح النهائي (يظهر مرة واحدة في النهاية)
    if ($uploadedCount > 0) {
        $this->dispatch('notify',
            type: 'success',
            title: 'اكتملت العملية',
            message: "تم رفع {$uploadedCount} ملف/ملفات بنجاح."
        );
    }
}

// دالة خاصة لتنسيق رسالة التنبيه (HTML) لتناسب تصميمك
private function sendQualityToast($filename, $issues)
{
    // نستخدم Tailwind Classes لتنسيق القائمة داخل التنبيه
    // dir="ltr" مهم للأكواد البرمجية
    $html = '<ul class="list-disc pl-4 mt-2 space-y-1 text-xs font-mono text-slate-600" dir="ltr" style="text-align: left;">';

    // نأخذ أول 3 أخطاء فقط حتى لا يتشوه شكل التنبيه الصغير
    $limitedIssues = array_slice($issues, 0, 3);

    foreach ($limitedIssues as $issue) {
        // تنظيف الرسالة
        $cleanMsg = str_replace(['/tmp/', '.py'], '', $issue['message']);
        $cleanMsg = Str::limit($cleanMsg, 50); // تقصير النص

        $html .= "<li>
                    <span class='font-bold text-amber-600'>Line {$issue['line']}:</span>
                    {$cleanMsg}
                  </li>";
    }

    // إذا كان هناك المزيد
    if (count($issues) > 3) {
        $remaining = count($issues) - 3;
        $html .= "<li class='list-none pt-1 text-slate-400 italic'>+ {$remaining} ملاحظات أخرى...</li>";
    }

    $html .= '</ul>';

    // إرسال التنبيه
    $this->dispatch('notify',
        type: 'warning',
        title: "ملاحظات جودة: {$filename}",
        message: $html
    );
}









    // فتح مودال الحذف
    public function confirmDeleteFile($fileId)
    {
        $this->fileIdToDelete = $fileId;
        $this->dispatch('open-delete-modal-file');
    }
    public function confirmDeleteAll()
{
    // 1. التحقق من الصلاحيات
    if ($this->project->user_id !== Auth::id()) {
        abort(403);
    }

    // 2. تجهيز المودال لحذف الكل
    $this->isDeletingAll = true;
    $this->fileIdToDelete = null; // نصفر ايدي الملف الفردي

    // نغير الرسالة لتناسب خطورة الموقف
    $this->deleteModalMessage = "تحذير: هل أنت متأكد من حذف جميع الملفات ({$this->project->files()->count()})؟ هذا الإجراء لا يمكن التراجع عنه.";

    // 3. فتح المودال (نفس الدسباتش اللي تستخدمه للملف الفردي)
    // ملاحظة: تأكد ان الاسم هنا يطابق الـ event listener في المودال حقك
    $this->dispatch('open-delete-modal-file');
}

    // تنفيذ الحذف بعد التأكيد
    public function deleteFileConfirmed()
    {
        if ($this->isDeletingAll) {
        $this->deleteAllFilesImplementation(); // دالة التنفيذ تحت
        $this->isDeletingAll = false; // تصفير الحالة
    }
    // الحالة ب: حذف ملف واحد (كودك القديم)
    elseif ($this->fileIdToDelete) {
        $this->deleteFile($this->fileIdToDelete); // دالة الحذف الفردي الموجودة عندك
        $this->fileIdToDelete = null;
    }

    // إغلاق المودال
    $this->dispatch('close-delete-modal-file');
    }

protected function deleteAllFilesImplementation()
{
    foreach ($this->project->files as $file) {
        // حذف من التخزين
        \Illuminate\Support\Facades\Storage::disk('wasabi')->delete($file->path);
    }
    // حذف من قاعدة البيانات
    $this->project->files()->delete();

    $this->dispatch('notify',
        type: 'success',
        title: 'تم الحذف',
        message: 'تم تنظيف المشروع وحذف جميع الملفات.'
    );
}

    // دالة حذف الملف
    public function deleteFile($fileId)
    {
        if (!in_array($this->current_role, ['owner', 'admin', 'write'])) abort(403);

        $file = ProjectFile::findOrFail($fileId);

        if($file->project_id !== $this->project->id) abort(403);

        if (Storage::disk('wasabi')->exists($file->path)) {
            Storage::disk('wasabi')->delete($file->path);
        }

        $file->delete();

        // ✅ تصحيح الإشعار
        $this->dispatch('notify',
            type: 'success',
            title: 'تم الحذف',
            message: 'تم حذف الملف بنجاح.'
        );
    }

    // حماية التبويبات وتغييرها
    public function updatedActiveTab($value)
    {
        $role = $this->current_role;

        $allowedTabs = [
            'code' => ['owner', 'admin', 'write', 'read'],
            'settings' => ['owner', 'admin'],
            'team' => ['owner'],
        ];

        if (!isset($allowedTabs[$value]) || !in_array($role, $allowedTabs[$value])) {
            $this->activeTab = 'code';

            // ✅ تصحيح الإشعار
            $this->dispatch('notify',
                type: 'error',
                title: 'صلاحيات غير كافية',
                message: 'ليس لديك صلاحية للوصول لهذا التبويب.'
            );
        }
    }

    // تنزيل الملف
    public function downloadFile($fileId)
    {
        $file = ProjectFile::findOrFail($fileId);

        if ($file->project_id !== $this->project->id) {
            abort(403);
        }

        if (Storage::disk('wasabi')->exists($file->path)) {
            return Storage::disk('wasabi')->download($file->path, $file->filename);
        } else {
            // ✅ تصحيح الإشعار
            $this->dispatch('notify',
                type: 'error',
                title: 'خطأ',
                message: 'عذراً، يبدو أن الملف غير موجود في الخادم.'
            );
        }
    }

    public function toJSON()
    {
        return [];
    }

    // حذف المشروع بالكامل
    public function deleteProject()
    {
        if ($this->current_role !== 'owner') abort(403, 'فقط المالك يمكنه حذف المشروع.');

        foreach ($this->project->files as $file) {
            if (Storage::disk('wasabi')->exists($file->path)) {
                Storage::disk('wasabi')->delete($file->path);
            }
        }

        // حذف المجلد بالكامل (اختياري)
        // Storage::disk('wasabi')->deleteDirectory('projects/' . $this->project->id);

        $this->project->delete();

        return redirect()->route('dashboard.repos')->with('success', 'تم حذف المشروع بنجاح.');
    }

    public function render()
    {
        return view('livewire.dashboard.projects.show');
    }
}
