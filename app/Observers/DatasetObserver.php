<?php

namespace App\Observers;

use App\Models\Dataset;
use App\Notifications\SystemNotification;

class DatasetObserver
{
    public function created(Dataset $dataset)
    {
        $dataset->user->notify(new SystemNotification(
            'تم إنشاء بيانات جديدة',
            "تم إنشاء مجموعة البيانات \"{$dataset->title}\" بنجاح.",
            route('dashboard.models.view', [$dataset->user->username, $dataset->slug]), // تأكد من اسم الراوت لديك
            'fa-database',
            'text-emerald-500'
        ));
    }

    public function updated(Dataset $dataset)
    {
        // نتجنب الإشعار عند تحديث أرقام التحميلات فقط
        if($dataset->isDirty(['title', 'description', 'visibility', 'access_type'])) {
            $dataset->user->notify(new SystemNotification(
                'تحديث البيانات',
                "تم تحديث خصائص مجموعة البيانات \"{$dataset->title}\".",
                route('dashboard.models.view', [$dataset->user->username, $dataset->slug]),
                'fa-pen-to-square',
                'text-blue-500'
            ));
        }
    }

    public function deleted(Dataset $dataset)
    {
        $dataset->user->notify(new SystemNotification(
            'حذف بيانات',
            "تم حذف مجموعة البيانات \"{$dataset->title}\" نهائياً.",
            '#',
            'fa-trash-can',
            'text-red-500'
        ));
    }
}
