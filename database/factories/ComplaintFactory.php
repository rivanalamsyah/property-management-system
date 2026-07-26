<?php

namespace Database\Factories;

use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use App\Models\BoardingHouse;
use App\Models\Complaint;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ComplaintFactory extends Factory
{
    protected $model = Complaint::class;

    public function definition(): array
    {
        $categories = ['electricity', 'water', 'bathroom', 'ac', 'internet', 'furniture', 'door', 'roof', 'kitchen', 'security', 'cleaning', 'other'];

        return [
            'tenant_id' => Tenant::factory(),
            'boarding_house_id' => BoardingHouse::factory(),
            'room_id' => Room::factory(),
            'resident_id' => Resident::factory(),
            'complaint_number' => 'COM-' . Str::upper(Str::random(8)),
            'category' => $this->faker->randomElement($categories),
            'priority' => ComplaintPriority::NORMAL,
            'status' => ComplaintStatus::OPEN,
            'subject' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph,
            'internal_notes' => $this->faker->sentence,
            'is_tenant_visible' => true,
        ];
    }
}
