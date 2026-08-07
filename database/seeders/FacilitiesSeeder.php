<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitiesSeeder extends Seeder
{
    public function run(): void
    {
        $globalFacilities = [
            ['name' => 'Wi-Fi Kecepatan Tinggi',  'slug' => 'wifi-kecepatan-tinggi',    'icon' => 'wifi',             'category' => 'Room',     'display_order' => 1],
            ['name' => 'Air Conditioner (AC)',     'slug' => 'air-conditioner-ac',        'icon' => 'snowflake',        'category' => 'Room',     'display_order' => 2],
            ['name' => 'Kamar Mandi Dalam',        'slug' => 'kamar-mandi-dalam',         'icon' => 'bath',             'category' => 'Room',     'display_order' => 3],
            ['name' => 'Televisi LED',             'slug' => 'televisi-led',              'icon' => 'tv',               'category' => 'Room',     'display_order' => 4],
            ['name' => 'Water Heater',             'slug' => 'water-heater',              'icon' => 'fire',             'category' => 'Room',     'display_order' => 5],
            ['name' => 'Slot Parkir Mobil',        'slug' => 'slot-parkir-mobil',         'icon' => 'car',              'category' => 'Shared',   'display_order' => 6],
            ['name' => 'CCTV Keamanan 24/7',       'slug' => 'cctv-keamanan-247',         'icon' => 'shield-alt',       'category' => 'Security', 'display_order' => 7],
            ['name' => 'Dapur Bersama',            'slug' => 'dapur-bersama',             'icon' => 'utensils',         'category' => 'Shared',   'display_order' => 8],
            ['name' => 'Lemari Pakaian',           'slug' => 'lemari-pakaian',            'icon' => 'archive',          'category' => 'Room',     'display_order' => 9],
            ['name' => 'Meja Belajar',             'slug' => 'meja-belajar',              'icon' => 'desk',             'category' => 'Room',     'display_order' => 10],
            ['name' => 'Parkir Motor',             'slug' => 'parkir-motor',              'icon' => 'motorcycle',       'category' => 'Shared',   'display_order' => 11],
            ['name' => 'Laundry Bersama',          'slug' => 'laundry-bersama',           'icon' => 'shirt',            'category' => 'Shared',   'display_order' => 12],
        ];

        foreach ($globalFacilities as $facData) {
            Facility::firstOrCreate(['slug' => $facData['slug']], $facData);
        }
    }
}
