<?php

namespace Database\Factories;

use App\Enums\AnnouncementPriority;
use App\Enums\AnnouncementStatus;
use App\Models\Announcement;
use App\Models\BoardingHouse;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        $categories = ['general', 'maintenance', 'water_shutdown', 'cleaning', 'rent_reminder', 'emergency', 'holiday', 'promotional', 'other'];

        return [
            'tenant_id' => Tenant::factory(),
            'boarding_house_id' => BoardingHouse::factory(),
            'announcement_number' => 'ANN-' . Str::upper(Str::random(8)),
            'title' => $this->faker->sentence(4),
            'summary' => $this->faker->sentence(10),
            'content' => $this->faker->paragraph(3),
            'category' => $this->faker->randomElement($categories),
            'priority' => AnnouncementPriority::NORMAL,
            'status' => AnnouncementStatus::PUBLISHED,
            'target_type' => 'all',
            'target_filters' => null,
            'publish_at' => now(),
            'expires_at' => now()->addDays(7),
            'pinned_at' => null,
            'author_id' => null, // seeded in DatabaseSeeder
            'attachment_path' => null,
            'attachment_name' => null,
        ];
    }
}
