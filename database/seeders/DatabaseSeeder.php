<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Call our seeders in the correct order
        $this->call([
            AdminUserSeeder::class,
            ServiceSeeder::class,
        ]);

        // Create some sample customers
        User::factory(20)->create([
            'role' => 'customer',
            'status' => 'active',
        ]);

        // Generate appointment data for analytics
        $this->call([
            AppointmentSeeder::class,
            TodayAppointmentsSeeder::class, // Extra appointments for today's dashboard
        ]);
    }
}
