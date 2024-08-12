<?php

namespace Database\Factories;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Coupon::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Creates a new user and assigns the user_id
            'coupon_code' => strtoupper($this->faker->unique()->lexify('??????')), // Generates a unique coupon code
            'discount' => $this->faker->randomFloat(2, 5, 50), // Generates a random discount between 5% and 50%
        ];
    }
}
