<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Fetch all users
        $users = User::all();

        // Fetch roles
        $roles = Role::whereIn('name', ['student', 'teacher'])->get(); // Get only 'student' and 'teacher' roles

        // Assign roles to users
        $users->each(function ($user) use ($roles) {
            // Assign between 1 and 2 roles (excluding 'admin')
            $user->roles()->attach(
                $roles->random(rand(1, 2))->pluck('id') // Attach 1 to 2 random roles to each user
            );
        });
    }
}
