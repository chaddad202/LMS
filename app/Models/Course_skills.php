<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Course_skills extends Model
{
    use HasFactory;
    protected $fillable = [
        'skills_id',
        'course_id',
        'point '
    ];
}
