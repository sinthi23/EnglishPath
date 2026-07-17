<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WritingTopic extends Model
{
    protected $fillable = ['title', 'prompt', 'min_words', 'difficulty'];

    public function submissions()
    {
        return $this->hasMany(WritingSubmission::class);
    }
}
