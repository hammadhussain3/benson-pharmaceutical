<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::create([
            'name' => 'Superadmin', // Provide a name for the user
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('Kuchnahi021!'), // Hash the password
        ]);

        $superAdmin->assignRole('Superadmin');
    }
}
