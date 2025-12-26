<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModelDownload extends Model
{
    protected $fillable = [
        'user_id',
        'ai_model_id'
    ];

    /**
     * المستخدم الذي قام بالتنزيل
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * النموذج الذي تم تنزيله
     */
    public function aiModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class);
    }
}
