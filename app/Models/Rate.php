<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Rate extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'user_id', 'value'


    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function booted()
    {
        static::saved(function ($rating) {
            Cache::forget("course_{$rating->course_id}_rating");
        });

        static::deleted(function ($rating) {
            Cache::forget("course_{$rating->course_id}_rating");
        });
    }
}
