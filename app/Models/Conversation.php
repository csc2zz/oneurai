<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'last_message_at',
        'status', // pending, accepted, rejected
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // ✅ العلاقة التي تسبب الخطأ: آخر رسالة
    public function lastMessage()
    {
        // latestOfMany هي الطريقة الحديثة والسريعة في لارافيل لجلب آخر سجل
        return $this->hasOne(Message::class)->latestOfMany();
    }

    // علاقة كل الرسائل
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // علاقة المرسل
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // علاقة المستقبل
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    // ✅ دالة مساعدة مستخدمة في ملف Blade لتحديد الطرف الآخر
    public function otherUser($authId)
    {
        if ($this->sender_id == $authId) {
            return $this->receiver;
        }
        return $this->sender;
    }
}