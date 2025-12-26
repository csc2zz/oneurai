<?php

namespace App\Observers;

use App\Models\Project;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Auth;

class ProjectObserver
{
    // عند إنشاء مشروع جديد
    public function created(Project $project)
    {
        // إشعار لصاحب المشروع
        $project->user->notify(new SystemNotification(
            'مشروع جديد',
            "تم إنشاء المشروع {$project->title} بنجاح.",
            route('projects.show', [$project->user->username, $project->slug]),
            'fa-plus-circle',
            'text-emerald-500'
        ));
    }

    // عند التعديل
    public function updated(Project $project)
    {
        // نتأكد أن التعديل ليس مجرد تحديث للتاريخ
        if($project->isDirty('title') || $project->isDirty('description')) {
            $project->user->notify(new SystemNotification(
                'تحديث مشروع',
                "تم تحديث بيانات المشروع {$project->title}.",
                route('projects.show', [$project->user->username, $project->slug]),
                'fa-pen-to-square',
                'text-blue-500'
            ));
        }
    }

    // عند الحذف
    public function deleted(Project $project)
    {
        $project->user->notify(new SystemNotification(
            'حذف مشروع',
            "تم حذف المشروع {$project->title}.",
            '#',
            'fa-trash',
            'text-red-500'
        ));
    }
}
