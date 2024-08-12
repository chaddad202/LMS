<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skills extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'maximunBeginner', 'maximunIntemediate', 'maximunAdvanced',
    ];

    public function courses()
    {
        return $this->BelongsToMany(Course::class, 'course_skills');
    }
    public function users()
    {
        return $this->BelongsToMany(Course::class, 'user_skills');
    }
}
