<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\PaymentTimeline;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentTimelineFactory extends Factory
{
    protected $model = PaymentTimeline::class;

    public function definition(): array
    {
        return [
            'payment_id' => Payment::factory(),
            'event' => $this->faker->randomElement(['submitted', 'waiting_verification', 'verified', 'failed', 'cancelled']),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(6),
            'icon' => 'info',
            'color' => 'bg-blue-500',
        ];
    }
}
