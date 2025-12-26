<?php

namespace App\Observers;

use App\Models\ProjectFile;
use App\Notifications\SystemNotification;

class ProjectFileObserver
{
    public function created(ProjectFile $file)
    {
        // إشعار لصاحب المشروع عند رفع ملف جديد
        $file->project->user->notify(new SystemNotification(
            'ملف مشروع جديد',
            "تم إضافة الملف \"{$file->filename}\" إلى مشروع \"{$file->project->title}\".",
            route('projects.show', [
                'username' => $file->project->user->username,
                'slug' => $file->project->slug,
                'tab' => 'files' // نوجهه لتبويب الملفات
            ]),
            'fa-file-code', // أيقونة مختلفة لملفات الكود
            'text-indigo-500'
        ));
    }

    public function deleted(ProjectFile $file)
    {
        $file->project->user->notify(new SystemNotification(
            'حذف ملف مشروع',
            "تم حذف الملف \"{$file->filename}\" من مشروع \"{$file->project->title}\".",
            route('projects.show', [
                'username' => $file->project->user->username,
                'slug' => $file->project->slug,
                'tab' => 'files'
            ]),
            'fa-trash-can',
            'text-red-500'
        ));
    }
}
