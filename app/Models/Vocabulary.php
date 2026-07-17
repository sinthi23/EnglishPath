<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    protected $fillable = [
        'word',
        'meaning',
        'example',
        'synonym',
        'antonym',
        'difficulty',
    ];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }
}
