<?php

namespace Database\Factories;

use App\Models\BoardingHouse;
use App\Models\BoardingHouseRule;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardingHouseRuleFactory extends Factory
{
    protected $model = BoardingHouseRule::class;

    public function definition(): array
    {
        $rules = [
            'General' => ['No smoking in rooms', 'Keep public area clean', 'Turn off lights when leaving'],
            'Curfew' => ['Gates close at 11:00 PM', 'Inform security for late entry'],
            'Visitor' => ['Guests allowed until 10:00 PM', 'No overnight opposite gender guests'],
            'Pet' => ['No pets allowed', 'Small pets permitted with consent'],
        ];

        $category = $this->faker->randomElement(array_keys($rules));
        $title = $this->faker->randomElement($rules[$category]);

        return [
            'boarding_house_id' => BoardingHouse::factory(),
            'category' => $category,
            'title' => $title,
            'description' => $this->faker->sentence,
            'icon' => 'info-circle',
            'display_order' => $this->faker->numberBetween(0, 10),
            'is_active' => true,
            'is_visible_public' => true,
        ];
    }
}
