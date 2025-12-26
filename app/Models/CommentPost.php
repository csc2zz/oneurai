<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentPost extends Model
{
    // تحديد اسم الجدول لأن Laravel يتوقع تلقائياً "comment_posts" 
    // لكن من الجيد تأكيده هنا لضمان عدم حدوث أخطاء
    protected $table = 'comment_posts';

    protected $fillable = [
        'user_id',
        'post_id',
        'body',
    ];

    /**
     * العلاقة مع المستخدم (صاحب التعليق)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع المقال (الذي ينتمي إليه التعليق)
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}