<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'section_id',
        'file',
        'description',
        'title',
        'lesson_duration'

    ];
    public function types()
    {
        return $this->belongsToMany(Type::class, 'type_of_lessons');
    }
    public function notes()
    {
        return $this->hasMany(Note::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function q_a()
    {
        return $this->hasMany(Q_a::class);
    }
}
