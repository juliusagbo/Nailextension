<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActivityLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'user_id' => 1,
                'user_type' => 'admin',
                'user_name' => 'ViaFlor P. Sabior',
                'user_role' => 'Owner',
                'action' => 'UPDATED SETTINGS',
                'details' => 'Changed business hours',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => Carbon::now()->subHours(2),
            ],
            [
                'user_id' => 2,
                'user_type' => 'customer',
                'user_name' => 'Julius Agbo',
                'user_role' => 'Customer',
                'action' => 'NEW BOOKING',
                'details' => 'Soft Gel - Full Set (₱1,200)',
                'ip_address' => '112.200.145.67',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 15_0 like Mac OS X)',
                'created_at' => Carbon::now()->subHours(3),
            ],
            [
                'user_id' => 3,
                'user_type' => 'customer',
                'user_name' => 'Rosa Aro',
                'user_role' => 'Customer',
                'action' => 'PAYMENT PROCESSED',
                'details' => 'Appointment #1254 (₱1,200)',
                'ip_address' => '192.168.1.2',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => Carbon::now()->subHours(5),
            ],
            [
                'user_id' => 1,
                'user_type' => 'admin',
                'user_name' => 'ViaFlor P. Sabior',
                'user_role' => 'Owner',
                'action' => 'SERVICE ADDED',
                'details' => 'Added "Nail Art Design"',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => Carbon::now()->subHours(8),
            ],
            [
                'user_id' => 4,
                'user_type' => 'customer',
                'user_name' => 'Sydney Chan',
                'user_role' => 'Customer',
                'action' => 'NEW BOOKING',
                'details' => 'Gel Polish - Plain Design (₱690)',
                'ip_address' => '203.177.89.123',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36',
                'created_at' => Carbon::now()->subHours(10),
            ],
            [
                'user_id' => 1,
                'user_type' => 'admin',
                'user_name' => 'ViaFlor P. Sabior',
                'user_role' => 'Owner',
                'action' => 'UPDATED SETTINGS',
                'details' => 'Changed contact email',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => Carbon::now()->subHours(12),
            ],
            [
                'user_id' => 5,
                'user_type' => 'customer',
                'user_name' => 'Maria Santos',
                'user_role' => 'Customer',
                'action' => 'PAYMENT PROCESSED',
                'details' => 'Appointment #1253 (₱900)',
                'ip_address' => '175.176.234.89',
                'user_agent' => 'Mozilla/5.0 (Android 11; Mobile; rv:68.0) Gecko/68.0 Firefox/88.0',
                'created_at' => Carbon::now()->subHours(15),
            ],
            [
                'user_id' => 1,
                'user_type' => 'admin',
                'user_name' => 'ViaFlor P. Sabior',
                'user_role' => 'Owner',
                'action' => 'CUSTOMER ADDED',
                'details' => 'Added new customer: Stacey Sevilleja',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => Carbon::now()->subHours(20),
            ],
            [
                'user_id' => 1,
                'user_type' => 'admin',
                'user_name' => 'ViaFlor P. Sabior',
                'user_role' => 'Owner',
                'action' => 'GALLERY ITEM ADDED',
                'details' => 'Gold Cat Eye Nails',
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'created_at' => Carbon::now()->subDays(1),
            ],
            [
                'user_id' => 6,
                'user_type' => 'customer',
                'user_name' => 'Jennifer Lopez',
                'user_role' => 'Customer',
                'action' => 'NEW BOOKING',
                'details' => 'French with Rhinestones (₱850)',
                'ip_address' => '45.123.78.90',
                'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 16_0 like Mac OS X)',
                'created_at' => Carbon::now()->subDays(2),
            ],
        ];

        foreach ($activities as $activity) {
            ActivityLog::create($activity);
        }
    }
}
