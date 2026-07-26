<?php

namespace App\Services;

use App\Enums\ContractStatus;
use App\Enums\ContractType;
use App\Models\Contract;
use App\Models\ContractAttachment;
use App\Models\Room;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContractService
{
    public function createContract(array $data): Contract
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = ContractStatus::DRAFT;
            $contract = Contract::create($data);

            $this->addTimelineEvent(
                contract: $contract,
                event: 'created',
                title: 'Contract Draft Created',
                description: "Lease contract drafted under number: {$contract->contract_number}",
                icon: 'file',
                color: 'bg-slate-500'
            );

            activity_log(
                event: 'contract.create',
                description: "Created contract draft: {$contract->contract_number}",
                tenantId: $contract->tenant_id
            );

            return $contract;
        });
    }

    public function updateContract(Contract $contract, array $data): Contract
    {
        return DB::transaction(function () use ($contract, $data) {
            $contract->update($data);

            activity_log(
                event: 'contract.update',
                description: "Updated contract specifications: {$contract->contract_number}",
                tenantId: $contract->tenant_id
            );

            return $contract;
        });
    }

    public function deleteContract(Contract $contract): void
    {
        DB::transaction(function () use ($contract) {
            if (!in_array($contract->status->value, ['draft', 'cancelled'])) {
                throw new \Exception("Only draft or cancelled contracts can be deleted.");
            }

            // Cleanup attachments
            foreach ($contract->attachments as $attach) {
                Storage::disk('public')->delete($attach->file_path);
            }

            if ($contract->signed_pdf_path) {
                Storage::disk('public')->delete($contract->signed_pdf_path);
            }

            $number = $contract->contract_number;
            $tenantId = $contract->tenant_id;
            $contract->delete();

            activity_log(
                event: 'contract.delete',
                description: "Deleted contract: {$number}",
                tenantId: $tenantId
            );
        });
    }

    public function activateContract(Contract $contract): void
    {
        DB::transaction(function () use ($contract) {
            // Generate professional PDF Agreement
            $pdf = Pdf::loadView('pdf.contract-pdf', ['contract' => $contract]);
            $filePath = 'contracts/' . $contract->contract_number . '-v' . $contract->version . '.pdf';
            Storage::disk('public')->put($filePath, $pdf->output());

            $contract->update([
                'status' => ContractStatus::ACTIVE,
                'signed_pdf_path' => $filePath,
            ]);

            $this->addTimelineEvent(
                contract: $contract,
                event: 'activated',
                title: 'Contract Activated',
                description: "Lease contract verified, signed PDF generated, and marked active.",
                icon: 'check',
                color: 'bg-emerald-500'
            );

            activity_log(
                event: 'contract.activate',
                description: "Activated lease agreement: {$contract->contract_number}",
                tenantId: $contract->tenant_id
            );
        });
    }

    public function renewContract(Contract $contract, array $data, User $user): Contract
    {
        return DB::transaction(function () use ($contract, $data, $user) {
            // Save previous values history before modifying main record
            $previousValues = [
                'start_date' => $contract->start_date->format('Y-m-d'),
                'end_date' => $contract->end_date->format('Y-m-d'),
                'duration_months' => $contract->duration_months,
                'monthly_rent' => $contract->monthly_rent,
                'signed_pdf_path' => $contract->signed_pdf_path,
                'status' => $contract->status->value,
            ];

            $contract->versions()->create([
                'version_number' => $contract->version,
                'created_by' => $user->id,
                'reason' => $data['renewal_reason'] ?? 'Standard Contract Renewal Extension.',
                'previous_values' => $previousValues,
            ]);

            // Update parameters
            $contract->increment('version');
            $contract->update([
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'duration_months' => $data['duration_months'],
                'monthly_rent' => $data['monthly_rent'],
                'status' => ContractStatus::ACTIVE,
            ]);

            // Regenerate PDF Agreement for the new version
            $pdf = Pdf::loadView('pdf.contract-pdf', ['contract' => $contract]);
            $filePath = 'contracts/' . $contract->contract_number . '-v' . $contract->version . '.pdf';
            Storage::disk('public')->put($filePath, $pdf->output());

            $contract->update(['signed_pdf_path' => $filePath]);

            $this->addTimelineEvent(
                contract: $contract,
                event: 'renewed',
                title: "Contract Renewed (v{$contract->version})",
                description: "Lease agreement renewed. Monthly rent price adjusted to Rp" . number_format($data['monthly_rent'], 0, ',', '.') . "/month.",
                icon: 'refresh',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'contract.renew',
                description: "Renewed lease agreement to v{$contract->version}: {$contract->contract_number}",
                tenantId: $contract->tenant_id
            );

            return $contract;
        });
    }

    public function addAttachment(Contract $contract, string $filePath, ?string $label = null): ContractAttachment
    {
        return DB::transaction(function () use ($contract, $filePath, $label) {
            $attach = $contract->attachments()->create([
                'file_path' => $filePath,
                'label' => $label,
            ]);

            $this->addTimelineEvent(
                contract: $contract,
                event: 'attachment',
                title: 'Supporting File Uploaded',
                description: "Uploaded document attachments: " . ($label ?: 'Unlabelled attachment file'),
                icon: 'document',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'contract.attachment_upload',
                description: "Uploaded attachment for contract: {$contract->contract_number}",
                tenantId: $contract->tenant_id
            );

            return $attach;
        });
    }

    public function removeAttachment(ContractAttachment $attachment): void
    {
        DB::transaction(function () use ($attachment) {
            Storage::disk('public')->delete($attachment->file_path);
            
            $contract = $attachment->contract;
            $label = $attachment->label;
            $attachment->delete();

            $this->addTimelineEvent(
                contract: $contract,
                event: 'attachment_removed',
                title: 'Attachment Deleted',
                description: "Deleted document attachments: " . ($label ?: 'Unlabelled attachment file'),
                icon: 'trash',
                color: 'bg-slate-400'
            );

            activity_log(
                event: 'contract.attachment_delete',
                description: "Deleted attachment for contract: {$contract->contract_number}",
                tenantId: $contract->tenant_id
            );
        });
    }

    public function addTimelineEvent(Contract $contract, string $event, string $title, ?string $description = null, ?string $icon = null, ?string $color = null): void
    {
        $contract->timeline()->create([
            'event' => $event,
            'title' => $title,
            'description' => $description,
            'icon' => $icon ?? 'check',
            'color' => $color ?? 'bg-indigo-500',
        ]);
    }
}
