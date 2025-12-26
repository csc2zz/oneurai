<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Traits\RecordContribution; // استدعاء

class AiModel extends Model
{
    protected $table = 'ai_models';
    use HasFactory, RecordContribution;

protected $fillable = [
        'user_id',
        'project_id',
        'title',
        'slug',
        'description',
        'task',
        'framework',
        'library',
        'language', // <--- تمت الإضافة هنا
        'is_public',
        'downloads_count',
        'likes_count',
        'version',
        'license',
        // 'file_path', // لم نعد نحتاجها هنا لأن الملفات في جدول منفصل
        // 'file_size', // لم نعد نحتاجها هنا
    ];

protected $casts = [
        'is_public' => 'boolean',
    ];

    // ========== RELATIONSHIPS ==========

    /**
     * العلاقة: النموذج ينتمي لمستخدم
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العلاقة: النموذج ينتمي لمشروع
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    public function stats(): HasMany
    {
        // تأكد أن اسم الموديل هو ModelStat واسم المفتاح الخارجي model_id
        return $this->hasMany(ModelStat::class, 'model_id');
    }

    /**
     * العلاقة: النموذج لديه العديد من الإعجابات
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'model_likes')
            ->withTimestamps();
    }

    /**
     * العلاقة: النموذج لديه العديد من التنزيلات
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(ModelDownload::class);
    }

    // ========== SCOPES ==========

    /**
     * Scope: النماذج العامة فقط
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope: البحث في النماذج
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('task', 'LIKE', "%{$search}%")
            ->orWhere('framework', 'LIKE', "%{$search}%");
    }

    /**
     * Scope: النماذج حسب المهمة
     */
    public function scopeByTask($query, $task)
    {
        return $query->where('task', $task);
    }

    /**
     * Scope: النماذج حسب الإطار
     */
    public function scopeByFramework($query, $framework)
    {
        return $query->where('framework', $framework);
    }

    // ========== METHODS ==========

    /**
     * التحقق إذا كان المستخدم معجب بالنموذج
     */
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * عدد الإعجابات
     */
    public function getLikesCountAttribute(): int
    {
        return $this->likes()->count();
    }

    /**
     * عدد التنزيلات
     */
    public function getDownloadsCountAttribute(): int
    {
        return $this->downloads()->count();
    }

    /**
     * الرابط العام للنموذج
     */
    public function getUrlAttribute(): string
    {
        return route('models.show', [$this->user->username, $this->slug]);
    }

    /**
     * زيادة عداد التنزيلات
     */
    public function incrementDownloads(): void
    {
        $this->downloads()->create(['user_id' => auth()->id()]);
        $this->increment('downloads_count');
    }

    /**
     * التحقق إذا كان النموذج مملوك للمستخدم
     */
    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    /**
     * التحقق إذا كان النموذج يمكن للمستخدم رؤيته
     */
    public function canBeViewedBy(User $user): bool
    {
        return $this->is_public || $this->isOwnedBy($user);
    }



    // دالة مساعدة لجلب حجم الملف بشكل مقروء
    public function getSizeForHumansAttribute()
    {
        // يمكنك إضافة منطق تحويل البايت إلى GB/MB هنا
        return $this->file_size;
    }

    public function files()
{
    return $this->hasMany(ModelFile::class);
}

public function comments()
{
    return $this->hasMany(ModelComment::class)->latest();
}
}
