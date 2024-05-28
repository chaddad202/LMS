<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'num_of_question',
        'mark',

    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'q_qs');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function progress_students()
    {
        return $this->hasMany(progress_student::class);
    }
}
