<?php

namespace Tests\Feature;

use App\Enums\ComplaintStatus;
use App\Enums\ContractStatus;
use App\Enums\PaymentStatus;
use App\Enums\ResidentStatus;
use App\Models\BoardingHouse;
use App\Models\Complaint;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ResidentPortalTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;
    private User $residentUser1;
    private User $residentUser2;
    private User $adminUser;
    private Resident $resident1;
    private Resident $resident2;
    private BoardingHouse $boardingHouse;
    private Room $room1;
    private Room $room2;
    private Contract $contract1;
    private Contract $contract2;

    protected function setUp(): void
    {
        parent::setUp();

        // 1. Create workspace
        $this->tenant = Tenant::create([
            'name' => 'Paradise Kos Organization',
            'slug' => 'paradise-kos',
        ]);

        // Set active workspace context
        app(\App\Services\TenantManager::class)->setTenant($this->tenant);

        // 2. Create Roles
        $ownerRole = Role::create([
            'name' => 'owner',
            'label' => 'Boarding House Owner',
        ]);

        $tenantRole = Role::create([
            'name' => 'tenant',
            'label' => 'Resident (Tenant)',
        ]);

        // 3. Create Users
        $this->adminUser = User::create([
            'name' => 'Owner Landlord',
            'email' => 'owner@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->adminUser->email_verified_at = now();
        $this->adminUser->save();
        $this->adminUser->tenants()->attach($this->tenant->id, ['role_id' => $ownerRole->id, 'is_active' => true]);

        $this->residentUser1 = User::create([
            'name' => 'Bruce Wayne',
            'email' => 'bruce@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->residentUser1->email_verified_at = now();
        $this->residentUser1->save();
        $this->residentUser1->tenants()->attach($this->tenant->id, ['role_id' => $tenantRole->id, 'is_active' => true]);

        $this->residentUser2 = User::create([
            'name' => 'Clark Kent',
            'email' => 'clark@example.com',
            'password' => bcrypt('password'),
        ]);
        $this->residentUser2->email_verified_at = now();
        $this->residentUser2->save();
        $this->residentUser2->tenants()->attach($this->tenant->id, ['role_id' => $tenantRole->id, 'is_active' => true]);

        // 4. Create Boarding House
        $this->boardingHouse = BoardingHouse::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Wayne Manor Kos',
            'slug' => 'wayne-manor-kos',
            'address' => 'Gotham City',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'whatsapp_number' => '0812345678',
        ]);

        // 5. Create Rooms
        $roomService = new \App\Services\RoomService();
        $this->room1 = $roomService->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '101',
            'room_type' => 'Standard',
            'floor' => 1,
            'monthly_rent' => 2000000.00,
            'status' => 'available',
        ]);

        $this->room2 = $roomService->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '102',
            'room_type' => 'Standard',
            'floor' => 1,
            'monthly_rent' => 2000000.00,
            'status' => 'available',
        ]);

        // 6. Create Residents
        $this->resident1 = Resident::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room1->id,
            'name' => 'Bruce Wayne',
            'nik' => '3201234567890001',
            'gender' => 'male',
            'date_of_birth' => '1995-05-12',
            'place_of_birth' => 'Gotham',
            'nationality' => 'WNI',
            'occupation' => 'Philanthropist',
            'marital_status' => 'single',
            'phone' => '0812345678',
            'whatsapp' => '0812345678',
            'email' => 'bruce@example.com',
            'emergency_name' => 'Alfred',
            'emergency_relationship' => 'Butler',
            'emergency_phone' => '081223344',
            'emergency_address' => 'Gotham',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Wayne Manor',
            'status' => ResidentStatus::ACTIVE,
        ]);

        $this->resident2 = Resident::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room2->id,
            'name' => 'Clark Kent',
            'nik' => '3201234567890002',
            'gender' => 'male',
            'date_of_birth' => '1995-06-12',
            'place_of_birth' => 'Metropolis',
            'nationality' => 'WNI',
            'occupation' => 'Reporter',
            'marital_status' => 'single',
            'phone' => '0812345679',
            'whatsapp' => '0812345679',
            'email' => 'clark@example.com',
            'emergency_name' => 'Martha',
            'emergency_relationship' => 'Mother',
            'emergency_phone' => '081223345',
            'emergency_address' => 'Smallville',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Metropolis',
            'status' => ResidentStatus::ACTIVE,
        ]);

        // 7. Create Contracts
        $this->contract1 = Contract::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room1->id,
            'resident_id' => $this->resident1->id,
            'contract_number' => 'CTR-2026-000001',
            'contract_type' => 'monthly',
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-07-01',
            'end_date' => '2026-08-01',
            'move_in_date' => '2026-07-01',
            'monthly_rent' => 2000000.00,
            'security_deposit' => 1000000.00,
        ]);

        $this->contract2 = Contract::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room2->id,
            'resident_id' => $this->resident2->id,
            'contract_number' => 'CTR-2026-000002',
            'contract_type' => 'monthly',
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-07-01',
            'end_date' => '2026-08-01',
            'move_in_date' => '2026-07-01',
            'monthly_rent' => 2000000.00,
            'security_deposit' => 1000000.00,
        ]);

        session(['active_tenant' => $this->tenant]);
    }

    public function test_resident_can_view_own_dashboard(): void
    {
        $this->actingAs($this->residentUser1);

        Livewire::test(\App\Livewire\Dashboard::class)
            ->assertViewHas('resident', fn($res) => $res->id === $this->resident1->id)
            ->assertSee('Bruce Wayne')
            ->assertSee('CTR-2026-000001')
            ->assertDontSee('Clark Kent');
    }

    public function test_resident_cannot_access_another_residents_room(): void
    {
        $this->actingAs($this->residentUser1);

        $response = $this->get("/dashboard/rooms/{$this->room2->id}/edit");
        $response->assertStatus(403);
    }

    public function test_resident_cannot_access_another_residents_contract(): void
    {
        $this->actingAs($this->residentUser1);

        $response = $this->get("/dashboard/contracts/{$this->contract2->id}");
        $response->assertStatus(403);
    }

    public function test_resident_can_submit_check_out_request(): void
    {
        $this->actingAs($this->residentUser1);

        Livewire::test(\App\Livewire\Dashboard::class)
            ->call('submitCheckOut', $this->contract1->id)
            ->assertHasNoErrors();

        $this->assertEquals(ResidentStatus::MOVING_OUT, $this->resident1->fresh()->status);
    }

    public function test_resident_can_submit_complaint_and_post_comments(): void
    {
        $this->actingAs($this->residentUser1);

        // Submit Complaint
        Livewire::test(\App\Livewire\Dashboard::class)
            ->set('complaintTitle', 'Leaking bathroom faucet')
            ->set('complaintCategory', 'plumbing')
            ->set('complaintDescription', 'The faucet drips incessantly causing pool of water.')
            ->call('submitComplaint')
            ->assertHasNoErrors();

        $complaint = Complaint::where('resident_id', $this->resident1->id)->first();
        $this->assertNotNull($complaint);
        $this->assertEquals('Leaking bathroom faucet', $complaint->subject);

        // Post Comment
        Livewire::test(\App\Livewire\Dashboard::class)
            ->set('newCommentText', 'Please assign John the plumber if possible.')
            ->call('postComment', $complaint->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('complaint_comments', [
            'complaint_id' => $complaint->id,
            'comment' => 'Please assign John the plumber if possible.',
            'resident_id' => $this->resident1->id,
        ]);
    }

    public function test_resident_can_register_payment_proof(): void
    {
        $this->actingAs($this->residentUser1);
        Storage::fake('public');

        // Create mock invoice
        $invoice = Invoice::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room1->id,
            'resident_id' => $this->resident1->id,
            'contract_id' => $this->contract1->id,
            'invoice_number' => 'INV-2026-000001',
            'invoice_date' => '2026-07-01',
            'billing_period_start' => '2026-07-01',
            'billing_period_end' => '2026-08-01',
            'due_date' => '2026-07-10',
            'subtotal' => 2000000.00,
            'grand_total' => 2000000.00,
            'status' => \App\Enums\InvoiceStatus::PENDING,
        ]);

        $file = UploadedFile::fake()->image('receipt.jpg');

        Livewire::test(\App\Livewire\Dashboard::class)
            ->set('paymentInvoiceId', $invoice->id)
            ->set('paymentReferenceNumber', 'TRF-BCA-10293')
            ->set('paymentProofFile', $file)
            ->call('uploadPaymentProof')
            ->assertHasNoErrors();

        $payment = Payment::where('invoice_id', $invoice->id)->first();
        $this->assertNotNull($payment);
        $this->assertEquals(PaymentStatus::WAITING_VERIFICATION, $payment->status);
        $this->assertEquals('TRF-BCA-10293', $payment->reference_number);
    }
}
