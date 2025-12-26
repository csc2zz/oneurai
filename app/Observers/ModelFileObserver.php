<?php

namespace App\Observers;

use App\Models\ModelFile;
use App\Notifications\SystemNotification;

class ModelFileObserver
{
    public function created(ModelFile $file)
    {
        // الوصول للمستخدم عبر علاقة aiModel
        // $file -> aiModel -> user
        $file->aiModel->user->notify(new SystemNotification(
            'ملف نموذج جديد',
            "تم إضافة الملف \"{$file->filename}\" إلى النموذج \"{$file->aiModel->title}\".",
            route('models.show', [
                'username' => $file->aiModel->user->username,
                'slug' => $file->aiModel->slug,
                'tab' => 'files' // توجيه مباشر لتبويب الملفات
            ]),
            'fa-file-code', // أيقونة ملف برمجية
            'text-purple-500' // لون بنفسجي مناسب لثيم الـ AI
        ));
    }

    public function deleted(ModelFile $file)
    {
        $file->aiModel->user->notify(new SystemNotification(
            'حذف ملف نموذج',
            "تم حذف الملف \"{$file->filename}\" من النموذج \"{$file->aiModel->title}\".",
            route('models.show', [
                'username' => $file->aiModel->user->username,
                'slug' => $file->aiModel->slug,
                'tab' => 'files'
            ]),
            'fa-trash-can',
            'text-red-500'
        ));
    }
}
