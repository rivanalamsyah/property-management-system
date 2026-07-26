<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomImageFactory extends Factory
{
    protected $model = RoomImage::class;

    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'file_path' => 'rooms/placeholder_' . $this->faker->numberBetween(1, 5) . '.jpg',
            'label' => $this->faker->sentence,
            'is_cover' => false,
            'display_order' => $this->faker->numberBetween(0, 10),
        ];
    }
}
