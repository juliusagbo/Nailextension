<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample services (only 4 services as requested)
        $services = [
            [
                'name' => 'Soft Gel Extension',
                'description' => 'Natural looking gel nail extensions',
                'price' => 1200.00,
                'duration_minutes' => 90,
                'category' => 'nail_extension',
                'location_type' => 'both',
                'status' => 'active',
            ],
            [
                'name' => 'Toe Extension',
                'description' => 'Gel toe nail extensions',
                'price' => 800.00,
                'duration_minutes' => 60,
                'category' => 'nail_extension',
                'location_type' => 'both',
                'status' => 'active',
            ],
            [
                'name' => 'Minimalist Design',
                'description' => 'Simple and elegant nail art',
                'price' => 1000.00,
                'duration_minutes' => 75,
                'category' => 'nail_art',
                'location_type' => 'both',
                'status' => 'active',
            ],
            [
                'name' => 'Gel Polish',
                'description' => 'Long-lasting gel polish application',
                'price' => 600.00,
                'duration_minutes' => 45,
                'category' => 'nail_care',
                'location_type' => 'both',
                'status' => 'active',
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }

        // Create sample customers
        $customers = [
            [
                'name' => 'Julius Agbo',
                'email' => 'julius@example.com',
                'phone' => '+63 912 345 6789',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'status' => 'active',
                'created_at' => Carbon::now()->subMonths(3),
            ],
            [
                'name' => 'Rosa Camila Aro',
                'email' => 'rosa@example.com',
                'phone' => '+63 912 345 6790',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'status' => 'active',
                'created_at' => Carbon::now()->subMonths(2),
            ],
            [
                'name' => 'Maria Santos',
                'email' => 'maria@example.com',
                'phone' => '+63 912 345 6791',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'status' => 'active',
                'created_at' => Carbon::now()->subMonths(1),
            ],
            [
                'name' => 'Sydney Chan Berame',
                'email' => 'sydney@example.com',
                'phone' => '+63 912 345 6792',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'status' => 'active',
                'created_at' => Carbon::now()->subWeeks(2),
            ],
            [
                'name' => 'Anna Rodriguez',
                'email' => 'anna@example.com',
                'phone' => '+63 912 345 6793',
                'password' => bcrypt('password'),
                'role' => 'customer',
                'status' => 'active',
                'created_at' => Carbon::now()->subWeeks(1),
            ],
        ];

        foreach ($customers as $customerData) {
            User::create($customerData);
        }

        // Create sample appointments
        $appointments = [
            // Julius Agbo appointments
            [
                'user_id' => 1,
                'service_id' => 1,
                'appointment_date' => Carbon::now()->subDays(5),
                'location_type' => 'home_service',
                'customer_address' => 'Lapu-Lapu City, Cebu',
                'amount' => 1200.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(10),
            ],
            [
                'user_id' => 1,
                'service_id' => 3,
                'appointment_date' => Carbon::now()->subDays(15),
                'location_type' => 'home_service',
                'customer_address' => 'Lapu-Lapu City, Cebu',
                'amount' => 1000.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(20),
            ],
            [
                'user_id' => 1,
                'service_id' => 3,
                'appointment_date' => Carbon::now()->subDays(25),
                'location_type' => 'walk_in',
                'customer_address' => 'Nailed by Via Salon',
                'amount' => 1000.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(30),
            ],
            // Rosa Camila Aro appointments
            [
                'user_id' => 2,
                'service_id' => 2,
                'appointment_date' => Carbon::now()->subDays(3),
                'location_type' => 'home_service',
                'customer_address' => 'Cebu City, Cebu',
                'amount' => 800.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(8),
            ],
            [
                'user_id' => 2,
                'service_id' => 4,
                'appointment_date' => Carbon::now()->subDays(12),
                'location_type' => 'walk_in',
                'customer_address' => 'Nailed by Via Salon',
                'amount' => 600.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(17),
            ],
            // Maria Santos appointments
            [
                'user_id' => 3,
                'service_id' => 1,
                'appointment_date' => Carbon::now()->subDays(7),
                'location_type' => 'home_service',
                'customer_address' => 'Mandaue City, Cebu',
                'amount' => 1200.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(12),
            ],
            [
                'user_id' => 3,
                'service_id' => 3,
                'appointment_date' => Carbon::now()->subDays(18),
                'location_type' => 'walk_in',
                'customer_address' => 'Nailed by Via Salon',
                'amount' => 1000.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(23),
            ],
            // Sydney Chan Berame appointments
            [
                'user_id' => 4,
                'service_id' => 3,
                'appointment_date' => Carbon::now()->subDays(2),
                'location_type' => 'home_service',
                'customer_address' => 'Talisay City, Cebu',
                'amount' => 1000.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(7),
            ],
            [
                'user_id' => 4,
                'service_id' => 2,
                'appointment_date' => Carbon::now()->subDays(14),
                'location_type' => 'walk_in',
                'customer_address' => 'Nailed by Via Salon',
                'amount' => 800.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(19),
            ],
            // Anna Rodriguez appointments
            [
                'user_id' => 5,
                'service_id' => 4,
                'appointment_date' => Carbon::now()->subDays(1),
                'location_type' => 'home_service',
                'customer_address' => 'Consolacion, Cebu',
                'amount' => 600.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subDays(6),
            ],
        ];

        foreach ($appointments as $appointmentData) {
            Appointment::create($appointmentData);
        }

        // Create some appointments from previous months for trend analysis
        $previousMonthAppointments = [
            [
                'user_id' => 1,
                'service_id' => 1,
                'appointment_date' => Carbon::now()->subMonth()->subDays(5),
                'location_type' => 'home_service',
                'customer_address' => 'Lapu-Lapu City, Cebu',
                'amount' => 1200.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subMonth()->subDays(10),
            ],
            [
                'user_id' => 2,
                'service_id' => 3,
                'appointment_date' => Carbon::now()->subMonth()->subDays(10),
                'location_type' => 'walk_in',
                'customer_address' => 'Nailed by Via Salon',
                'amount' => 1000.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subMonth()->subDays(15),
            ],
            [
                'user_id' => 3,
                'service_id' => 2,
                'appointment_date' => Carbon::now()->subMonth()->subDays(15),
                'location_type' => 'home_service',
                'customer_address' => 'Mandaue City, Cebu',
                'amount' => 800.00,
                'status' => 'completed',
                'payment_status' => 'paid',
                'created_at' => Carbon::now()->subMonth()->subDays(20),
            ],
        ];

        foreach ($previousMonthAppointments as $appointmentData) {
            Appointment::create($appointmentData);
        }
    }
}
