<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListeningMaterial extends Model
{
    protected $fillable = ['title', 'audio_url', 'difficulty'];

    public function questions()
    {
        return $this->hasMany(ListeningQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(ListeningAttempt::class);
    }
}
