<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\ComplaintTimeline;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintTimelineFactory extends Factory
{
    protected $model = ComplaintTimeline::class;

    public function definition(): array
    {
        return [
            'complaint_id' => Complaint::factory(),
            'event' => $this->faker->randomElement(['created', 'reviewed', 'assigned', 'in_progress', 'completed', 'closed']),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(6),
            'icon' => 'info',
            'color' => 'bg-blue-500',
        ];
    }
}
