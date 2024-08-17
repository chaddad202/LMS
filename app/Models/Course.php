<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

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
        'category_id',
        'coupon_id',
        'type'

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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function learning_paths()
    {
        return $this->belongsToMany(Learning_path::class, 'learning_path_courses');
    }

    public function skills()
    {
        return $this->belongsToMany(Skills::class, 'course_skills');
    }
    public function gifts()
    {
        return $this->hasMany(Gift::class);
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
        return $this->hasMany(Rate::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }
    public function Gain_prequists()
    {
        return $this->hasMany(Gain_prequist::class);
    }

    public function progress_students()
    {
        return $this->hasMany(Progress_student::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
    public function getAverageRatingAttribute()
    {
        return Cache::remember("course_{$this->id}_rating", now()->addMinutes(10), function () {
            return $this->ratings()->avg('value');
        });
    }

}
