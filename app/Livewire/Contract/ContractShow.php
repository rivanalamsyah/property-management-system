<?php

namespace App\Livewire\Contract;

use App\Models\Contract;
use App\Models\ContractAttachment;
use App\Services\ContractService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ContractShow extends Component
{
    use WithFileUploads;

    public string $contractId;
    public string $activeTab = 'preview'; // preview, renew, attachments, history, timeline

    // Renewal inputs
    public string $renewal_start_date = '';
    public string $renewal_end_date = '';
    public int $renewal_duration_months = 1;
    public float $renewal_monthly_rent = 0.00;
    public string $renewal_reason = '';

    // Attachment uploads
    public $attachUpload = null;
    public string $attachLabel = '';

    public function mount(string $id): void
    {
        $this->contractId = $id;
        $contract = Contract::findOrFail($id);

        if (Auth::user()->can('view', $contract)) {
            // Default renewal inputs
            $this->renewal_start_date = date('Y-m-d');
            $this->renewal_end_date = date('Y-m-d', strtotime('+1 month'));
            $this->renewal_monthly_rent = (float) $contract->monthly_rent;
        } else {
            abort(403, 'Unauthorized.');
        }
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function activateAgreement(ContractService $service): void
    {
        $contract = Contract::findOrFail($this->contractId);

        if (Auth::user()->cannot('update', $contract)) {
            abort(403, 'Unauthorized.');
        }

        try {
            $service->activateContract($contract);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Lease contract is now Active and PDF agreement generated!']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function executeRenewal(ContractService $service): void
    {
        $contract = Contract::findOrFail($this->contractId);

        if (Auth::user()->cannot('update', $contract)) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'renewal_start_date' => ['required', 'date', 'after_or_equal:now'],
            'renewal_end_date' => ['required', 'date', 'after:renewal_start_date'],
            'renewal_duration_months' => ['required', 'integer', 'min:1'],
            'renewal_monthly_rent' => ['required', 'numeric', 'min:0'],
            'renewal_reason' => ['required', 'string', 'max:255'],
        ]);

        $renewalData = [
            'start_date' => $this->renewal_start_date,
            'end_date' => $this->renewal_end_date,
            'duration_months' => $this->renewal_duration_months,
            'monthly_rent' => $this->renewal_monthly_rent,
            'renewal_reason' => $this->renewal_reason,
        ];

        try {
            $service->renewContract($contract, $renewalData, Auth::user());
            $this->reset(['renewal_reason']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Contract extended and new PDF version archived successfully!']);
            $this->activeTab = 'preview';
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function uploadAttachment(ContractService $service): void
    {
        $this->validate([
            'attachUpload' => ['required', 'file', 'max:5120', 'mimes:jpg,jpeg,png,pdf,docx,zip'], // Max 5MB
            'attachLabel' => ['required', 'string', 'max:100'],
        ]);

        $contract = Contract::findOrFail($this->contractId);
        $path = $this->attachUpload->store('attachments', 'public');

        $service->addAttachment($contract, $path, $this->attachLabel);

        $this->reset(['attachUpload', 'attachLabel']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Attachment file uploaded successfully.']);
    }

    public function deleteAttachment(int $id, ContractService $service): void
    {
        $attachment = ContractAttachment::findOrFail($id);
        $service->removeAttachment($attachment);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Attachment deleted.']);
    }

    public function render()
    {
        $contract = Contract::with(['boardingHouse', 'room', 'resident', 'versions.creator', 'attachments', 'timeline'])
            ->findOrFail($this->contractId);

        return view('livewire.contract.contract-show', [
            'contract' => $contract,
        ])->layout('layouts.app');
    }
}
