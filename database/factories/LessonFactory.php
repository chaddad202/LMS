<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Section;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'section_id' => Section::factory(), // Creates a new section and assigns its ID to section_id
            'title' => $this->faker->sentence(), // Generates a random title for the lesson
            'description' => $this->faker->sentence(), // Generates a random description for the lesson
            'file' => $this->faker->fileExtension(), // Generates a random file extension (simulates a file type)
            'lesson_duration' => $this->faker->optional()->time(), // Generates a random time for the lesson duration or leaves it null
        ];
    }
}
