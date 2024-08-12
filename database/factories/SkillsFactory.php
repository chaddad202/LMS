<?php

namespace Database\Factories;

use App\Models\Skills;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skills>
 */
class SkillsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Skills::class;

    public function definition(): array
    {

        return [
            'title' => $this->faker->unique()->word(), // Generates a unique skill title
            'maximunBeginner' => $this->faker->numberBetween(1, 100), // Generates a random integer for beginner level
            'maximunIntemediate' => $this->faker->numberBetween(1, 100), // Generates a random integer for intermediate level
            'maximunAdvanced' => $this->faker->numberBetween(1, 100), // Generates a random integer for advanced level
        ];
    }
}
