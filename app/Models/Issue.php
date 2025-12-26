<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'closed_at',
        'closed_by'
    ];

    protected $casts = [
        'closed_at' => 'datetime',
    ];

    // العلاقة مع المشروع
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    // العلاقة مع كاتب المشكلة
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // العلاقة مع التصنيفات (Labels)
    public function labels()
    {
        return $this->belongsToMany(Label::class, 'issue_label');
    }

    // العلاقة مع التعليقات (إذا سويت جدول تعليقات لاحقاً)
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // Scopes للفلترة السهلة
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }
}
