<?php

namespace Tests\Feature;

use App\Enums\AnnouncementPriority;
use App\Enums\AnnouncementStatus;
use App\Models\BoardingHouse;
use App\Models\Announcement;
use App\Models\AnnouncementReadReceipt;
use App\Models\InAppNotification;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\AnnouncementService;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;
    private User $user;
    private BoardingHouse $boardingHouse;
    private Room $room;
    private Resident $resident;
    private AnnouncementService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->tenant = Tenant::create([
            'name' => 'Workspace E',
            'slug' => 'workspace-e',
        ]);

        $this->user = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Manager Communication',
            'email' => 'comms@example.com',
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
            'room_number' => '601',
            'room_type' => 'Standard',
            'floor' => 6,
            'monthly_rent' => 2500000.00,
            'status' => 'available',
        ]);

        $this->resident = Resident::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Ethan Hunt',
            'nik' => '3201234567890013',
            'gender' => 'male',
            'date_of_birth' => '1995-04-15',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Technician',
            'marital_status' => 'single',
            'phone' => '0812345684',
            'whatsapp' => '0812345684',
            'email' => 'ethan@example.com',
            'emergency_name' => 'Sarah Hunt',
            'emergency_relationship' => 'Mother',
            'emergency_phone' => '081223368',
            'emergency_address' => 'Jakarta',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Dago Cisitu',
        ]);

        // Add active contract to ensure resident is selected as active target
        \App\Models\Contract::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'contract_number' => 'CTR-2026-999999',
            'contract_type' => 'monthly',
            'status' => \App\Enums\ContractStatus::ACTIVE,
            'start_date' => '2026-07-01',
            'end_date' => '2026-08-01',
            'move_in_date' => '2026-07-01',
            'monthly_rent' => 2500000.00,
            'security_deposit' => 1000000.00,
        ]);

        $this->service = new AnnouncementService();

        app(TenantManager::class)->setTenant($this->tenant);
        session(['active_tenant' => $this->tenant]);
        $this->actingAs($this->user);
    }

    public function test_announcement_can_be_created_and_published_immediately(): void
    {
        $ann = $this->service->createAnnouncement([
            'tenant_id' => $this->tenant->id,
            'title' => 'Water outage schedule notice',
            'summary' => 'Water off on Friday.',
            'content' => 'Water pump repairs scheduled.',
            'category' => 'water_shutdown',
            'priority' => AnnouncementPriority::HIGH->value,
            'target_type' => 'all',
        ]);

        $this->assertDatabaseHas('announcements', [
            'id' => $ann->id,
            'status' => AnnouncementStatus::PUBLISHED->value,
        ]);

        // Mapped active resident receives read receipt slot and in-app notice
        $this->assertDatabaseHas('announcement_read_receipts', [
            'announcement_id' => $ann->id,
            'resident_id' => $this->resident->id,
        ]);

        $this->assertDatabaseHas('in_app_notifications', [
            'resident_id' => $this->resident->id,
            'type' => 'announcement.new',
        ]);
    }

    public function test_announcement_can_be_scheduled_for_future_release(): void
    {
        $futureTime = now()->addDays(2);
        
        $ann = $this->service->createAnnouncement([
            'tenant_id' => $this->tenant->id,
            'title' => 'Upcoming cleaning schedule alert',
            'summary' => 'Common spaces cleaning.',
            'content' => 'Full sweep of stairs and lobbies.',
            'category' => 'cleaning',
            'priority' => AnnouncementPriority::NORMAL->value,
            'target_type' => 'all',
            'publish_at' => $futureTime->format('Y-m-d H:i:s'),
            'status' => AnnouncementStatus::PUBLISHED, // Service will automatically promote to SCHEDULED as it is future dated
        ]);

        $this->assertEquals(AnnouncementStatus::SCHEDULED, $ann->fresh()->status);

        // Receipts not generated yet
        $this->assertDatabaseMissing('announcement_read_receipts', [
            'announcement_id' => $ann->id,
        ]);

        // Travel time to the future!
        $this->travelTo($futureTime->addMinute());

        $this->service->publishScheduledAnnouncements();

        $this->assertEquals(AnnouncementStatus::PUBLISHED, $ann->fresh()->status);

        $this->assertDatabaseHas('announcement_read_receipts', [
            'announcement_id' => $ann->id,
            'resident_id' => $this->resident->id,
        ]);
    }

    public function test_receipt_can_be_marked_as_read(): void
    {
        $ann = $this->service->createAnnouncement([
            'tenant_id' => $this->tenant->id,
            'title' => 'Gate lock replacement notice',
            'summary' => 'New keycards distributed.',
            'content' => 'Collect new keycards from the administrator office.',
            'category' => 'security',
            'priority' => AnnouncementPriority::IMPORTANT->value,
            'target_type' => 'all',
        ]);

        $receipt = AnnouncementReadReceipt::where('announcement_id', $ann->id)
            ->where('resident_id', $this->resident->id)
            ->first();

        $this->assertNull($receipt->read_at);

        $this->service->markAsRead($ann, $this->resident);

        $this->assertNotNull($receipt->fresh()->read_at);
    }
}
