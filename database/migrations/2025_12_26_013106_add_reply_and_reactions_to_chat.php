<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
 Schema::table('messages', function (Blueprint $table) {
        $table->foreignId('parent_id')->nullable()->constrained('messages')->nullOnDelete();
    });

    // 2. إنشاء جدول الرياكشنات
    Schema::create('message_reactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('message_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('emoji'); // الإيموجي نفسه (👍, ❤️, 😂)
        $table->timestamps();
        
        // لمنع الشخص من عمل نفس الرياكشن مرتين على نفس الرسالة
        $table->unique(['message_id', 'user_id', 'emoji']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chat', function (Blueprint $table) {
            //
        });
    }
};
