<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\MaintenanceTask;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MaintenanceTaskFactory extends Factory
{
    protected $model = MaintenanceTask::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'complaint_id' => Complaint::factory(),
            'task_number' => 'TSK-' . Str::upper(Str::random(8)),
            'assigned_staff_id' => null, // set in DatabaseSeeder
            'assigned_at' => now(),
            'estimated_completion_date' => $this->faker->dateTimeBetween('now', '+3 days')->format('Y-m-d'),
            'actual_completion_date' => null,
            'repair_notes' => null,
            'replacement_parts' => null,
            'cost' => 0.00,
        ];
    }
}
