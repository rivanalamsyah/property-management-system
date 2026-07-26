<?php

namespace Tests\Feature;

use App\Enums\ComplaintPriority;
use App\Enums\ComplaintStatus;
use App\Models\BoardingHouse;
use App\Models\Complaint;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\ComplaintService;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ComplaintTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;
    private User $user;
    private BoardingHouse $boardingHouse;
    private Room $room;
    private Resident $resident;
    private ComplaintService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->tenant = Tenant::create([
            'name' => 'Workspace D',
            'slug' => 'workspace-d',
        ]);

        $this->user = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Manager Tech',
            'email' => 'tech@example.com',
            'role' => 'staff',
            'permissions' => ['manage-settings'],
            'password' => bcrypt('password'),
        ]);

        $this->boardingHouse = BoardingHouse::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Cozy Kos Ciumbuleuit',
            'slug' => 'cozy-kos-ciumbuleuit',
            'address' => 'Jl. Ciumbuleuit No. 12, Bandung',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Cidadap',
            'postal_code' => '40141',
            'whatsapp_number' => '0812345680',
        ]);

        $roomService = new \App\Services\RoomService();
        $this->room = $roomService->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '501',
            'room_type' => 'Standard',
            'floor' => 5,
            'monthly_rent' => 2500000.00,
            'status' => 'available',
        ]);

        $this->resident = Resident::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Jack Ryan',
            'nik' => '3201234567890012',
            'gender' => 'male',
            'date_of_birth' => '1995-04-15',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Technician',
            'marital_status' => 'single',
            'phone' => '0812345683',
            'whatsapp' => '0812345683',
            'email' => 'jack@example.com',
            'emergency_name' => 'Rose Ryan',
            'emergency_relationship' => 'Mother',
            'emergency_phone' => '081223367',
            'emergency_address' => 'Jakarta',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Dago Cisitu',
        ]);

        $this->service = new ComplaintService();

        app(TenantManager::class)->setTenant($this->tenant);
        session(['active_tenant' => $this->tenant]);
        $this->actingAs($this->user);
    }

    public function test_complaint_can_be_created(): void
    {
        $complaint = $this->service->createComplaint([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'category' => 'water',
            'priority' => ComplaintPriority::HIGH->value,
            'subject' => 'Leaking pipe in bathroom',
            'description' => 'Water has been leaking under the sink.',
        ]);

        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'complaint_number' => $complaint->complaint_number,
            'status' => ComplaintStatus::OPEN->value,
        ]);

        $this->assertDatabaseHas('complaint_timelines', [
            'complaint_id' => $complaint->id,
            'event' => 'submitted',
        ]);
    }

    public function test_complaint_status_can_be_transitioned(): void
    {
        $complaint = $this->service->createComplaint([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'category' => 'ac',
            'priority' => ComplaintPriority::NORMAL->value,
            'subject' => 'AC not cold',
            'description' => 'AC is blowing warm air.',
        ]);

        $this->service->updateComplaintStatus($complaint, ComplaintStatus::REVIEWED, 'Reviewed and verified leak in filter.');

        $this->assertEquals(ComplaintStatus::REVIEWED, $complaint->fresh()->status);
        $this->assertDatabaseHas('complaint_timelines', [
            'complaint_id' => $complaint->id,
            'event' => 'reviewed',
        ]);
    }

    public function test_complaint_can_be_promoted_to_maintenance_task_with_checklists(): void
    {
        $complaint = $this->service->createComplaint([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'category' => 'electricity',
            'priority' => ComplaintPriority::CRITICAL->value,
            'subject' => 'Short circuit in bathroom light',
            'description' => 'Breaker trips when bathroom light is turned on.',
        ]);

        $task = $this->service->createMaintenanceTask($complaint, [
            'assigned_staff_id' => $this->user->id,
            'estimated_completion_date' => '2026-07-20',
            'cost' => 150000.00,
            'checklists' => [
                'Check socket wiring',
                'Replace fuse box switch',
            ],
        ]);

        $this->assertDatabaseHas('maintenance_tasks', [
            'id' => $task->id,
            'task_number' => $task->task_number,
            'assigned_staff_id' => $this->user->id,
            'cost' => 150000.00,
        ]);

        $this->assertEquals(ComplaintStatus::ASSIGNED, $complaint->fresh()->status);
        $this->assertCount(2, $task->checklists);
    }

    public function test_comments_can_be_posted_on_complaints(): void
    {
        $complaint = $this->service->createComplaint([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'category' => 'furniture',
            'priority' => ComplaintPriority::LOW->value,
            'subject' => 'Broken chair',
            'description' => 'Leg of the study desk chair is loose.',
        ]);

        $comment = $this->service->addComment($complaint, [
            'user_id' => $this->user->id,
            'comment' => 'Will drop by with replacement wood tomorrow morning.',
            'is_tenant_visible' => true,
        ]);

        $this->assertDatabaseHas('complaint_comments', [
            'id' => $comment->id,
            'comment' => 'Will drop by with replacement wood tomorrow morning.',
            'is_tenant_visible' => true,
        ]);
    }
}
