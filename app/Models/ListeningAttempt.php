<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListeningAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'listening_material_id',
        'score',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function material()
    {
        return $this->belongsTo(ListeningMaterial::class, 'listening_material_id');
    }
}
