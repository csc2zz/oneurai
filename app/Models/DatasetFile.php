<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\RecordContribution; // استدعاء

class DatasetFile extends Model
{
    use HasFactory, RecordContribution;

    protected $fillable = [
        'dataset_id', 'user_id', 'filename', 'path', 'extension', 'size_bytes'
    ];

    // دالة مساعدة لتنسيق الحجم
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size_bytes;
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        return number_format($bytes / 1024, 2) . ' KB';
    }
}
