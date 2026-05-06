<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin Owner',
            'email' => 'admin@nailedbyvia.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '+1234567890',
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@nailedbyvia.com');
        $this->command->info('Password: admin123');
    }
}
