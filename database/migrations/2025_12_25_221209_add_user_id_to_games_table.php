<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('games', function (Blueprint $table) {
            // إضافة user_id بعد الـ id مباشرة
            $table->foreignId('user_id')
                  ->after('id') 
                  ->nullable() // نجعله nullable مؤقتاً إذا كان هناك بيانات سابقة
                  ->constrained('users')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
