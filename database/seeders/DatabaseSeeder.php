<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Course;
use App\Models\Customer;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Section;
use App\Models\Skills;
use App\Models\User;
use Database\Factories\GainFactory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create roles
        // $adminRole = Role::create(['name' => 'admin']);
        // $studentRole = Role::create(['name' => 'student']);
        // $teacherRole = Role::create(['name' => 'teacher']);
        // $companyOwnerRole = Role::create(['name' => 'company_owner']);
        // $this->call([
        //     // UserSeeder::class,
        //     // adminroleSeeder::class,
        //     RoleSeeder::class
        // ]);
        // User::factory()->count(30)->create();
        Customer::factory()->count(20)->create();
        Category::factory()->count(20)->create();
        Coupon::factory()->count(20)->create();
        Course::factory()->count(20)->create();
        Skills::factory()->count(20)->create();
        GainFactory::factory()->count(20)->create();
        Section::factory()->count(20)->create();
        Lesson::factory()->count(20)->create();
        Quiz::factory()->count(20)->create();
        Question::factory()->count(20)->create();
        Question::factory()->count(20)->create();
    }
}
