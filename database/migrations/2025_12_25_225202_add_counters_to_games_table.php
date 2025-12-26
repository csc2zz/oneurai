<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // إضافة عداد المشاهدات
            if (!Schema::hasColumn('games', 'views_count')) {
                $table->unsignedBigInteger('views_count')->default(0)->after('is_published');
            }

            // إضافة عداد التحميلات
            if (!Schema::hasColumn('games', 'downloads_count')) {
                $table->unsignedBigInteger('downloads_count')->default(0)->after('views_count');
            }
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['views_count', 'downloads_count']);
        });
    }
};