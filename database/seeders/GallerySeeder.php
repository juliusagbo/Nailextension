<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryItems = [
            [
                'title' => 'Gold Cat Eye Nails',
                'description' => 'Striking metallic gold with dark outline',
                'image_path' => 'images/ourworks/1.png',
                'alt_text' => 'Gold Cat Eye Nails',
                'category' => 'nail_extension',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Burgundy & Nude Design',
                'description' => 'Deep burgundy with intricate white patterns',
                'image_path' => 'images/ourworks/2.png',
                'alt_text' => 'Burgundy & Nude Design Nails',
                'category' => 'nail_extension',
                'is_featured' => true,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Gold Glitter French Tip',
                'description' => 'Modern French tip with shimmering gold',
                'image_path' => 'images/ourworks/3.png',
                'alt_text' => 'Gold Glitter French Tip Nails',
                'category' => 'nail_extension',
                'is_featured' => true,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => '3D Floral Design',
                'description' => 'Vibrant 3D floral in orange and yellow',
                'image_path' => 'images/ourworks/4.png',
                'alt_text' => '3D Floral Nails',
                'category' => 'nail_extension',
                'is_featured' => false,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Grey Pedicure',
                'description' => 'Muted light grey with clean finish',
                'image_path' => 'images/ourworks/5.png',
                'alt_text' => 'Grey Pedicure',
                'category' => 'pedicure',
                'is_featured' => false,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Light Blue Pedicure',
                'description' => 'Pastel light blue or periwinkle',
                'image_path' => 'images/ourworks/6.png',
                'alt_text' => 'Light Blue Pedicure',
                'category' => 'pedicure',
                'is_featured' => false,
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'title' => 'French with Rhinestones',
                'description' => 'Classic French with delicate rhinestones',
                'image_path' => 'images/ourworks/7.png',
                'alt_text' => 'French Pedicure with Rhinestones',
                'category' => 'pedicure',
                'is_featured' => true,
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'title' => 'White Pedicure',
                'description' => 'Clean white with well-moisturized finish',
                'image_path' => 'images/ourworks/8.png',
                'alt_text' => 'White Pedicure',
                'category' => 'pedicure',
                'is_featured' => false,
                'sort_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($galleryItems as $item) {
            Gallery::create($item);
        }
    }
}
