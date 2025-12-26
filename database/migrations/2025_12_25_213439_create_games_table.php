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
        Schema::create('games', function (Blueprint $table) {
$table->id();
        $table->string('title');
        $table->string('slug')->unique(); // لرابط اللعبة
        $table->text('description')->nullable();
        $table->string('thumbnail')->nullable(); // صورة الغلاف
        
        // نوع اللعبة: html5 (للمتصفح) أو download (للبايثون وغيره)
        $table->enum('type', ['html5', 'download'])->default('html5');
        
        // مسار ملف اللعبة
        $table->string('game_path'); 
        
        // ارتفاع وعرض الـ iframe (للألعاب الويب)
        $table->integer('width')->default(800);
        $table->integer('height')->default(600);
        
        $table->boolean('is_active')->default(true);
        $table->string('external_download_link')->nullable();
    
    // حجم اللعبة
    $table->string('game_size')->nullable(); // e.g. "2.4 GB"
    
    // مواصفات التشغيل (اختياري)
    $table->string('platform')->default('Windows'); // Windows, Mac, Linux
    $table->text('min_requirements')->nullable(); // كرت الشاشة، الرامات...
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
