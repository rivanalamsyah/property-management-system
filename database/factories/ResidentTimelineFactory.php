<?php

namespace Database\Factories;

use App\Models\Resident;
use App\Models\ResidentTimeline;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentTimelineFactory extends Factory
{
    protected $model = ResidentTimeline::class;

    public function definition(): array
    {
        return [
            'resident_id' => Resident::factory(),
            'event' => $this->faker->randomElement(['registered', 'checked_in', 'contract_signed', 'payment_verified', 'complaint_filed']),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(6),
            'icon' => 'info',
            'color' => 'bg-blue-500',
            'metadata' => null,
        ];
    }
}
