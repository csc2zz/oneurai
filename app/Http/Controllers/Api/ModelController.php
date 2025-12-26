<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\AiModel;

class ModelController extends Controller
{
    /**
     * عرض تفاصيل نموذج معين (Metadata Only).
     * الرابط المقترح: GET /api/models/{username}/{repo_name}
     */
    public function show($username, $repo_name)
    {
        // البحث عن الموديل
        $model = AiModel::where('username', $username)
            ->where('slug', $repo_name)
            ->with('files') // جلب ملفاته المرتبطة
            ->first();

        if (!$model) {
            return response()->json(['error' => 'Model not found'], 404);
        }

        // إذا كان الموديل خاصاً، تحقق من الصلاحية (يمكنك تفعيل هذا الجزء)
        /*
        if (!$model->is_public && $request->user()->id !== $model->user_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        */

        return response()->json([
            'success' => true,
            'data' => $model
        ]);
    }

    /**
     * تحديث بيانات النموذج (الوصف، الحالة العامة/الخاصة، التاجات).
     * الرابط المقترح: PUT /api/models/{username}/{repo_name}
     */
    public function update(Request $request, $username, $repo_name)
    {
        $user = $request->user();

        // التأكد من الملكية
        $model = AiModel::where('username', $username)
            ->where('slug', $repo_name)
            ->where('user_id', $user->id)
            ->first();

        if (!$model) {
            return response()->json(['error' => 'Model not found or unauthorized'], 404);
        }

        // التحقق من المدخلات
        $request->validate([
            'description' => 'nullable|string|max:1000',
            'is_public'   => 'boolean',
            'license'     => 'nullable|string',
            'task'        => 'nullable|string',
        ]);

        // تحديث البيانات
        $model->update($request->only([
            'description', 
            'is_public', 
            'license', 
            'task'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Model updated successfully',
            'data' => $model
        ]);
    }

    /**
     * حذف النموذج بالكامل مع ملفاته.
     * الرابط المقترح: DELETE /api/models/{username}/{repo_name}
     */
    public function destroy(Request $request, $username, $repo_name)
    {
        $user = $request->user();

        // التأكد من الملكية
        $model = AiModel::where('username', $username)
            ->where('slug', $repo_name)
            ->where('user_id', $user->id)
            ->first();

        if (!$model) {
            return response()->json(['error' => 'Model not found or unauthorized'], 404);
        }

        try {
            // 1. حذف الملفات الفيزيائية من السيرفر/S3
            // المسار: models/username/repo_name
            $directory = "models/{$username}/{$repo_name}";
            
            if (Storage::exists($directory)) {
                Storage::deleteDirectory($directory);
            }

            // 2. حذف سجلات الملفات من قاعدة البيانات (يتم تلقائياً إذا كنت تستخدم Cascade on Delete)
            $model->files()->delete();

            // 3. حذف الموديل نفسه
            $model->delete();

            return response()->json([
                'success' => true,
                'message' => 'Model and associated files deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete model', 'details' => $e->getMessage()], 500);
        }
    }
}