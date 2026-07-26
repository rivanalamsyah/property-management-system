<?php

namespace Database\Factories;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContractFactory extends Factory
{
    protected $model = Contract::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', '-1 months');
        $duration = $this->faker->randomElement([1, 3, 6, 12]);
        $endDate = (clone $startDate)->modify("+{$duration} months");

        return [
            'tenant_id' => Tenant::factory(),
            'boarding_house_id' => BoardingHouse::factory(),
            'room_id' => Room::factory(),
            'resident_id' => Resident::factory(),
            'contract_number' => 'CON-' . Str::upper(Str::random(8)),
            'contract_type' => ContractType::MONTHLY,
            'status' => ContractStatus::ACTIVE,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'move_in_date' => $startDate->format('Y-m-d'),
            'move_out_date' => null,
            'duration_months' => $duration,
            'auto_renewal' => false,
            'monthly_rent' => 1500000.00,
            'security_deposit' => 500000.00,
            'electricity_fee' => 100000.00,
            'water_fee' => 50000.00,
            'internet_fee' => 100000.00,
            'parking_fee' => 50000.00,
            'additional_charges' => 0.00,
            'discount' => 0.00,
            'internal_notes' => $this->faker->sentence,
            'public_notes' => $this->faker->sentence,
            'signed_pdf_path' => null,
            'version' => 1,
        ];
    }
}
