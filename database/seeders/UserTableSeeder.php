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
        // dummy user data
        $user = [
            'name' => 'Shashimii',
            'email' => 'shashimii@gmail.com',
            'password' => bcrypt('password'),
        ];

        User::insert($user); // Insert the user data into the users table
    }
}
