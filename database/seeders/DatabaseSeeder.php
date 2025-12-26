<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
public function run(): void
{
    // 1. جلب المستخدم الأول (أنت) أو إنشاؤه إذا لم يوجد
    $user = User::first() ?? User::factory()->create([
        'name' => 'أحمد علي',
        'email' => 'admin@oneurai.com',
        'username' => 'ahmed_dev',
        'password' => bcrypt('password'), // كلمة مرور للتجربة
    ]);

    // 2. إنشاء 15 مستودع (Repo) خاص بك
    Project::factory(15)->create([
        'user_id' => $user->id,
        'type' => 'repo', // نجبره يكون مستودع
    ]);

    // 3. إنشاء 5 نماذج (Models) خاصة بك (للمستقبل)
    Project::factory(5)->create([
        'user_id' => $user->id,
        'type' => 'model',
    ]);

     // 4. إنشاء 8 مجموعات بيانات (Datasets) خاصة بك
    Project::factory(8)->create([
        'user_id' => $user->id,
        'type' => 'dataset',
    ]);

    echo "تمت إضافة مشاريع وهمية للمستخدم: {$user->name} ✅\n";
}
}
