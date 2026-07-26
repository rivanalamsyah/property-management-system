<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $invoiceDate = $this->faker->dateTimeBetween('-3 months', 'now');
        $dueDate = (clone $invoiceDate)->modify('+5 days');
        $billingStart = (clone $invoiceDate)->modify('first day of this month');
        $billingEnd = (clone $invoiceDate)->modify('last day of this month');

        return [
            'tenant_id' => Tenant::factory(),
            'boarding_house_id' => BoardingHouse::factory(),
            'room_id' => Room::factory(),
            'resident_id' => Resident::factory(),
            'contract_id' => Contract::factory(),
            'invoice_number' => 'INV-' . Str::upper(Str::random(8)),
            'invoice_date' => $invoiceDate->format('Y-m-d'),
            'due_date' => $dueDate->format('Y-m-d'),
            'billing_period_start' => $billingStart->format('Y-m-d'),
            'billing_period_end' => $billingEnd->format('Y-m-d'),
            'subtotal' => 1500000.00,
            'discount' => 0.00,
            'penalty' => 0.00,
            'grand_total' => 1500000.00,
            'status' => InvoiceStatus::PENDING,
            'notes' => $this->faker->sentence,
        ];
    }
}
