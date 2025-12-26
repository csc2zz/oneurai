<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // 1. إضافة الأعمدة الناقصة (التي ظهرت في الخطأ)
            if (!Schema::hasColumn('games', 'price')) {
                $table->decimal('price', 8, 2)->default(0)->after('description');
            }
            if (!Schema::hasColumn('games', 'version')) {
                $table->string('version')->default('1.0.0')->after('price');
            }
            if (!Schema::hasColumn('games', 'screenshots')) {
                $table->json('screenshots')->nullable()->after('thumbnail');
            }

            // 2. تعديل عمود النوع (type) ليقبل القيم الجديدة (quiz, upload)
            // سنحوله إلى string ليكون مرناً ويقبل أي نوع
            $table->string('type')->change();

            // 3. تعديل أسماء الأعمدة لتتطابق مع الكود (Create.php)
            // تغيير game_path إلى game_file
            if (Schema::hasColumn('games', 'game_path')) {
                $table->renameColumn('game_path', 'game_file');
            }

            // تغيير is_active إلى is_published
            if (Schema::hasColumn('games', 'is_active')) {
                $table->renameColumn('is_active', 'is_published');
            }
            
            // تغيير platform (المفرد) إلى platforms (الجمع) وتحويله لـ JSON
            if (Schema::hasColumn('games', 'platform')) {
                $table->renameColumn('platform', 'platforms');
            }
        });

        // خطوة منفصلة للتأكد من تغيير نوع platforms إلى JSON أو Text ليقبل المصفوفات
        Schema::table('games', function (Blueprint $table) {
            $table->text('platforms')->nullable()->change();
        });
    }

    public function down(): void
    {
        // التراجع عن التعديلات (اختياري)
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['price', 'version', 'screenshots']);
            $table->renameColumn('game_file', 'game_path');
            $table->renameColumn('is_published', 'is_active');
            $table->renameColumn('platforms', 'platform');
        });
    }
};