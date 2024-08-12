<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'quiz_id',
        'question',
        'mark',



    ];

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
    protected static function booted()
    {
        static::saved(function ($question) {
            // Calculate and cache half of the total mark for the quiz
            $halfMark = $question->quiz->questions->sum('mark') / 2;
            Cache::put("quiz_{$question->quiz->id}_half_mark", $halfMark, now()->addMinutes(10));
        });

        static::deleted(function ($question) {
            // Recalculate and cache half of the total mark for the quiz when a question is deleted
            $halfMark = $question->quiz->questions->sum('mark') / 2;
            Cache::put("quiz_{$question->quiz->id}_half_mark", $halfMark, now()->addMinutes(10));
        });
    }
}
