<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@webdesa.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ]);

        // Create sample user
        User::create([
            'name' => 'User Test',
            'email' => 'user@webdesa.com',
            'nik' => '1234567890123456',
            'role' => 'user',
            'password' => bcrypt('user123'),
        ]);
    }
}
