<?php

namespace Database\Factories;

use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Resident;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'tenant_id' => Tenant::factory(),
            'invoice_id' => Invoice::factory(),
            'contract_id' => Contract::factory(),
            'resident_id' => Resident::factory(),
            'boarding_house_id' => BoardingHouse::factory(),
            'transaction_number' => 'TX-' . Str::upper(Str::random(10)),
            'reference_number' => 'REF-' . $this->faker->numerify('##########'),
            'payment_date' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'payment_method' => PaymentMethod::BANK_TRANSFER,
            'amount_paid' => 1500000.00,
            'admin_fee' => 0.00,
            'penalty_paid' => 0.00,
            'notes' => $this->faker->sentence,
            'proof_of_payment_path' => 'payments/proofs/placeholder.jpg',
            'status' => PaymentStatus::PENDING,
            'verified_by' => null, // seeded dynamically in seeder
            'verified_at' => null,
            'reconciliation_notes' => null,
        ];
    }
}
