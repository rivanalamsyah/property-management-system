<?php

namespace Database\Factories;

use App\Models\Contract;
use App\Models\ContractAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContractAttachmentFactory extends Factory
{
    protected $model = ContractAttachment::class;

    public function definition(): array
    {
        return [
            'contract_id' => Contract::factory(),
            'file_path' => 'contracts/attachments/placeholder.jpg',
            'name' => 'KTP Scan Attachment',
            'notes' => $this->faker->sentence,
        ];
    }
}
