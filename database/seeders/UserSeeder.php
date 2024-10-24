<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin User', // Provide a name for the user
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Hash the password
        ]);
    }
}
