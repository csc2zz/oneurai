<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostLike extends Model
{
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    /**
     * العلاقة مع المستخدم الذي قام بالإعجاب
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة مع المقال المُعجب به
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}