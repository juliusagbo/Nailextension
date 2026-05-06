<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Business Information Settings
        Settings::set('business_name', 'Nailed by Via', 'string', 'Business name');
        Settings::set('contact_email', 'nailedbyvia@gmail.com', 'string', 'Contact email address');
        Settings::set('phone_number', '+63 912 345 6789', 'string', 'Business phone number');
        Settings::set('business_address', 'Alegria, Cordova, Cebu, Philippines', 'string', 'Business address');

        // Business Hours Settings
        $businessHours = [
            'monday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'tuesday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'wednesday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'thursday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'friday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'saturday' => ['open' => '10:00', 'close' => '20:00', 'closed' => false],
            'sunday' => ['open' => '00:00', 'close' => '00:00', 'closed' => true],
        ];

        Settings::set('business_hours', json_encode($businessHours), 'json', 'Business operating hours');

        // Security Settings
        Settings::set('two_factor_enabled', false, 'boolean', 'Two-factor authentication enabled');
        Settings::set('password_min_length', 8, 'integer', 'Minimum password length');
        Settings::set('session_timeout', 120, 'integer', 'Session timeout in minutes');
    }
}
