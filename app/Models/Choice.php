<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Choice extends Model
{
    use HasFactory;
    protected $fillable = [
        'choice_text',


    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'q_cs');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
