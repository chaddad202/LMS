<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'skills_id',
        'point'

    ];
}
