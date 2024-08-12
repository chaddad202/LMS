<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Gain_prequist;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gain_prequist>
 */
class Gain_prequistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Gain_prequist::class;

    public function definition(): array
    {
        return [
            // Define your fake data here
            'course_id' => Course::factory(), // Example
            'text' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['gain', 'prequisites']),
        ];
    }
}
