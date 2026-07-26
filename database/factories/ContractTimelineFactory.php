<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\ContractTimeline;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractTimelineFactory extends Factory
{
    protected $model = ContractTimeline::class;

    public function definition(): array
    {
        return [
            'contract_id' => Contract::factory(),
            'event' => $this->faker->randomElement(['created', 'approved', 'signed', 'terminated', 'renewed']),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(6),
            'icon' => 'info',
            'color' => 'bg-blue-500',
        ];
    }
}
