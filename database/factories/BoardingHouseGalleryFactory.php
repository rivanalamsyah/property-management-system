<?php

namespace Database\Factories;

use App\Models\BoardingHouse;
use App\Models\BoardingHouseGallery;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardingHouseGalleryFactory extends Factory
{
    protected $model = BoardingHouseGallery::class;

    public function definition(): array
    {
        return [
            'boarding_house_id' => BoardingHouse::factory(),
            'file_path' => 'galleries/placeholder_' . $this->faker->numberBetween(1, 5) . '.jpg',
            'label' => $this->faker->sentence,
            'display_order' => $this->faker->numberBetween(0, 10),
            'is_cover' => false,
        ];
    }
}
