<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Support\Facades\Notification;

class Post extends Model
{
    protected $fillable = ['title', 'slug', 'category', 'content', 'image', 'is_published', 'views', 'show_signature'];

protected static function booted()
{
    // 1. عند إنشاء مقال جديد وهو منشور بالفعل
    static::created(function ($post) {
        if ($post->is_published) {
            $post->sendNotificationToInterestedUsers();
        }
    });

    // 2. عند تحديث مقال موجود وتغيير حالته إلى منشور
    static::updated(function ($post) {
        if ($post->is_published && $post->wasChanged('is_published')) {
            $post->sendNotificationToInterestedUsers();
        }
    });
}

public function sendNotificationToInterestedUsers()
{
    // جلب المستخدمين الذين فعلوا خيار "تلقي التحديثات"
    $users = User::where('notify_updates', true)->get();

    $title = 'مقال تقني جديد: ' . $this->title;
    $message = 'تم نشر مصفوفة معرفية جديدة في قسم ' . $this->category . '. اكتشفها الآن.';
    $url = route('post.show', $this->slug);
    $icon = 'fa-newspaper'; // أيقونة مناسبة للمقال
    $color = 'text-emerald-500';

    // إرسال الإشعار باستخدام نظام التنبيهات الموجود لديك
    Notification::send($users, new SystemNotification($title, $message, $url, $icon, $color));
}
    public function comments() { 
        return $this->hasMany(CommentPost::class, 'post_id'); 
    }
    
    public function likes() { 
        return $this->hasMany(PostLike::class, 'post_id'); 
    }
    
    public function isLikedBy($user) { 
        return $this->likes()->where('user_id', $user?->id)->exists(); 
    }
}
