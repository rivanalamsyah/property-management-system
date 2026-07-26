<?php

namespace Database\Factories;

use App\Models\MaintenanceChecklist;
use App\Models\MaintenanceTask;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceChecklistFactory extends Factory
{
    protected $model = MaintenanceChecklist::class;

    public function definition(): array
    {
        return [
            'maintenance_task_id' => MaintenanceTask::factory(),
            'item' => $this->faker->sentence(5),
            'is_completed' => false,
        ];
    }
}
