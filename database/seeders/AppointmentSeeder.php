<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Generating comprehensive appointment data for analytics...');

        // Get all customers and services
        $customers = User::where('role', 'customer')->get();
        $services = Service::all();

        if ($customers->isEmpty() || $services->isEmpty()) {
            $this->command->error('No customers or services found. Please run AdminUserSeeder and ServiceSeeder first.');
            return;
        }

        $statuses = ['completed', 'completed', 'completed', 'completed', 'confirmed', 'pending', 'cancelled'];
        $paymentStatuses = ['paid', 'paid', 'paid', 'partial', 'pending'];
        $locationTypes = ['home-service', 'walk-in'];
        $addresses = [
            '123 Main Street, Manila',
            '456 Oak Avenue, Quezon City',
            '789 Pine Road, Makati',
            '321 Elm Street, Taguig',
            '654 Maple Drive, Pasig',
            null, // for walk-in
        ];

        $appointmentCount = 0;

        // Generate appointments for the last 6 months
        for ($monthsAgo = 5; $monthsAgo >= 0; $monthsAgo--) {
            // More appointments in recent months
            $appointmentsThisMonth = rand(15, 30) + ($monthsAgo == 0 ? 10 : 0);
            
            for ($i = 0; $i < $appointmentsThisMonth; $i++) {
                $customer = $customers->random();
                $service = $services->random();
                $status = $statuses[array_rand($statuses)];
                $locationType = $locationTypes[array_rand($locationTypes)];
                
                // Random date within the month
                $daysInMonth = Carbon::now()->subMonths($monthsAgo)->daysInMonth;
                $randomDay = rand(1, $daysInMonth);
                $appointmentDate = Carbon::now()
                    ->subMonths($monthsAgo)
                    ->startOfMonth()
                    ->addDays($randomDay - 1)
                    ->setTime(rand(9, 17), rand(0, 3) * 15);

                // Only future appointments can be pending/confirmed
                if ($appointmentDate->isFuture()) {
                    $status = rand(0, 1) ? 'pending' : 'confirmed';
                }

                // Calculate amount with some variation
                $baseAmount = $service->price;
                $variation = rand(-50, 150);
                $amount = max($baseAmount + $variation, $service->price * 0.8);

                $appointment = Appointment::create([
                    'user_id' => $customer->id,
                    'service_id' => $service->id,
                    'appointment_date' => $appointmentDate,
                    'location_type' => $locationType,
                    'customer_address' => $locationType === 'home-service' ? $addresses[array_rand($addresses)] : null,
                    'amount' => round($amount, 2),
                    'status' => $status,
                    'payment_status' => $status === 'completed' ? 'paid' : $paymentStatuses[array_rand($paymentStatuses)],
                    'notes' => rand(0, 3) == 0 ? $this->getRandomNote() : null,
                ]);

                // Set created_at to match appointment date for analytics
                $appointment->created_at = $appointmentDate;
                $appointment->save();

                $appointmentCount++;
            }
        }

        $this->command->info("✓ Successfully created {$appointmentCount} appointments spanning 6 months!");
        $this->command->info('✓ Data includes various services, locations, and customer preferences.');
        $this->command->info('✓ Analytics page should now display comprehensive insights.');
    }

    /**
     * Get random appointment notes
     */
    private function getRandomNote(): string
    {
        $notes = [
            'Customer prefers natural colors',
            'Allergic to certain products - check first',
            'Regular customer - knows the routine',
            'First time customer - take extra care',
            'Prefers quick service',
            'Likes detailed nail art',
            'Requests specific nail technician',
            'Special occasion - birthday/wedding',
            'Prefers gel over regular polish',
            'Wants French manicure style',
        ];

        return $notes[array_rand($notes)];
    }
}
