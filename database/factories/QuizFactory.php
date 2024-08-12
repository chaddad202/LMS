<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Section;
use App\Models\Quiz;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Quiz::class;

    public function definition(): array
    {
        return [
            'section_id' => Section::factory(), // Creates a new section and assigns its ID to section_id
            'name' => $this->faker->word(), // Generates a random name for the quiz
            'num_of_question' => $this->faker->numberBetween(1, 50), // Generates a random number of questions between 1 and 50
            'mark' => $this->faker->optional()->numberBetween(1, 100), // Generates a random mark between 1 and 100 or leaves it null
        ];
    }
}
