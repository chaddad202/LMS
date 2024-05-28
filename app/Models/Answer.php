<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'quiz_id',
        'question_id',
        'choice_id', 'score'


    ];


    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function quiz()
    {

        return $this->belongsTo(Quiz::class);
    }

    public function questions()
    {

        return $this->hasMany(Question::class);
    }

    public function choices()
    {

        return $this->hasMany(Choice::class);
    }
}
