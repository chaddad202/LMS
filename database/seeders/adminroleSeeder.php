<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class adminroleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userId = DB::table('users')->where('name', 'admin')->value('id');
        $roleId = DB::table('roles')->where('name', 'admin')->value('id');
         DB::table('role_user')->insert(
            [
                'user_id' => $userId,
                'role_id' => $roleId,
            ]);

    }
}
