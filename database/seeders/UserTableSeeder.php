<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // default admin user data
        $user = [
            'name' => 'Shashimii',
            'email' => 'shashimii@gmail.com',
            'password' => bcrypt('password'),
            'role' => 1
        ];

        User::insert($user); // insert admin user
    }
}
