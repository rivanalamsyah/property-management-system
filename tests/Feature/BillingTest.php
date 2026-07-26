<?php

namespace Tests\Feature;

use App\Enums\ContractStatus;
use App\Enums\InvoiceItemType;
use App\Enums\InvoiceStatus;
use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\BillingService;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;
    private User $user;
    private BoardingHouse $boardingHouse;
    private Room $room;
    private Resident $resident;
    private Contract $contract;
    private BillingService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tenant = Tenant::create([
            'name' => 'Workspace B',
            'slug' => 'workspace-b',
        ]);

        $this->user = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Finance Staff',
            'email' => 'finance@example.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'permissions' => ['manage-settings'],
        ]);

        $this->boardingHouse = BoardingHouse::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Vibrant Kos Setiabudi',
            'slug' => 'vibrant-kos-setiabudi',
            'address' => 'Jl. Setiabudi No. 45, Bandung',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Cidadap',
            'postal_code' => '40141',
            'whatsapp_number' => '0812345679',
        ]);

        $roomService = new \App\Services\RoomService();
        $this->room = $roomService->createRoom([
            'boarding_house_id' => $this->boardingHouse->id,
            'room_number' => '301',
            'room_type' => 'Suite',
            'floor' => 3,
            'monthly_rent' => 3000000.00,
            'status' => 'available',
        ]);

        $this->resident = Resident::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'John Doe',
            'nik' => '3201234567890009',
            'gender' => 'male',
            'date_of_birth' => '1997-03-10',
            'place_of_birth' => 'Bandung',
            'nationality' => 'WNI',
            'occupation' => 'Analyst',
            'marital_status' => 'single',
            'phone' => '0812345681',
            'whatsapp' => '0812345681',
            'email' => 'john@example.com',
            'emergency_name' => 'Hasan',
            'emergency_relationship' => 'Father',
            'emergency_phone' => '081223355',
            'emergency_address' => 'Jakarta',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Cisitu',
        ]);

        $this->contract = Contract::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'contract_number' => 'CTR-2026-888888',
            'contract_type' => 'monthly',
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-07-16',
            'end_date' => '2026-08-16',
            'move_in_date' => '2026-07-16',
            'monthly_rent' => 3000000.00,
            'security_deposit' => 1000000.00,
            'water_fee' => 50000.00,
            'internet_fee' => 100000.00,
            'discount' => 200000.00,
        ]);

        $this->service = new BillingService();

        app(TenantManager::class)->setTenant($this->tenant);
        session(['active_tenant' => $this->tenant]);
        $this->actingAs($this->user);
    }

    public function test_invoice_can_be_generated_from_contract(): void
    {
        $invoice = $this->service->createInvoiceFromContract(
            contract: $this->contract,
            periodStart: '2026-07-16',
            periodEnd: '2026-08-16',
            dueDate: '2026-07-25'
        );

        $this->assertDatabaseHas('invoices', [
            'id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'discount' => 200000.00,
            'status' => InvoiceStatus::PENDING->value,
        ]);

        // Verify items generated
        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $invoice->id,
            'item_type' => InvoiceItemType::MONTHLY_RENT->value,
            'amount' => 3000000.00,
        ]);

        $this->assertDatabaseHas('invoice_items', [
            'invoice_id' => $invoice->id,
            'item_type' => InvoiceItemType::WATER->value,
            'amount' => 50000.00,
        ]);

        // Expected Total: Room Rent (3,000,000) + Water (50,000) + Internet (100,000) - Discount (200,000) = 2,950,000
        $this->assertEquals(2950000.00, $invoice->fresh()->grand_total);
    }

    public function test_cannot_generate_duplicate_invoice_for_same_period(): void
    {
        $this->service->createInvoiceFromContract(
            contract: $this->contract,
            periodStart: '2026-07-16',
            periodEnd: '2026-08-16'
        );

        $this->expectException(\Exception::class);
        $this->service->createInvoiceFromContract(
            contract: $this->contract,
            periodStart: '2026-07-16',
            periodEnd: '2026-08-16'
        );
    }

    public function test_late_payment_penalty_can_be_applied(): void
    {
        $invoice = $this->service->createInvoiceFromContract(
            contract: $this->contract,
            periodStart: '2026-07-16',
            periodEnd: '2026-08-16'
        );

        // Subtotal = Rent (3,000,000) + Water (50,000) + Internet (100,000) = 3,150,000.
        // Apply 10% penalty = 315,000
        $this->service->applyLatePenalty($invoice, 'percentage', 10);

        $invoice = $invoice->fresh();
        $this->assertEquals(315000.00, $invoice->penalty);
        
        // Expected Grand Total: Subtotal (3,150,000) + Penalty (315,000) - Discount (200,000) = 3,265,000
        $this->assertEquals(3265000.00, $invoice->grand_total);
        $this->assertEquals(InvoiceStatus::OVERDUE, $invoice->status);
    }

    public function test_manual_invoice_charge_item_can_be_added(): void
    {
        $invoice = $this->service->createInvoiceFromContract(
            contract: $this->contract,
            periodStart: '2026-07-16',
            periodEnd: '2026-08-16'
        );

        $invoice->items()->create([
            'item_type' => InvoiceItemType::LAUNDRY,
            'name' => 'Laundry service (10kg)',
            'amount' => 80000.00,
        ]);

        $this->service->recalculateTotals($invoice);

        // Previous Expected Grand Total: 2,950,000 + Laundry (80,000) = 3,030,000
        $this->assertEquals(3030000.00, $invoice->fresh()->grand_total);
    }
}
