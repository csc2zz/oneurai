<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    /**
     * الحقول القابلة للتعبئة (Mass Assignment).
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'subject',
        'priority',
        'message',
        'status',
    ];

    /**
     * الحصول على المستخدم صاحب التذكرة.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}