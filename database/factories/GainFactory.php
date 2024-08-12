<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gain_prequist>
 */
class GainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = GainFactory::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(), // Creates a new course and assigns its ID to course_id
            'text' => $this->faker->sentence(), // Generates a random sentence for the text
            'status' => $this->faker->randomElement(['gain', 'prequisites']), // Randomly selects between 'gain' and 'prequisites'
        ];
    }
}
