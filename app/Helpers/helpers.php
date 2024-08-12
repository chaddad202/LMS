<?php

use Illuminate\Support\Str;
use App\Models\Coupon;

if (!function_exists('generateUniqueCouponCode')) {
    /**
     * Generate a unique coupon code.
     *
     * @return string
     */
    function generateUniqueCouponCode()
    {
        $code = Str::upper(Str::random(10)); // Generate a random string of length 10

        // Ensure the coupon code is unique
        while (Coupon::where('coupon_code', $code)->exists()) {
            $code = Str::upper(Str::random(10));
        }

        return $code;
    }
}
