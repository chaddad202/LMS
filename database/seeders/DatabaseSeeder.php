<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create roles
        $this->call([
            CategorySeeder::class,
            TypeSeeder::class,
            SkillSeeder::class,
            UserSeeder::class,
            adminroleSeeder::class
        ]);
        $adminRole = Role::create(['name' => 'admin']);
        $studentRole = Role::create(['name' => 'student']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $companyOwnerRole = Role::create(['name' => 'company_owner']);

        // $adminRole->givePermissionTo('all');

        // \App\Models\User::factory(10)->create();
        // $this->call(RoleSeeder::class);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
