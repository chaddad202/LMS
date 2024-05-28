<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Learning_path extends Model
{
    use HasFactory;
    public function courses()
    {
        return $this->BelongsToMany(Course::class,'learning_path_courses');
    }
}
