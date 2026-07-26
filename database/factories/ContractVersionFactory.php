<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\ContractVersion;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractVersionFactory extends Factory
{
    protected $model = ContractVersion::class;

    public function definition(): array
    {
        return [
            'contract_id' => Contract::factory(),
            'version_number' => 1,
            'previous_values' => ['monthly_rent' => 1500000.00],
            'reason' => 'Initial Agreement',
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
