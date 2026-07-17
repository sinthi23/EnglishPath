<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingPassage extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'difficulty',
        'passage',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class);
    }
}
