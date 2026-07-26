<?php

namespace Database\Factories;

use App\Models\BoardingHouse;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        $roomNumber = $this->faker->unique()->numberBetween(101, 399);
        $types = ['Standard', 'Deluxe', 'Suite', 'VIP'];
        $type = $this->faker->randomElement($types);
        $rent = match ($type) {
            'Standard' => 1200000.00,
            'Deluxe' => 1800000.00,
            'Suite' => 2500000.00,
            'VIP' => 3500000.00,
        };

        return [
            'boarding_house_id' => BoardingHouse::factory(),
            'room_number' => (string)$roomNumber,
            'room_name' => 'Room ' . $roomNumber,
            'floor' => intval($roomNumber / 100),
            'building_block' => $this->faker->randomElement(['A', 'B', 'C', 'Main']),
            'room_type' => $type,
            'monthly_rent' => $rent,
            'security_deposit' => 500000.00,
            'room_size' => $this->faker->randomElement(['3x4', '4x4', '4x5']),
            'max_occupants' => $type === 'VIP' || $type === 'Suite' ? 2 : 1,
            'gender_restriction' => 'any',
            'status' => 'available',
            'description' => $this->faker->paragraph,
            'internal_notes' => $this->faker->sentence,
            'display_order' => $this->faker->numberBetween(0, 100),
            'room_code' => 'RM-' . Str::upper(Str::random(6)),
            'qr_code_path' => null,
            'is_published' => true,
        ];
    }
}
