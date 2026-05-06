<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Soft Gel - Minimalist',
                'description' => 'A type of artificial nail enhancement that uses pre-shaped, flexible gel tips to lengthen and shape the natural nail.',
                'price' => 700.00,
                'duration_minutes' => 90,
                'category' => 'soft-gel-extension',
                'location_type' => 'home-service',
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Gel Polish - Plain Design',
                'description' => 'Long-lasting color application, nail shaping, cuticle care, hand massage, and glossy gel finish that lasts 2-3 weeks without chipping.',
                'price' => 690.00,
                'duration_minutes' => 50,
                'category' => 'gel-polish',
                'location_type' => 'walk-in',
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Toe Gel Polish',
                'description' => 'Professional toe nail care with gel polish application, perfect for sandal season and special occasions.',
                'price' => 500.00,
                'duration_minutes' => 45,
                'category' => 'gel-polish',
                'location_type' => 'both',
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Nail Art - Complex Design',
                'description' => 'Intricate nail art with hand-painted designs, 3D elements, and premium gel polish.',
                'price' => 1200.00,
                'duration_minutes' => 120,
                'category' => 'nail-art',
                'location_type' => 'both',
                'status' => 'active',
                'image_url' => null,
            ],
            [
                'name' => 'Manicure - Classic',
                'description' => 'Basic nail care including shaping, cuticle care, hand massage, and regular polish.',
                'price' => 400.00,
                'duration_minutes' => 45,
                'category' => 'manicure',
                'location_type' => 'both',
                'status' => 'active',
                'image_url' => null,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('Services seeded successfully!');
    }
}
