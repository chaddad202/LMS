<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Q_C extends Model
{
    use HasFactory;
    protected $table = "q_cs";

    protected $fillable = [
        'question_id',
        'choice_id',
        'status',
    ];
}
