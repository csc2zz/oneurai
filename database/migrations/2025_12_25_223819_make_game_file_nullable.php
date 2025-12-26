<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // جعل عمود ملف اللعبة يقبل القيمة الفارغة (للمسابقات)
            // تأكدنا من الاسم هل هو game_file أو game_path بناء على تعديلك السابق
            // إذا كنت نفذت التعديل السابق فالاسم هو game_file
            $table->string('game_file')->nullable()->change();
            
            // احتياطاً، نجعله nullable للحالات الأخرى
            if (Schema::hasColumn('games', 'game_path')) {
                 $table->string('game_path')->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // $table->string('game_file')->nullable(false)->change();
        });
    }
};