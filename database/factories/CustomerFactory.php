<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Creates a new user and assigns its ID to user_id
            'photo' => $this->faker->imageUrl(640, 480, 'people', true), // Generates a fake image URL
            'description' => $this->faker->sentence(), // Generates a random paragraph for the description
            'profession' => $this->faker->jobTitle(), // Generates a random job title for the profession
        ];
    }
}
