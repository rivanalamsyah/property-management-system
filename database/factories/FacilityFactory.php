<?php

namespace Database\Factories;

use App\Models\Facility;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FacilityFactory extends Factory
{
    protected $model = Facility::class;

    public function definition(): array
    {
        $facilities = [
            ['name' => 'High-Speed Wi-Fi', 'icon' => 'wifi', 'category' => 'Room'],
            ['name' => 'Air Conditioner (AC)', 'icon' => 'bolt', 'category' => 'Room'],
            ['name' => 'Private Bathroom', 'icon' => 'bath', 'category' => 'Room'],
            ['name' => 'Television', 'icon' => 'tv', 'category' => 'Room'],
            ['name' => 'Water Heater', 'icon' => 'thermometer-half', 'category' => 'Room'],
            ['name' => 'Gym Area', 'icon' => 'dumbbell', 'category' => 'Shared'],
            ['name' => 'Co-working Space', 'icon' => 'laptop', 'category' => 'Shared'],
            ['name' => '24/7 Security & CCTV', 'icon' => 'shield-alt', 'category' => 'Security'],
            ['name' => 'Parking Slot', 'icon' => 'parking', 'category' => 'Shared'],
        ];

        $fac = $this->faker->randomElement($facilities);

        return [
            'tenant_id' => $this->faker->boolean(70) ? Tenant::factory() : null, // 30% chance of global defaults
            'name' => $fac['name'],
            'slug' => Str::slug($fac['name']),
            'icon' => $fac['icon'],
            'category' => $fac['category'],
            'description' => $this->faker->sentence,
            'display_order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
        ];
    }
}
