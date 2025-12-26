<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'user_id', 'body', 'is_read', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
    public function parent()
{
    return $this->belongsTo(Message::class, 'parent_id');
}

// علاقة الرياكشنات
public function reactions()
{
    return $this->hasMany(MessageReaction::class);
}
}
