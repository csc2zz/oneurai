<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameScore extends Model
{
    protected $fillable = ['game_id', 'user_id', 'score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}