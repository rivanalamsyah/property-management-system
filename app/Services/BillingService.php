<?php

namespace App\Services;

use App\Enums\InvoiceItemType;
use App\Enums\InvoiceStatus;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class BillingService
{
    public function createInvoice(array $data, array $items): Invoice
    {
        return DB::transaction(function () use ($data, $items) {
            $data['status'] = $data['status'] ?? InvoiceStatus::DRAFT;
            $invoice = Invoice::create($data);

            foreach ($items as $item) {
                $invoice->items()->create($item);
            }

            $this->recalculateTotals($invoice);

            $this->addTimelineEvent(
                invoice: $invoice,
                event: 'generated',
                title: 'Invoice Generated',
                description: "Invoice draft created under number: {$invoice->invoice_number}",
                icon: 'file',
                color: 'bg-slate-500'
            );

            activity_log(
                event: 'invoice.create',
                description: "Created invoice: {$invoice->invoice_number}",
                tenantId: $invoice->tenant_id
            );

            return $invoice;
        });
    }

    public function createInvoiceFromContract(Contract $contract, string $periodStart, string $periodEnd, ?string $dueDate = null): Invoice
    {
        return DB::transaction(function () use ($contract, $periodStart, $periodEnd, $dueDate) {
            // Validate duplicates for period
            $exists = Invoice::where('contract_id', $contract->id)
                ->whereDate('billing_period_start', $periodStart)
                ->whereDate('billing_period_end', $periodEnd)
                ->exists();
            if ($exists) {
                throw new \Exception("An invoice has already been generated for this contract and billing period ({$periodStart} to {$periodEnd}).");
            }

            $invoiceDate = date('Y-m-d');
            $calculatedDueDate = $dueDate ?: date('Y-m-d', strtotime('+7 days'));

            $invoice = Invoice::create([
                'tenant_id' => $contract->tenant_id,
                'boarding_house_id' => $contract->boarding_house_id,
                'room_id' => $contract->room_id,
                'resident_id' => $contract->resident_id,
                'contract_id' => $contract->id,
                'invoice_date' => $invoiceDate,
                'due_date' => $calculatedDueDate,
                'billing_period_start' => $periodStart,
                'billing_period_end' => $periodEnd,
                'discount' => $contract->discount ?? 0.00,
                'status' => InvoiceStatus::PENDING,
            ]);

            // Add Rent Line Item
            $invoice->items()->create([
                'item_type' => InvoiceItemType::MONTHLY_RENT,
                'name' => 'Monthly Room Rent - Room ' . ($contract->room ? $contract->room->room_number : '-'),
                'amount' => $contract->monthly_rent,
            ]);

            // Add Utilities
            if ($contract->water_fee > 0) {
                $invoice->items()->create([
                    'item_type' => InvoiceItemType::WATER,
                    'name' => 'Water Utility Fee',
                    'amount' => $contract->water_fee,
                ]);
            }
            if ($contract->internet_fee > 0) {
                $invoice->items()->create([
                    'item_type' => InvoiceItemType::INTERNET,
                    'name' => 'Internet Connection Fee',
                    'amount' => $contract->internet_fee,
                ]);
            }
            if ($contract->parking_fee > 0) {
                $invoice->items()->create([
                    'item_type' => InvoiceItemType::PARKING,
                    'name' => 'Parking Space Allocation',
                    'amount' => $contract->parking_fee,
                ]);
            }
            if ($contract->electricity_fee > 0) {
                $invoice->items()->create([
                    'item_type' => InvoiceItemType::ELECTRICITY,
                    'name' => 'Electricity token advance',
                    'amount' => $contract->electricity_fee,
                ]);
            }
            if ($contract->additional_charges > 0) {
                $invoice->items()->create([
                    'item_type' => InvoiceItemType::ADDITIONAL,
                    'name' => 'Additional items charges',
                    'amount' => $contract->additional_charges,
                ]);
            }

            $this->recalculateTotals($invoice);

            $this->addTimelineEvent(
                invoice: $invoice,
                event: 'generated',
                title: 'Recurring Invoice Generated',
                description: "Invoice auto-generated from contract lease #{$contract->contract_number}.",
                icon: 'refresh',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'invoice.generate_contract',
                description: "Auto-generated contract invoice {$invoice->invoice_number}",
                tenantId: $invoice->tenant_id
            );

            return $invoice;
        });
    }

    public function applyLatePenalty(Invoice $invoice, string $penaltyType, float $penaltyValue): void
    {
        DB::transaction(function () use ($invoice, $penaltyType, $penaltyValue) {
            if ($invoice->status === InvoiceStatus::PAID) {
                throw new \Exception("Late penalties cannot be applied to paid invoices.");
            }

            $penaltyAmount = 0.00;
            if ($penaltyType === 'fixed') {
                $penaltyAmount = $penaltyValue;
            } elseif ($penaltyType === 'percentage') {
                $penaltyAmount = round(($penaltyValue * $invoice->subtotal) / 100, 2);
            }

            if ($penaltyAmount <= 0) return;

            // Create Penalty Invoice Item line
            $invoice->items()->create([
                'item_type' => InvoiceItemType::PENALTY,
                'name' => 'Late Payment Fine (' . ($penaltyType === 'percentage' ? $penaltyValue . '%' : 'Fixed') . ')',
                'amount' => $penaltyAmount,
            ]);

            // Update penalty column and recalculate
            $invoice->increment('penalty', $penaltyAmount);
            $invoice->update(['status' => InvoiceStatus::OVERDUE]);
            $this->recalculateTotals($invoice);

            $this->addTimelineEvent(
                invoice: $invoice,
                event: 'penalty_applied',
                title: 'Late Penalty Applied',
                description: "Late payment penalty of Rp" . number_format($penaltyAmount, 0, ',', '.') . " added to invoice.",
                icon: 'exclamation',
                color: 'bg-amber-600'
            );

            activity_log(
                event: 'invoice.apply_penalty',
                description: "Applied late penalty to invoice {$invoice->invoice_number}",
                tenantId: $invoice->tenant_id
            );
        });
    }

    public function updateInvoiceStatus(Invoice $invoice, InvoiceStatus $status): void
    {
        DB::transaction(function () use ($invoice, $status) {
            $oldStatus = $invoice->status;
            $invoice->update(['status' => $status]);

            $this->addTimelineEvent(
                invoice: $invoice,
                event: 'status_change',
                title: 'Invoice Status Shifted',
                description: "Status changed from {$oldStatus->label()} to {$status->label()}.",
                icon: 'info',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'invoice.status_update',
                description: "Updated invoice status to: {$status->value}",
                tenantId: $invoice->tenant_id
            );
        });
    }

    public function deleteInvoice(Invoice $invoice): void
    {
        DB::transaction(function () use ($invoice) {
            if (!in_array($invoice->status->value, ['draft', 'cancelled', 'voided'])) {
                throw new \Exception("Only draft, cancelled, or voided invoices can be deleted.");
            }

            $number = $invoice->invoice_number;
            $tenantId = $invoice->tenant_id;
            $invoice->delete();

            activity_log(
                event: 'invoice.delete',
                description: "Deleted invoice: {$number}",
                tenantId: $tenantId
            );
        });
    }

    public function recalculateTotals(Invoice $invoice): void
    {
        $subtotal = $invoice->items()
            ->where('item_type', '!=', InvoiceItemType::PENALTY->value)
            ->sum('amount');
        
        $penalty = $invoice->items()
            ->where('item_type', InvoiceItemType::PENALTY->value)
            ->sum('amount');

        $discount = $invoice->discount;
        $grandTotal = max(0.00, $subtotal + $penalty - $discount);

        $invoice->update([
            'subtotal' => $subtotal,
            'penalty' => $penalty,
            'grand_total' => $grandTotal,
        ]);
    }

    public function addTimelineEvent(Invoice $invoice, string $event, string $title, ?string $description = null, ?string $icon = null, ?string $color = null): void
    {
        $invoice->timeline()->create([
            'event' => $event,
            'title' => $title,
            'description' => $description,
            'icon' => $icon ?? 'check',
            'color' => $color ?? 'bg-indigo-500',
        ]);
    }
}
