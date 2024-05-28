<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'quiz_id',
        'question',
        'score',


    ];

    public function choices()
    {
        return $this->belongsToMany(Choice::class, 'q_cs');
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'q_qs');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
