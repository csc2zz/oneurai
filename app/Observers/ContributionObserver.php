<?php

namespace App\Observers;

use App\Models\Contribution;
use Illuminate\Database\Eloquent\Model;

class ContributionObserver
{
    /**
     * Handle the Model "created" event.
     * يتم تنفيذ هذه الدالة تلقائياً عند إنشاء أي سجل جديد في الموديلات المراقبة
     */
    public function created(Model $model): void
    {
        // 1. التحقق: هل الموديل يحتوي على user_id؟ (لأننا نحتاج لربط المساهمة بصاحبها)
        // وهل المستخدم مسجل دخول فعلاً (احتياطاً) أو الحقل ليس فارغاً
        if (!empty($model->user_id)) {

            // 2. تسجيل المساهمة في الجدول الجديد
            Contribution::create([
                'user_id' => $model->user_id,

                // type: نأخذ اسم الكلاس فقط (مثلاً "Project" أو "Dataset")
                // class_basename تحول "App\Models\Project" إلى "Project"
                'type' => class_basename($model),

                // created_at: سيأخذ الوقت الحالي تلقائياً، وهو ما يحدد موقع المربع في الرسم
            ]);
        }
    }

    /**
     * يمكنك إضافة دوال أخرى هنا لو أردت
     * مثلاً deleted لحذف المساهمة إذا حذف المستخدم مشروعه
     */
    public function deleted(Model $model): void
    {
        // اختياري: حذف المساهمة إذا تم حذف الأصل
        Contribution::where('user_id', $model->user_id)
            ->where('type', class_basename($model))
            ->whereDate('created_at', $model->created_at->toDateString()) // مقارنة تقريبية
            ->first()
            ?->delete();
    }
}
