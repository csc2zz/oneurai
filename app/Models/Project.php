<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\RecordContribution; // استدعاء

class Project extends Model
{
    use HasFactory, RecordContribution;

    protected $guarded = [];

    protected $casts = [
    'tags' => 'array', // هذا السطر ضروري ليقوم لارافيل بتحويل المصفوفة إلى JSON والعكس
    'is_public' => 'boolean',
];

    // علاقة المشروع بالمالك (صاحب المشروع)
public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stars(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'stars')
            ->withTimestamps();
    }

    public function files(): HasMany
    {
        return $this->hasMany(ProjectFile::class);
    }

    public function aiModels(): HasMany
    {
        return $this->hasMany(AiModel::class);
    }

    public function forks(): HasMany
    {
        return $this->hasMany(Project::class, 'forked_from_id');
    }

    public function forkedFrom(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'forked_from_id');
    }

    public function collaborators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role')
            ->withTimestamps();
    }

    // ========== SCOPES ==========

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('slug', 'LIKE', "%{$search}%");
    }

    // ========== METHODS ==========

    public function isStarredBy(User $user): bool
    {
        return $this->stars()->where('user_id', $user->id)->exists();
    }

    public function getStarsCountAttribute(): int
    {
        return $this->stars()->count();
    }

    public function getForksCountAttribute(): int
    {
        return $this->forks()->count();
    }

    public function getUrlAttribute(): string
    {
        return route('projects.show', [$this->user->username, $this->slug]);
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->user_id === $user->id;
    }

    public function canBeViewedBy(User $user): bool
    {
        return $this->is_public || $this->isOwnedBy($user);
    }

    // علاقة المشروع بالأعضاء (الفريق)
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // علاقة المشروع بالدعوات
    public function invitations()
    {
        return $this->hasMany(ProjectInvitation::class);
    }

}
