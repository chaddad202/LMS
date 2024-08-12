<?php

namespace Database\Factories;

use App\Models\Choice;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Question;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\choice>
 */
class choiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Choice::class;

    public function definition(): array
    {
        return [
            'question_id' => Question::factory()->optional(), // Creates a new question and assigns its ID to question_id or leaves it null
            'choice_text' => $this->faker->sentence(), // Generates a random choice text
            'isAnswer' => $this->faker->boolean(), // Randomly sets whether the choice is the correct answer
        ];
    }
}
