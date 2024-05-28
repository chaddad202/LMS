<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Q_Q extends Model
{
    use HasFactory;
    protected $table = "q_qs";

    protected $fillable = [
        'question_id',
        'quiz_id',
        'mark',
    ];
}
