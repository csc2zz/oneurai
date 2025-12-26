<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];

    // هذا الجزء هو الأهم لتحويل البيانات تلقائياً
    protected $casts = [
        'platforms'   => 'array', // يحول JSON من الداتابيز إلى Array في الكود والعكس
        'screenshots' => 'array',
        'is_published' => 'boolean',
        'quiz_data'    => 'array', // أضف هذا السطر
    ];

    // علاقة اللعبة بالمطور
    public function developer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}