<?php

namespace App\Livewire\Complaint;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\MaintenanceChecklist;
use App\Models\MaintenanceTask;
use App\Models\User;
use App\Services\ComplaintService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ComplaintShow extends Component
{
    use WithFileUploads;

    public string $complaintId;

    // Comments fields
    public string $newComment = '';
    public bool $isCommentPublic = true;
    public $commentAttachment = null;

    // Maintenance Task creation fields
    public bool $showPromoteModal = false;
    public ?string $assignedStaffId = null;
    public ?string $estimatedCompletionDate = null;
    public float $cost = 0.00;
    public string $checklistItemsRaw = '';

    // Maintenance Progress update fields
    public string $repairNotes = '';
    public string $replacementParts = '';
    public float $actualCost = 0.00;
    public bool $isCompletedWork = false;

    // Single Checklist additions
    public string $newChecklistItem = '';

    public function mount(string $id): void
    {
        $this->complaintId = $id;
        $complaint = Complaint::findOrFail($id);

        if (Auth::user()->cannot('view', $complaint)) {
            abort(403, 'Unauthorized.');
        }

        if ($complaint->maintenanceTask) {
            $task = $complaint->maintenanceTask;
            $this->repairNotes = $task->repair_notes ?? '';
            $this->replacementParts = $task->replacement_parts ?? '';
            $this->actualCost = (float) $task->cost;
            $this->assignedStaffId = $task->assigned_staff_id;
            $this->estimatedCompletionDate = $task->estimated_completion_date ? $task->estimated_completion_date->format('Y-m-d') : null;
        }
    }

    public function changeStatus(ComplaintService $service, string $status): void
    {
        $complaint = Complaint::findOrFail($this->complaintId);

        if (Auth::user()->cannot('update', $complaint)) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $enumStatus = ComplaintStatus::from($status);
            $service->updateComplaintStatus($complaint, $enumStatus);
            $this->dispatch('toast', ['type' => 'success', 'message' => "Complaint status updated to: {$enumStatus->label()}"]);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function postComment(ComplaintService $service): void
    {
        $complaint = Complaint::findOrFail($this->complaintId);

        if (Auth::user()->cannot('view', $complaint)) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'newComment' => ['required', 'string', 'max:500'],
            'commentAttachment' => ['nullable', 'file', 'max:4096'],
        ]);

        try {
            $attachmentPath = null;
            if ($this->commentAttachment) {
                $attachmentPath = $this->commentAttachment->store('comments', 'public');
            }

            $service->addComment($complaint, [
                'user_id' => Auth::id(),
                'comment' => $this->newComment,
                'is_tenant_visible' => $this->isCommentPublic,
                'attachment_path' => $attachmentPath,
            ]);

            $this->reset(['newComment', 'commentAttachment']);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Comment posted successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function promoteToMaintenance(ComplaintService $service): void
    {
        $complaint = Complaint::findOrFail($this->complaintId);

        if (Auth::user()->cannot('update', $complaint)) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'assignedStaffId' => ['nullable', 'exists:users,id'],
            'estimatedCompletionDate' => ['nullable', 'date'],
            'cost' => ['required', 'numeric', 'min:0'],
            'checklistItemsRaw' => ['nullable', 'string'],
        ]);

        try {
            $checklists = [];
            if ($this->checklistItemsRaw) {
                $checklists = array_filter(
                    array_map('trim', explode("\n", $this->checklistItemsRaw))
                );
            }

            $service->createMaintenanceTask($complaint, [
                'assigned_staff_id' => $this->assignedStaffId,
                'estimated_completion_date' => $this->estimatedCompletionDate,
                'cost' => $this->cost,
                'checklists' => $checklists,
            ]);

            $this->showPromoteModal = false;
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Complaint promoted to maintenance task successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function toggleChecklistItem(int $id): void
    {
        $item = MaintenanceChecklist::findOrFail($id);
        $item->update(['is_completed' => !$item->is_completed]);

        // Recalculate if all checklists completed, but keeping progress updates manual for the technician.
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Checklist progress tracked.']);
    }

    public function addChecklistItem(): void
    {
        $complaint = Complaint::findOrFail($this->complaintId);
        if (!$complaint->maintenanceTask) {
            return;
        }

        $this->validate([
            'newChecklistItem' => ['required', 'string', 'max:150'],
        ]);

        $complaint->maintenanceTask->checklists()->create([
            'item' => $this->newChecklistItem,
            'is_completed' => false,
        ]);

        $this->reset(['newChecklistItem']);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Checklist item appended.']);
    }

    public function deleteChecklistItem(int $id): void
    {
        $item = MaintenanceChecklist::findOrFail($id);
        $item->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Checklist item removed.']);
    }

    public function saveProgress(ComplaintService $service): void
    {
        $complaint = Complaint::findOrFail($this->complaintId);
        $task = $complaint->maintenanceTask;

        if (!$task) {
            return;
        }

        if (Auth::user()->cannot('update', $complaint)) {
            abort(403, 'Unauthorized.');
        }

        $this->validate([
            'repairNotes' => ['nullable', 'string', 'max:1000'],
            'replacementParts' => ['nullable', 'string', 'max:500'],
            'actualCost' => ['required', 'numeric', 'min:0'],
        ]);

        try {
            $params = [
                'repair_notes' => $this->repairNotes,
                'replacement_parts' => $this->replacementParts,
                'cost' => $this->actualCost,
            ];

            if ($this->isCompletedWork) {
                $params['actual_completion_date'] = now()->format('Y-m-d');
                $service->updateMaintenanceTaskProgress($task, $params);
                $service->updateComplaintStatus($complaint, ComplaintStatus::COMPLETED, 'Repair work finalized and checklist finished.');
                $this->isCompletedWork = false; // Reset toggle
            } else {
                $service->updateMaintenanceTaskProgress($task, $params);
            }

            $this->dispatch('toast', ['type' => 'success', 'message' => 'Maintenance parameters updated successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $complaint = Complaint::with([
            'boardingHouse', 'room', 'resident', 'attachments', 
            'comments.user', 'comments.resident', 'timeline', 
            'maintenanceTask.checklists', 'maintenanceTask.assignedStaff'
        ])->findOrFail($this->complaintId);

        $staffUsers = User::where('role', 'staff')
            ->orWhere('role', 'owner')
            ->get();

        return view('livewire.complaint.complaint-show', [
            'complaint' => $complaint,
            'staffUsers' => $staffUsers,
        ])->layout('layouts.app');
    }
}
