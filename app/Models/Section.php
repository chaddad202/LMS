<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'course_id',
        'title',
        'section_duration'
    ];
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
