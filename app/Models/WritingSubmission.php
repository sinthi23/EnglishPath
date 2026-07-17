<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WritingSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'writing_topic_id',
        'content',
        'grammar_score',
        'vocabulary_score',
        'length_score',
        'overall_score',
        'feedback',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(WritingTopic::class, 'writing_topic_id');
    }
}
