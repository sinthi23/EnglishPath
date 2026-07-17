<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'level',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function enrolledUsers()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }
}
