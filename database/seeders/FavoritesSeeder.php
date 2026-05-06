<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Favorite;
use App\Models\User;
use App\Models\Service;

class FavoritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user and first few services
        $user = User::first();
        $services = Service::take(3)->get();
        
        if ($user && $services->count() > 0) {
            foreach ($services as $service) {
                // Check if favorite already exists
                $existingFavorite = Favorite::where('user_id', $user->id)
                    ->where('service_id', $service->id)
                    ->first();
                
                if (!$existingFavorite) {
                    Favorite::create([
                        'user_id' => $user->id,
                        'service_id' => $service->id,
                    ]);
                }
            }
        }
    }
}
