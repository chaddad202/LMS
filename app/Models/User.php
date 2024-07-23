<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function teacher_profile()
    {
        return $this->hasone(teacher_profile::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


    public function student_profile()
    {
        return $this->hasone(student_profile::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    } #

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function progress_students()
    {
        return $this->hasMany(Progress_Student::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
