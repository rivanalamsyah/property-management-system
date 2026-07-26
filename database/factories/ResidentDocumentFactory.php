<?php

namespace Database\Factories;

use App\Models\Resident;
use App\Models\ResidentDocument;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResidentDocumentFactory extends Factory
{
    protected $model = ResidentDocument::class;

    public function definition(): array
    {
        return [
            'resident_id' => Resident::factory(),
            'document_type' => $this->faker->randomElement(['KTP', 'KTM', 'KK', 'Surat Nikah', 'Paspor']),
            'file_path' => 'documents/placeholder_' . $this->faker->randomElement(['ktp', 'ktm']) . '.pdf',
            'label' => $this->faker->sentence,
        ];
    }
}
