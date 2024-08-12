<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Category;
use App\Models\Course;

/**;
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Course::class;

    public function definition(): array
    {
        $userWithCustomer = User::whereHas('customer')->inRandomOrder()->first();

        return [
            'user_id' => $userWithCustomer ? $userWithCustomer->id : User::factory(), // Ensure user has a customer
            'coupon_id' => $this->faker->optional()->randomElement(Coupon::pluck('id')), // Conditionally assigns a coupon_id or leaves it null
            'category_id' => Category::factory(), // Creates a new category and assigns the category_id
            'title' => $this->faker->sentence(), // Generates a random course title
            'description' => $this->faker->sentence(), // Generates a random course description
            'photo' => $this->faker->imageUrl(640, 480, 'education', true), // Generates a fake image URL
            'price' => $this->faker->randomFloat(2, 10, 500), // Generates a random price between 10 and 500
            'course_duration' => $this->faker->optional()->time(), // Generates a random time or leaves it null
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']), // Should match enum values
            'type' => $this->faker->randomElement(['draft', 'publish']), // Randomly selects a type
        ];
    }
}
