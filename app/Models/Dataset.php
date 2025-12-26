<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\RecordContribution; // استدعاء

class Dataset extends Model
{
    use HasFactory, RecordContribution;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'visibility',
        'task_type',
        'license',
        'downloads_count',
        'size_bytes',
        'files_count',
    ];

    // علاقة البيانات بالمستخدم
public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // --- دوال مساعدة (Accessors) للعرض في الـ Blade ---

    // 1. تحويل الحجم من بايت إلى صيغة مقروءة (1.2 GB)
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->size_bytes;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }

    // 2. تنسيق عدد التحميلات (مثال: 1.5k)
    public function getFormattedDownloadsAttribute()
    {
        if ($this->downloads_count >= 1000000) {
            return number_format($this->downloads_count / 1000000, 1) . 'M';
        } elseif ($this->downloads_count >= 1000) {
            return number_format($this->downloads_count / 1000, 1) . 'k';
        }
        return $this->downloads_count;
    }

    // إنشاء Slug تلقائي عند الحفظ (اختياري)
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($dataset) {
            if (empty($dataset->slug)) {
                $dataset->slug = Str::slug($dataset->title);
            }
        });
    }
    public function files()
{
    return $this->hasMany(DatasetFile::class);
}
}
