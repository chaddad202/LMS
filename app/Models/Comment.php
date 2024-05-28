<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'lesson_id',
        'comment',
        'user_id',
        'comment_id'


    ];

    public function user()
    {

        return $this->belongsTo(User::class);
    }
    public function comment()
    {

        return $this->belongsTo(Comment::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function lesson()
    {

        return $this->belongsTo(Lesson::class);
    }
}
