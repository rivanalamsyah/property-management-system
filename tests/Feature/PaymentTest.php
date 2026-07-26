<?php

namespace Tests\Feature;

use App\Enums\ContractStatus;
use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\BoardingHouse;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Resident;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\User;
use App\Services\PaymentService;
use App\Services\TenantManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    private Tenant $tenant;
    private User $user;
    private BoardingHouse $boardingHouse;
    private Room $room;
    private Resident $resident;
    private Contract $contract;
    private Invoice $invoice;
    private PaymentService $service;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $this->tenant = Tenant::create([
            'name' => 'Workspace C',
            'slug' => 'workspace-c',
        ]);

        $this->user = User::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Manager Verifier',
            'email' => 'verifier@example.com',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'permissions' => ['manage-settings'],
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
            'room_number' => '402',
            'room_type' => 'Executive',
            'floor' => 4,
            'monthly_rent' => 4000000.00,
            'status' => 'available',
        ]);

        $this->resident = Resident::create([
            'tenant_id' => $this->tenant->id,
            'name' => 'Jane Doe',
            'nik' => '3201234567890011',
            'gender' => 'female',
            'date_of_birth' => '1999-04-15',
            'place_of_birth' => 'Jakarta',
            'nationality' => 'WNI',
            'occupation' => 'Designer',
            'marital_status' => 'single',
            'phone' => '0812345682',
            'whatsapp' => '0812345682',
            'email' => 'jane@example.com',
            'emergency_name' => 'Sutrisno',
            'emergency_relationship' => 'Father',
            'emergency_phone' => '081223366',
            'emergency_address' => 'Jakarta',
            'province' => 'Jawa Barat',
            'city' => 'Bandung',
            'district' => 'Coblong',
            'postal_code' => '40135',
            'address' => 'Jl. Dago Cisitu',
        ]);

        $this->contract = Contract::create([
            'tenant_id' => $this->tenant->id,
            'boarding_house_id' => $this->boardingHouse->id,
            'room_id' => $this->room->id,
            'resident_id' => $this->resident->id,
            'contract_number' => 'CTR-2026-777777',
            'contract_type' => 'monthly',
            'status' => ContractStatus::ACTIVE,
            'start_date' => '2026-07-16',
            'end_date' => '2026-08-16',
            'move_in_date' => '2026-07-16',
            'monthly_rent' => 4000000.00,
            'security_deposit' => 1000000.00,
        ]);

        $billingService = new \App\Services\BillingService();
        $this->invoice = $billingService->createInvoiceFromContract(
            contract: $this->contract,
            periodStart: '2026-07-16',
            periodEnd: '2026-08-16'
        );

        $this->service = new PaymentService();

        app(TenantManager::class)->setTenant($this->tenant);
        session(['active_tenant' => $this->tenant]);
        $this->actingAs($this->user);
    }

    public function test_payment_can_be_initiated_linked_to_invoice(): void
    {
        $payment = $this->service->initiatePayment([
            'invoice_id' => $this->invoice->id,
            'payment_date' => '2026-07-16',
            'payment_method' => 'bank_transfer',
            'amount_paid' => 4000000.00,
            'reference_number' => 'BANK-REF-1001',
        ]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'transaction_number' => $payment->transaction_number,
            'status' => PaymentStatus::PENDING->value,
        ]);

        $this->assertDatabaseHas('payment_timelines', [
            'payment_id' => $payment->id,
            'event' => 'initiated',
        ]);
    }

    public function test_payment_can_be_approved_and_auto_reconciles_invoice(): void
    {
        $payment = $this->service->initiatePayment([
            'invoice_id' => $this->invoice->id,
            'payment_date' => '2026-07-16',
            'payment_method' => 'bank_transfer',
            'amount_paid' => 4000000.00,
        ]);

        $this->assertEquals(InvoiceStatus::PENDING, $this->invoice->fresh()->status);

        // Approve payment manual verification
        $this->service->verifyPayment($payment, $this->user, true, 'Looks authentic. Matches bank account statement.');

        $this->assertEquals(PaymentStatus::COMPLETED, $payment->fresh()->status);
        $this->assertEquals($this->user->id, $payment->fresh()->verified_by);

        // Associated invoice is now reconciled and set to Paid!
        $this->assertEquals(InvoiceStatus::PAID, $this->invoice->fresh()->status);

        $this->assertDatabaseHas('payment_timelines', [
            'payment_id' => $payment->id,
            'event' => 'completed',
        ]);
    }

    public function test_payment_can_be_rejected(): void
    {
        $payment = $this->service->initiatePayment([
            'invoice_id' => $this->invoice->id,
            'payment_date' => '2026-07-16',
            'payment_method' => 'bank_transfer',
            'amount_paid' => 4000000.00,
        ]);

        $this->service->verifyPayment($payment, $this->user, false, 'Invalid transfer statement screenshot uploaded.');

        $this->assertEquals(PaymentStatus::FAILED, $payment->fresh()->status);
        // Invoice status remains pending
        $this->assertEquals(InvoiceStatus::PENDING, $this->invoice->fresh()->status);
    }

    public function test_manual_direct_payment_automatically_settles_invoice(): void
    {
        $payment = $this->service->initiatePayment([
            'invoice_id' => $this->invoice->id,
            'payment_date' => '2026-07-16',
            'payment_method' => 'cash',
            'amount_paid' => 4000000.00,
            'status' => PaymentStatus::COMPLETED,
        ]);

        $this->assertEquals(PaymentStatus::COMPLETED, $payment->fresh()->status);
        $this->assertEquals(InvoiceStatus::PAID, $this->invoice->fresh()->status);
    }
}
