<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'photo',
        'level',
        'price',
        'course_duration',
        'number_of_student',
        'rating',
        'number_of_rating',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function users()
    // {
    //     return $this->belongsToMany(User::class,'enrollments');
    // }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'course_categories');
    }

    public function learning_paths()
    {
        return $this->belongsToMany(Learning_path::class, 'learning_path_courses');
    }

    public function skills()
    {
        return $this->belongsToMany(Skills::class, 'course_skills');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function favourites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
    public function informations()
    {
        return $this->hasMany(Information::class);
    }

    public function progress_students()
    {
        return $this->hasMany(Progress_student::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
