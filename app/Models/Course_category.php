<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course_category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'course_id',
    ];
}
