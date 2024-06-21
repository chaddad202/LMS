<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skills extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'maximunPoint'
    ];

    public function courses()
    {
        return $this->BelongsToMany(Course::class, 'course_skills');
    }
}
