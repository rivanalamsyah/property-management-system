<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoiceTimeline;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceTimelineFactory extends Factory
{
    protected $model = InvoiceTimeline::class;

    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'event' => $this->faker->randomElement(['created', 'sent', 'viewed', 'payment_submitted', 'paid', 'overdue']),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(6),
            'icon' => 'info',
            'color' => 'bg-blue-500',
        ];
    }
}
