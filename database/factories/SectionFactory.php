<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Course;
use App\Models\Section;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Section::class;

    public function definition(): array
    {
        return [
            'course_id' => Course::factory(), // Creates a new course and assigns its ID to course_id
            'title' => $this->faker->sentence(), // Generates a random title for the section
            'section_duration' => $this->faker->optional()->time(), // Generates a random time for the section duration or leaves it null
        ];
    }
}
