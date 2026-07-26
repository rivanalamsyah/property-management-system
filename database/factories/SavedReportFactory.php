<?php

namespace Database\Factories;

use App\Models\SavedReport;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SavedReportFactory extends Factory
{
    protected $model = SavedReport::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'name' => $this->faker->sentence(3) . ' Report',
            'report_type' => $this->faker->randomElement(['financial', 'occupancy', 'maintenance', 'complaints']),
            'filters' => ['boarding_house_id' => 'all', 'period' => 'this_month'],
            'user_id' => User::factory(),
        ];
    }
}
