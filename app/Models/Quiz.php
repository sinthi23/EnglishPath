<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'lesson_id',
        'reading_passage_id',
        'title',
        'difficulty',
        'time_limit_minutes',
        'passing_score',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function readingPassage()
    {
        return $this->belongsTo(ReadingPassage::class);
    }
}
