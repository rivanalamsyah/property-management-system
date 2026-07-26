<?php

namespace Database\Factories;

use App\Models\Complaint;
use App\Models\ComplaintComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ComplaintCommentFactory extends Factory
{
    protected $model = ComplaintComment::class;

    public function definition(): array
    {
        return [
            'complaint_id' => Complaint::factory(),
            'user_id' => null,
            'resident_id' => null,
            'comment' => $this->faker->paragraph(1),
            'is_tenant_visible' => true,
            'attachment_path' => null,
        ];
    }
}
