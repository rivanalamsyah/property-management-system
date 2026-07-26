<?php

namespace App\Services;

use App\Enums\InvoiceStatus;
use App\Enums\PaymentStatus;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    public function initiatePayment(array $data): Payment
    {
        return DB::transaction(function () use ($data) {
            $invoice = Invoice::findOrFail($data['invoice_id']);

            // Validate duplicate payment reference bounds
            if (!empty($data['reference_number'])) {
                $duplicateRef = Payment::where('invoice_id', $invoice->id)
                    ->where('reference_number', $data['reference_number'])
                    ->whereIn('status', [PaymentStatus::WAITING_VERIFICATION, PaymentStatus::COMPLETED])
                    ->exists();
                if ($duplicateRef) {
                    throw new \Exception("A transaction with this bank reference number has already been registered.");
                }
            }

            // Calculate outstanding balance to prevent overpayments
            $alreadyPaid = Payment::where('invoice_id', $invoice->id)
                ->whereIn('status', [PaymentStatus::WAITING_VERIFICATION, PaymentStatus::COMPLETED])
                ->sum('amount_paid');

            $outstanding = max(0.00, $invoice->grand_total - $alreadyPaid);
            if ($data['amount_paid'] > $outstanding) {
                throw new \Exception("Amount paid (Rp" . number_format($data['amount_paid'], 0, ',', '.') . ") exceeds the outstanding balance (Rp" . number_format($outstanding, 0, ',', '.') . ") for this invoice.");
            }

            // Autofill parameters from invoice
            $data['tenant_id'] = $invoice->tenant_id;
            $data['boarding_house_id'] = $invoice->boarding_house_id;
            $data['resident_id'] = $invoice->resident_id;
            $data['contract_id'] = $invoice->contract_id;
            $status = $data['status'] ?? PaymentStatus::PENDING;
            $data['status'] = $status;

            if ($status === PaymentStatus::COMPLETED) {
                if (auth()->check()) {
                    $data['verified_by'] = auth()->id();
                }
                $data['verified_at'] = now();
            }

            $payment = Payment::create($data);

            if ($status === PaymentStatus::COMPLETED) {
                $this->addTimelineEvent(
                    payment: $payment,
                    event: 'completed',
                    title: 'Manual Payment Recorded',
                    description: "Payment recorded directly by admin: " . (auth()->check() ? auth()->user()->name : 'System'),
                    icon: 'check',
                    color: 'bg-emerald-500'
                );

                // Auto-reconcile invoice
                $totalReceived = Payment::where('invoice_id', $invoice->id)
                    ->where('status', PaymentStatus::COMPLETED)
                    ->sum('amount_paid');

                if ($totalReceived >= $invoice->grand_total) {
                    $invoice->update(['status' => InvoiceStatus::PAID]);
                    
                    $billingService = new BillingService();
                    $billingService->addTimelineEvent(
                        invoice: $invoice,
                        event: 'paid',
                        title: 'Invoice Fully Paid',
                        description: "Fully settled via manual entry transaction: {$payment->transaction_number}",
                        icon: 'check',
                        color: 'bg-emerald-500'
                    );
                }
            } else {
                $this->addTimelineEvent(
                    payment: $payment,
                    event: 'initiated',
                    title: 'Payment Transaction Initiated',
                    description: "Payment draft created for Rp" . number_format($payment->amount_paid, 0, ',', '.'),
                    icon: 'plus',
                    color: 'bg-slate-500'
                );
            }

            activity_log(
                event: $status === PaymentStatus::COMPLETED ? 'payment.manual_record' : 'payment.initiate',
                description: "Recorded payment {$payment->transaction_number} for invoice {$invoice->invoice_number}",
                tenantId: $payment->tenant_id
            );

            return $payment;
        });
    }

    public function uploadProof(Payment $payment, string $filePath): void
    {
        DB::transaction(function () use ($payment, $filePath) {
            $payment->update([
                'proof_of_payment_path' => $filePath,
                'status' => PaymentStatus::WAITING_VERIFICATION,
            ]);

            $this->addTimelineEvent(
                payment: $payment,
                event: 'proof_uploaded',
                title: 'Proof of Payment Uploaded',
                description: "Resident uploaded file attachments as transfer confirmation proof.",
                icon: 'file',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'payment.upload_proof',
                description: "Uploaded proof for transaction: {$payment->transaction_number}",
                tenantId: $payment->tenant_id
            );
        });
    }

    public function verifyPayment(Payment $payment, User $verifier, bool $approve, ?string $notes = null): void
    {
        DB::transaction(function () use ($payment, $verifier, $approve, $notes) {
            if ($payment->status === PaymentStatus::COMPLETED) {
                throw new \Exception("This payment transaction is already completed and reconciled.");
            }

            if ($approve) {
                $payment->update([
                    'status' => PaymentStatus::COMPLETED,
                    'verified_by' => $verifier->id,
                    'verified_at' => now(),
                    'reconciliation_notes' => $notes,
                ]);

                $this->addTimelineEvent(
                    payment: $payment,
                    event: 'completed',
                    title: 'Payment Verified & Reconciled',
                    description: "Payment checked, approved, and stamped by verifier: {$verifier->name}.",
                    icon: 'check',
                    color: 'bg-emerald-500'
                );

                // Automatic Invoice reconciliation logic
                $invoice = $payment->invoice;
                
                // Fetch sum of all completed payments
                $totalReceived = Payment::where('invoice_id', $invoice->id)
                    ->where('status', PaymentStatus::COMPLETED)
                    ->sum('amount_paid');

                if ($totalReceived >= $invoice->grand_total) {
                    $invoice->update(['status' => InvoiceStatus::PAID]);
                    
                    $billingService = new BillingService();
                    $billingService->addTimelineEvent(
                        invoice: $invoice,
                        event: 'paid',
                        title: 'Invoice Fully Paid',
                        description: "Fully settled via transaction: {$payment->transaction_number}",
                        icon: 'check',
                        color: 'bg-emerald-500'
                    );
                }

                activity_log(
                    event: 'payment.verify_approve',
                    description: "Approved payment {$payment->transaction_number} by verifier: {$verifier->name}",
                    tenantId: $payment->tenant_id
                );
            } else {
                $payment->update([
                    'status' => PaymentStatus::FAILED,
                    'verified_by' => $verifier->id,
                    'verified_at' => now(),
                    'reconciliation_notes' => $notes ?: 'Payment validation failed.',
                ]);

                $this->addTimelineEvent(
                    payment: $payment,
                    event: 'failed',
                    title: 'Payment Rejected',
                    description: "Verification rejected. Reason: " . ($notes ?: 'Unspecified validation error'),
                    icon: 'close',
                    color: 'bg-rose-500'
                );

                activity_log(
                    event: 'payment.verify_reject',
                    description: "Rejected payment {$payment->transaction_number} by verifier: {$verifier->name}",
                    tenantId: $payment->tenant_id
                );
            }
        });
    }

    public function addTimelineEvent(Payment $payment, string $event, string $title, ?string $description = null, ?string $icon = null, ?string $color = null): void
    {
        $payment->timeline()->create([
            'event' => $event,
            'title' => $title,
            'description' => $description,
            'icon' => $icon ?? 'check',
            'color' => $color ?? 'bg-indigo-500',
        ]);
    }
}
