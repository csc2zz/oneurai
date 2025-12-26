<?php

namespace App\Observers;

use App\Models\AiModel; // تأكد من اسم المودل لديك (قد يكون Model فقط)
use App\Notifications\SystemNotification;

class AiModelObserver
{
    public function created(AiModel $model)
    {
        $model->user->notify(new SystemNotification(
            'نموذج جديد',
            "تم إنشاء النموذج \"{$model->title}\" بنجاح وجاري معالجته.",
            route('models.show', [$model->user->username, $model->slug]),
            'fa-brain', // أيقونة معبرة للذكاء الاصطناعي
            'text-purple-600'
        ));
    }

    public function updated(AiModel $model)
    {
        if($model->isDirty(['title', 'description', 'version'])) {
            $model->user->notify(new SystemNotification(
                'تحديث النموذج',
                "تم تحديث بيانات النموذج \"{$model->title}\".",
                route('models.show', [$model->user->username, $model->slug]),
                'fa-sliders',
                'text-blue-500'
            ));
        }
    }

    public function deleted(AiModel $model)
    {
        $model->user->notify(new SystemNotification(
            'حذف نموذج',
            "تم حذف النموذج \"{$model->title}\" نهائياً.",
            '#',
            'fa-trash',
            'text-red-500'
        ));
    }
}
