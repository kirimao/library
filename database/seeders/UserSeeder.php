<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Staff Admin
        User::firstOrCreate(
            ['email' => 'admin@library.com'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Staff Librarian
        User::firstOrCreate(
            ['email' => 'librarian@library.com'],
            [
                'name' => 'Siti Pustakawan',
                'password' => Hash::make('password'),
                'role' => 'librarian',
            ]
        );
    }
}
