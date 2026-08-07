<?php

namespace App\Livewire\Payment;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class PaymentShow extends Component
{
    use WithFileUploads;

    public string $paymentId;
    public string $reconciliationNotes = '';
    public $proofUpload = null;

    public function mount(string $id): void
    {
        $this->paymentId = $id;
        $payment = Payment::findOrFail($id);

        if (Auth::user()->cannot('view', $payment)) {
            abort(403, 'Unauthorized.');
        }
    }

    public function approvePayment(PaymentService $service): void
    {
        $payment = Payment::findOrFail($this->paymentId);

        if (Auth::user()->cannot('verify', $payment)) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $service->verifyPayment($payment, Auth::user(), true, $this->reconciliationNotes);
            $this->reset(['reconciliationNotes']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Payment approved, verifier stamp attached, and invoice status reconciled!']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function rejectPayment(PaymentService $service): void
    {
        $payment = Payment::findOrFail($this->paymentId);

        if (Auth::user()->cannot('verify', $payment)) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $service->verifyPayment($payment, Auth::user(), false, $this->reconciliationNotes ?: 'Proof validation rejected.');
            $this->reset(['reconciliationNotes']);
            $this->dispatch('toast', ['type' => 'error', 'message' => 'Payment transaction marked as Failed/Rejected.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function uploadResidentProof(PaymentService $service): void
    {
        $payment = Payment::findOrFail($this->paymentId);
        if (Auth::user()->cannot('view', $payment)) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'proofUpload' => ['required', 'image', 'max:4096'], // Max 4MB image
        ]);

        $path = $this->proofUpload->store('proofs', 'public');

        $service->uploadProof($payment, $path);

        $this->reset(['proofUpload']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Proof of payment uploaded successfully. Verification pending.']);
    }

    public function render()
    {
        $payment = Payment::with(['boardingHouse', 'resident', 'invoice.room', 'contract', 'timeline'])
            ->findOrFail($this->paymentId);

        return view('livewire.payment.payment-show', [
            'payment' => $payment,
        ])->layout('layouts.app');
    }
}
