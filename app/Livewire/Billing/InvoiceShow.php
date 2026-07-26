<?php

namespace App\Livewire\Billing;

use App\Enums\InvoiceItemType;
use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Services\BillingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class InvoiceShow extends Component
{
    public string $invoiceId;

    // Penalty inputs
    public string $penaltyType = 'fixed';
    public float $penaltyValue = 0.00;

    // Manual item inputs
    public string $manualItemType = 'additional';
    public string $manualItemName = '';
    public float $manualItemAmount = 0.00;
    public string $manualItemNotes = '';

    // Manual payment recording fields
    public bool $showPaymentModal = false;
    public string $payMethod = 'bank_transfer';
    public string $payReference = '';
    public float $payAmount = 0.00;
    public string $payNotes = '';

    public function mount(string $id): void
    {
        $this->invoiceId = $id;
        $invoice = Invoice::findOrFail($id);

        if (Auth::user()->cannot('view', $invoice)) {
            abort(403, 'Unauthorized.');
        }

        // Set default manual payment amount to outstanding invoice balance
        $alreadyPaid = \App\Models\Payment::where('invoice_id', $invoice->id)
            ->whereIn('status', [\App\Enums\PaymentStatus::COMPLETED, \App\Enums\PaymentStatus::WAITING_VERIFICATION])
            ->sum('amount_paid');
        $this->payAmount = (float) max(0.00, $invoice->grand_total - $alreadyPaid);
    }

    public function recordManualPayment(\App\Services\PaymentService $paymentService): void
    {
        $invoice = Invoice::findOrFail($this->invoiceId);

        if (Auth::user()->cannot('update', $invoice)) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'payMethod' => ['required', 'string', 'in:cash,bank_transfer,virtual_account,qris,credit_card,debit_card,ewallet'],
            'payReference' => ['nullable', 'string', 'max:100'],
            'payAmount' => ['required', 'numeric', 'min:1'],
            'payNotes' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $paymentService->initiatePayment([
                'invoice_id' => $invoice->id,
                'payment_date' => date('Y-m-d'),
                'payment_method' => $this->payMethod,
                'amount_paid' => $this->payAmount,
                'reference_number' => $this->payReference,
                'notes' => $this->payNotes,
                'status' => \App\Enums\PaymentStatus::COMPLETED,
            ]);

            $this->showPaymentModal = false;
            $this->reset(['payReference', 'payNotes']);
            
            $alreadyPaid = \App\Models\Payment::where('invoice_id', $invoice->id)
                ->whereIn('status', [\App\Enums\PaymentStatus::COMPLETED, \App\Enums\PaymentStatus::WAITING_VERIFICATION])
                ->sum('amount_paid');
            $this->payAmount = (float) max(0.00, $invoice->grand_total - $alreadyPaid);

            $this->dispatch('toast', ['type' => 'success', 'message' => 'Manual payment transaction recorded and reconciled successfully!']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function markAsPaid(BillingService $service): void
    {
        $invoice = Invoice::findOrFail($this->invoiceId);

        if (Auth::user()->cannot('update', $invoice)) {
            abort(403, 'Unauthorized.');
        }

        try {
            $service->updateInvoiceStatus($invoice, InvoiceStatus::PAID);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Invoice marked as Paid.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function markAsCancelled(BillingService $service): void
    {
        $invoice = Invoice::findOrFail($this->invoiceId);

        if (Auth::user()->cannot('update', $invoice)) {
            abort(403, 'Unauthorized.');
        }

        try {
            $service->updateInvoiceStatus($invoice, InvoiceStatus::CANCELLED);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Invoice marked as Cancelled.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function markAsVoided(BillingService $service): void
    {
        $invoice = Invoice::findOrFail($this->invoiceId);

        if (Auth::user()->cannot('update', $invoice)) {
            abort(403, 'Unauthorized.');
        }

        try {
            $service->updateInvoiceStatus($invoice, InvoiceStatus::VOIDED);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Invoice marked as Voided.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function applyPenalty(BillingService $service): void
    {
        $invoice = Invoice::findOrFail($this->invoiceId);

        if (Auth::user()->cannot('update', $invoice)) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'penaltyType' => ['required', 'string', 'in:fixed,percentage'],
            'penaltyValue' => ['required', 'numeric', 'min:1'],
        ]);

        try {
            $service->applyLatePenalty($invoice, $this->penaltyType, $this->penaltyValue);
            $this->reset(['penaltyValue']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Late payment penalty item applied successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function addManualChargeItem(BillingService $service): void
    {
        $invoice = Invoice::findOrFail($this->invoiceId);

        if (Auth::user()->cannot('update', $invoice)) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'manualItemType' => ['required', 'string', 'in:electricity,water,internet,parking,laundry,cleaning,maintenance,additional,manual'],
            'manualItemName' => ['required', 'string', 'max:100'],
            'manualItemAmount' => ['required', 'numeric', 'min:1'],
            'manualItemNotes' => ['nullable', 'string', 'max:255'],
        ]);

        try {
            $invoice->items()->create([
                'item_type' => $this->manualItemType,
                'name' => $this->manualItemName,
                'amount' => $this->manualItemAmount,
                'notes' => $this->manualItemNotes,
            ]);

            $service->recalculateTotals($invoice);

            $service->addTimelineEvent(
                invoice: $invoice,
                event: 'manual_item_added',
                title: 'Manual Charge Added',
                description: "Added: {$this->manualItemName} for Rp" . number_format($this->manualItemAmount, 0, ',', '.'),
                icon: 'plus',
                color: 'bg-indigo-500'
            );

            $this->reset(['manualItemName', 'manualItemAmount', 'manualItemNotes']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Manual charge item appended to invoice.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $invoice = Invoice::with(['boardingHouse', 'room', 'resident', 'contract', 'items', 'timeline'])
            ->findOrFail($this->invoiceId);

        return view('livewire.billing.invoice-show', [
            'invoice' => $invoice,
        ])->layout('layouts.app');
    }
}
