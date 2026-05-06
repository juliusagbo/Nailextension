<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;

class TodayAppointmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates appointments for today to make dashboard look realistic
     */
    public function run(): void
    {
        $this->command->info('Creating today\'s appointments for dashboard demo...');

        $customers = User::where('role', 'customer')->get();
        $services = Service::all();

        if ($customers->isEmpty() || $services->isEmpty()) {
            $this->command->error('No customers or services found.');
            return;
        }

        // Create 3-5 appointments for today
        $appointmentCount = rand(3, 5);
        $times = ['09:00', '11:00', '14:00', '16:00', '18:00'];
        
        for ($i = 0; $i < $appointmentCount; $i++) {
            $customer = $customers->random();
            $service = $services->random();
            $status = ['pending', 'confirmed', 'completed'][array_rand(['pending', 'confirmed', 'completed'])];
            $locationType = rand(0, 1) ? 'home-service' : 'walk-in';
            
            $appointmentTime = Carbon::today()->setTimeFromTimeString($times[$i]);
            
            $appointment = Appointment::create([
                'user_id' => $customer->id,
                'service_id' => $service->id,
                'appointment_date' => $appointmentTime,
                'location_type' => $locationType,
                'customer_address' => $locationType === 'home-service' ? '123 Sample St, Manila' : null,
                'amount' => $service->price + rand(-100, 200),
                'status' => $status,
                'payment_status' => $status === 'completed' ? 'paid' : 'pending',
                'notes' => null,
            ]);

            // Set created_at to match appointment date
            $appointment->created_at = $appointmentTime;
            $appointment->save();
        }

        $this->command->info("✓ Created {$appointmentCount} appointments for today!");
    }
}

