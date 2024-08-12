<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coupon extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'coupon_code',
        'discount',
    ];
    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
