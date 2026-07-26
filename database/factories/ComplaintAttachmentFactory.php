<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\ComplaintAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintAttachmentFactory extends Factory
{
    protected $model = ComplaintAttachment::class;

    public function definition(): array
    {
        return [
            'complaint_id' => Complaint::factory(),
            'file_path' => 'complaints/attachments/placeholder.jpg',
            'name' => 'Complaint Photo Attachment',
            'notes' => $this->faker->sentence,
        ];
    }
}
