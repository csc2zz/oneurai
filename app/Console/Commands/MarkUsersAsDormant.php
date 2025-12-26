<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Enums\UserStatus;
use Carbon\Carbon;

class MarkUsersAsDormant extends Command
{
    // اسم الأمر الذي ستنفذه يدوياً لو أردت
    protected $signature = 'users:mark-dormant';
    protected $description = 'تحويل المستخدمين غير النشطين منذ 30 يوماً إلى حالة مهمل';

    public function handle()
    {
        $thirtyDaysAgo = now()->subDays(30);

        // جلب المستخدمين النشطين الذين لم يظهروا منذ 30 يوماً
        $count = User::where('status', UserStatus::ACTIVE)
            ->where('last_activity_at', '<', $thirtyDaysAgo)
            ->update(['status' => UserStatus::DORMANT]);

        $this->info("تم بنجاح تحويل {$count} مستخدم إلى حالة مهمل.");
    }
}