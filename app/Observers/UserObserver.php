<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\SystemNotification;

class UserObserver
{
    public function updated(User $user)
    {
        // تنبيه عند تغيير كلمة المرور
        if ($user->wasChanged('password')) {
            $user->notify(new SystemNotification(
                'تنبيه أمني',
                "تم تغيير كلمة المرور الخاصة بحسابك. إذا لم تكن أنت، يرجى التواصل مع الدعم فوراً.",
                route('dashboard.profile'), // راوت إعدادات الحساب
                'fa-shield-halved',
                'text-red-600'
            ));
        }

        // تنبيه عند تغيير الإيميل أو الاسم
        if ($user->isDirty(['email', 'username'])) {
            $user->notify(new SystemNotification(
                'تحديث الحساب',
                "تم تحديث معلومات حسابك الأساسية.",
                route('dashboard.profile'),
                'fa-user-gear',
                'text-blue-500'
            ));
        }
    }
}
