<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'photo'
    ];
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function courses()
    {

        return $this->hasMany(Course::class);
    }
}
