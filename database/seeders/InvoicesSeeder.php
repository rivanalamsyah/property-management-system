<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Resident;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoiceTimeline;
use App\Models\Tenant;
use App\Enums\InvoiceStatus;
use App\Enums\InvoiceItemType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InvoicesSeeder extends Seeder
{
    public function run(): void
    {
        $tenant1 = Tenant::where('slug', 'cihampelas')->first();
        tenant_manager()->setTenant($tenant1);

        $resBudi = Resident::where('tenant_id', $tenant1->id)->where('email', 'penyewa@example.test')->first();
        $resSiti = Resident::where('tenant_id', $tenant1->id)->where('email', 'siti.aminah@example.test')->first();
        $resRudi = Resident::where('tenant_id', $tenant1->id)->where('email', 'rudi.setiawan@example.test')->first();

        $conBudi = Contract::where('resident_id', $resBudi->id)->first();
        $conSiti = Contract::where('resident_id', $resSiti->id)->first();
        $conRudi = Contract::where('resident_id', $resRudi->id)->first();

        // 1. Seed Budi Invoices
        // Month 1 (Deposit + Rent) - Paid
        $this->createInvoice($tenant1, $conBudi, 'INV-GCI-001', now()->subMonths(3), InvoiceStatus::PAID, true);
        // Month 2 - Paid
        $this->createInvoice($tenant1, $conBudi, 'INV-GCI-004', now()->subMonths(2), InvoiceStatus::PAID, false);
        // Month 3 - Paid
        $this->createInvoice($tenant1, $conBudi, 'INV-GCI-007', now()->subMonths(1), InvoiceStatus::PAID, false);
        // Month 4 - Unpaid/Sent
        $this->createInvoice($tenant1, $conBudi, 'INV-GCI-010', now(), InvoiceStatus::SENT, false);

        // 2. Seed Siti Invoices
        // Month 1 (Deposit + Rent) - Paid
        $this->createInvoice($tenant1, $conSiti, 'INV-GCI-002', now()->subMonths(1), InvoiceStatus::PAID, true);
        // Month 2 - Unpaid/Sent
        $this->createInvoice($tenant1, $conSiti, 'INV-GCI-011', now(), InvoiceStatus::SENT, false);

        // 3. Seed Rudi Invoices
        // Month 1 (Deposit + Rent) - Paid
        $this->createInvoice($tenant1, $conRudi, 'INV-GCI-003', now()->subMonths(6), InvoiceStatus::PAID, true);
        // Month 2 to 6 - Paid
        for ($i = 5; $i >= 1; $i--) {
            $this->createInvoice($tenant1, $conRudi, 'INV-GCI-00' . (10 - $i), now()->subMonths($i), InvoiceStatus::PAID, false);
        }
        // Month 7 - Unpaid/Sent
        $this->createInvoice($tenant1, $conRudi, 'INV-GCI-012', now(), InvoiceStatus::SENT, false);

        tenant_manager()->setTenant(null);
    }

    private function createInvoice($tenant, $contract, $number, $createdAt, $status, $includeDeposit): void
    {
        $rentAmount = (float) $contract->monthly_rent;
        $depositAmount = $includeDeposit ? (float) $contract->security_deposit : 0.00;
        $totalAmount = $rentAmount + $depositAmount;

        $invoice = Invoice::firstOrCreate(
            ['tenant_id' => $tenant->id, 'invoice_number' => $number],
            [
                'boarding_house_id'    => $contract->boarding_house_id,
                'room_id'              => $contract->room_id,
                'resident_id'          => $contract->resident_id,
                'contract_id'          => $contract->id,
                'invoice_date'         => $createdAt,
                'due_date'             => $createdAt->copy()->addDays(5),
                'billing_period_start' => $createdAt->copy()->startOfMonth(),
                'billing_period_end'   => $createdAt->copy()->endOfMonth(),
                'subtotal'             => $totalAmount,
                'discount'             => 0.00,
                'penalty'              => 0.00,
                'grand_total'          => $totalAmount,
                'status'               => $status,
            ]
        );

        // Rent Item
        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'item_type'  => InvoiceItemType::MONTHLY_RENT,
            'name'       => 'Biaya Sewa Kamar Periode ' . $createdAt->format('F Y'),
            'amount'     => $rentAmount,
        ]);

        // Deposit Item if true
        if ($includeDeposit) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_type'  => InvoiceItemType::SECURITY_DEPOSIT,
                'name'       => 'Uang Jaminan Keamanan (Security Deposit)',
                'amount'     => $depositAmount,
            ]);
        }

        // Timeline
        InvoiceTimeline::create([
            'invoice_id'  => $invoice->id,
            'event'       => 'generated',
            'title'       => 'Tagihan Diterbitkan',
            'description' => "Tagihan {$number} untuk sewa kamar telah dikirim.",
            'created_at'  => $createdAt,
        ]);

        if ($status === InvoiceStatus::PAID) {
            InvoiceTimeline::create([
                'invoice_id'  => $invoice->id,
                'event'       => 'paid',
                'title'       => 'Tagihan Lunas',
                'description' => "Pembayaran untuk tagihan {$number} telah diverifikasi lunas.",
                'created_at'  => $createdAt->copy()->addDays(1),
            ]);
        }
    }
}
