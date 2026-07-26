<?php

namespace App\Services;

use App\Enums\ComplaintStatus;
use App\Models\Complaint;
use App\Models\ComplaintComment;
use App\Models\MaintenanceTask;
use Illuminate\Support\Facades\DB;

class ComplaintService
{
    public function createComplaint(array $data, array $attachments = []): Complaint
    {
        return DB::transaction(function () use ($data, $attachments) {
            $data['status'] = $data['status'] ?? ComplaintStatus::OPEN;
            $complaint = Complaint::create($data);

            foreach ($attachments as $attach) {
                $complaint->attachments()->create($attach);
            }

            $this->addTimelineEvent(
                complaint: $complaint,
                event: 'submitted',
                title: 'Complaint Submitted',
                description: "Resident filed a new issue category: {$complaint->category}",
                icon: 'file',
                color: 'bg-slate-500'
            );

            activity_log(
                event: 'complaint.create',
                description: "Created complaint: {$complaint->complaint_number}",
                tenantId: $complaint->tenant_id
            );

            return $complaint;
        });
    }

    public function updateComplaintStatus(Complaint $complaint, ComplaintStatus $status, ?string $notes = null): void
    {
        DB::transaction(function () use ($complaint, $status, $notes) {
            $oldStatus = $complaint->status;
            $complaint->update(['status' => $status]);

            $eventKey = match ($status) {
                ComplaintStatus::REVIEWED => 'reviewed',
                ComplaintStatus::IN_PROGRESS => 'in_progress',
                ComplaintStatus::COMPLETED => 'completed',
                ComplaintStatus::VERIFIED => 'verified',
                ComplaintStatus::CLOSED => 'closed',
                ComplaintStatus::CANCELLED => 'cancelled',
                default => 'progress_updated'
            };

            $this->addTimelineEvent(
                complaint: $complaint,
                event: $eventKey,
                title: $status->label(),
                description: $notes ?: "Complaint status transitioned from {$oldStatus->label()} to {$status->label()}.",
                icon: 'info',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'complaint.status_update',
                description: "Updated complaint status to: {$status->value}",
                tenantId: $complaint->tenant_id
            );
        });
    }

    public function createMaintenanceTask(Complaint $complaint, array $data): MaintenanceTask
    {
        return DB::transaction(function () use ($complaint, $data) {
            $task = $complaint->maintenanceTask()->create([
                'tenant_id' => $complaint->tenant_id,
                'assigned_staff_id' => $data['assigned_staff_id'] ?? null,
                'assigned_at' => isset($data['assigned_staff_id']) ? now() : null,
                'estimated_completion_date' => $data['estimated_completion_date'] ?? null,
                'cost' => $data['cost'] ?? 0.00,
            ]);

            // Automatically move complaint status to reviewed or assigned
            $status = isset($data['assigned_staff_id']) ? ComplaintStatus::ASSIGNED : ComplaintStatus::REVIEWED;
            $complaint->update(['status' => $status]);

            // Add checklist items if present
            if (isset($data['checklists']) && is_array($data['checklists'])) {
                foreach ($data['checklists'] as $item) {
                    $task->checklists()->create(['item' => $item]);
                }
            }

            $this->addTimelineEvent(
                complaint: $complaint,
                event: 'assigned',
                title: 'Maintenance Task Initiated',
                description: "Case promoted to maintenance task #{$task->task_number}." . (isset($data['assigned_staff_id']) ? " Technician assigned." : ""),
                icon: 'wrench',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'complaint.promote_maintenance',
                description: "Promoted complaint {$complaint->complaint_number} to task {$task->task_number}",
                tenantId: $complaint->tenant_id
            );

            return $task;
        });
    }

    public function assignMaintenanceTask(MaintenanceTask $task, ?int $staffId, ?string $estDate = null): void
    {
        DB::transaction(function () use ($task, $staffId, $estDate) {
            $task->update([
                'assigned_staff_id' => $staffId,
                'assigned_at' => $staffId ? now() : null,
                'estimated_completion_date' => $estDate,
            ]);

            $complaint = $task->complaint;
            $complaint->update(['status' => ComplaintStatus::ASSIGNED]);

            $this->addTimelineEvent(
                complaint: $complaint,
                event: 'assigned',
                title: 'Technician Assigned',
                description: "Work allocated to maintenance staff.",
                icon: 'user',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'maintenance.assign',
                description: "Assigned maintenance task: {$task->task_number}",
                tenantId: $task->tenant_id
            );
        });
    }

    public function updateMaintenanceTaskProgress(MaintenanceTask $task, array $data): void
    {
        DB::transaction(function () use ($task, $data) {
            $task->update([
                'repair_notes' => $data['repair_notes'] ?? $task->repair_notes,
                'replacement_parts' => $data['replacement_parts'] ?? $task->replacement_parts,
                'cost' => $data['cost'] ?? $task->cost,
                'actual_completion_date' => $data['actual_completion_date'] ?? $task->actual_completion_date,
            ]);

            $complaint = $task->complaint;

            $this->addTimelineEvent(
                complaint: $complaint,
                event: 'progress_updated',
                title: 'Maintenance progress updated',
                description: $data['progress_note'] ?? 'Repair notes and specifications adjusted.',
                icon: 'info',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'maintenance.progress_update',
                description: "Updated maintenance task: {$task->task_number}",
                tenantId: $task->tenant_id
            );
        });
    }

    public function addComment(Complaint $complaint, array $data): ComplaintComment
    {
        return DB::transaction(function () use ($complaint, $data) {
            $comment = $complaint->comments()->create([
                'user_id' => $data['user_id'] ?? null,
                'resident_id' => $data['resident_id'] ?? null,
                'comment' => $data['comment'],
                'is_tenant_visible' => $data['is_tenant_visible'] ?? true,
                'attachment_path' => $data['attachment_path'] ?? null,
            ]);

            $this->addTimelineEvent(
                complaint: $complaint,
                event: 'progress_updated',
                title: 'New commentary added',
                description: strLimit($data['comment'], 80),
                icon: 'comment',
                color: 'bg-slate-400'
            );

            activity_log(
                event: 'complaint.comment_add',
                description: "Added comment on complaint: {$complaint->complaint_number}",
                tenantId: $complaint->tenant_id
            );

            return $comment;
        });
    }

    public function addTimelineEvent(Complaint $complaint, string $event, string $title, ?string $description = null, ?string $icon = null, ?string $color = null): void
    {
        $complaint->timeline()->create([
            'event' => $event,
            'title' => $title,
            'description' => $description,
            'icon' => $icon ?? 'check',
            'color' => $color ?? 'bg-indigo-500',
        ]);
    }
}

if (!function_exists('strLimit')) {
    function strLimit(string $value, int $limit = 100, string $end = '...'): string
    {
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')) . $end;
    }
}
