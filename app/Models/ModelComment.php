<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class ModelComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    // العلاقات الأساسية
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function aiModel(): BelongsTo { return $this->belongsTo(AiModel::class); }

    // 1. علاقة الردود (الأبناء)
    public function replies(): HasMany
    {
        return $this->hasMany(ModelComment::class, 'parent_id');
    }

    // 2. علاقة الإعجابات
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_comment_likes', 'model_comment_id', 'user_id');
    }

    // 3. هل المستخدم الحالي معجب بالتعليق؟
    public function isLikedByAuthUser(): bool
    {
        if (!Auth::check()) return false;
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
}
