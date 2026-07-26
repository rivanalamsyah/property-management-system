<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\AnnouncementReadReceipt;
use App\Models\Resident;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementReadReceiptFactory extends Factory
{
    protected $model = AnnouncementReadReceipt::class;

    public function definition(): array
    {
        return [
            'announcement_id' => Announcement::factory(),
            'resident_id' => Resident::factory(),
            'read_at' => now(),
        ];
    }
}
