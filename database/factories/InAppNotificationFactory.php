<?php

namespace Database\Factories;

use App\Models\InAppNotification;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class InAppNotificationFactory extends Factory
{
    protected $model = InAppNotification::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['info', 'warning', 'success', 'error']),
            'data' => [
                'title' => $this->faker->sentence(4),
                'message' => $this->faker->sentence(10),
                'action_url' => null,
            ],
            'read_at' => null,
        ];
    }
}
