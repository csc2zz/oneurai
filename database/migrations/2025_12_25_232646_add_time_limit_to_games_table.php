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
    Schema::table('games', function (Blueprint $table) {
        // الوقت بالثواني لكل سؤال (الافتراضي 0 = مفتوح)
        $table->unsignedInteger('time_limit')->default(0)->after('quiz_data');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            //
        });
    }
};
