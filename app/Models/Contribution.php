<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    /**
     * الحقول المسموح بتعبئتها جماعياً (Mass Assignment)
     */
    protected $fillable = [
        'user_id',
        'type',
        'created_at', // مهم جداً إضافته لأننا نمرره يدوياً لمطابقة التواريخ
    ];
}
