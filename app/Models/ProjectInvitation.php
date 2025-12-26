<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInvitation extends Model
{
    protected $fillable = ['project_id', 'email', 'role', 'token'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
