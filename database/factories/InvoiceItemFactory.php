<?php

namespace Database\Factories;

use App\Enums\InvoiceItemType;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    protected $model = InvoiceItem::class;

    public function definition(): array
    {
        $types = [
            ['type' => InvoiceItemType::MONTHLY_RENT, 'name' => 'Monthly Rental Fee', 'amount' => 1500000.00],
            ['type' => InvoiceItemType::ELECTRICITY, 'name' => 'Electricity Utility Charge', 'amount' => 100000.00],
            ['type' => InvoiceItemType::WATER, 'name' => 'Water Utility Charge', 'amount' => 50000.00],
            ['type' => InvoiceItemType::INTERNET, 'name' => 'High-Speed Internet Service', 'amount' => 100000.00],
        ];

        $item = $this->faker->randomElement($types);

        return [
            'invoice_id' => Invoice::factory(),
            'item_type' => $item['type'],
            'name' => $item['name'],
            'amount' => $item['amount'],
            'notes' => $this->faker->sentence,
        ];
    }
}
