<?php

namespace Database\Factories;

use App\Models\BoardingHouse;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class BoardingHouseFactory extends Factory
{
    protected $model = BoardingHouse::class;

    public function definition(): array
    {
        $name = 'Kosan ' . $this->faker->unique()->streetName;
        return [
            'tenant_id' => Tenant::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'logo' => null,
            'cover_image' => null,
            'description' => $this->faker->paragraph,
            'address' => $this->faker->address,
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => $this->faker->postcode,
            'latitude' => $this->faker->latitude(-6.95, -6.85),
            'longitude' => $this->faker->longitude(107.55, 107.65),
            'whatsapp_number' => '0812' . $this->faker->numerify('########'),
            'email' => $this->faker->safeEmail,
            'operating_hours' => '24 Hours',
            'status' => 'active',
            'is_public' => true,
            'settings' => BoardingHouse::defaultSettings(),
        ];
    }
}
