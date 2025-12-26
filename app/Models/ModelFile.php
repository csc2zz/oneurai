<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\RecordContribution; // استدعاء
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelFile extends Model
{
    use HasFactory, RecordContribution;
    /**
     * الحقول المسموح تعبئتها جماعياً (Mass Assignment)
     */
    protected $fillable = [
        'ai_model_id',
        'filename', // تمت الإضافة
        'path',     // تمت الإضافة
        'size'      // تمت الإضافة
    ];

    /**
     * العلاقة: الملف ينتمي لنموذج ذكي واحد
     */
    public function aiModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class);
    }
}
