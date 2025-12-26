<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelStat extends Model
{
    // السماح بتعبئة هذه الحقول برمجياً
    protected $fillable = ['model_id', 'platform', 'ip_address', 'executed_at'];

    // لارفيل سيبحث عن جدول اسمه model_stats تلقائياً
    // ولأننا نريد استخدام executed_at كـ Timestamp:
    protected $casts = [
        'executed_at' => 'datetime',
    ];
    
    public $timestamps = false; // لأننا نستخدم executed_at يدوياً
}