<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'profile_completed_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function writingSubmissions()
    {
        return $this->hasMany(WritingSubmission::class);
    }

    public function listeningAttempts()
    {
        return $this->hasMany(ListeningAttempt::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }

    public function sendPasswordResetNotification($token): void
    {
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $this->email]);
        session()->flash('dev_reset_link', $resetUrl);

        $this->notify(new \Illuminate\Auth\Notifications\ResetPassword($token));
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
