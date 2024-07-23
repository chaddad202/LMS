<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\text;

class Information extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'text', 'status'


    ];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
