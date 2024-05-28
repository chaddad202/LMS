<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class teacher_profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'photo',
        'knowledge',
        'headline',
        'age',
        'wallet'
    ];

    public function user()
        {
            return $this->belongsTo(User::class);
        }

}
