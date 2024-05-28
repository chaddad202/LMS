<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Type_of_lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'lesson_id',
        'type_id',


    ];
}
