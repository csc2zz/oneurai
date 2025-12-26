<?php

namespace App\Observers;

use App\Models\DatasetFile;
use App\Notifications\SystemNotification;

class DatasetFileObserver
{
    public function created(DatasetFile $file)
    {
        if ($file->dataset && $file->dataset->user) {
        $file->dataset->user->notify(new SystemNotification(
            'ملف جديد',
            "تم رفع الملف \"{$file->filename}\" إلى مجموعة البيانات \"{$file->dataset->title}\".",
            route('dashboard.models.view', [
                'username' => $file->dataset->user->username,
                'slug' => $file->dataset->slug,
                'tab' => 'files' // نوجهه لتبويب الملفات مباشرة
            ]),
            'fa-file-arrow-up',
            'text-emerald-600'
        ));
    }
    }

    public function deleted(DatasetFile $file)
    {
        $file->dataset->user->notify(new SystemNotification(
            'حذف ملف',
            "تم حذف الملف \"{$file->filename}\" من مجموعة البيانات \"{$file->dataset->title}\".",
            route('dashboard.models.view', [
                'username' => $file->dataset->user->username,
                'slug' => $file->dataset->slug,
                'tab' => 'files'
            ]),
            'fa-file-circle-xmark',
            'text-red-500'
        ));
    }
}
