<?php

namespace App\Services;

use App\Enums\ResidentStatus;
use App\Models\Resident;
use App\Models\ResidentDocument;
use App\Models\Room;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResidentService
{
    public function createResident(array $data): Resident
    {
        return DB::transaction(function () use ($data) {
            $data['status'] = ResidentStatus::PENDING;
            $resident = Resident::create($data);

            // Create initial timeline event
            $this->addTimelineEvent(
                resident: $resident,
                event: 'created',
                title: 'Resident Profile Created',
                description: "Resident record for {$resident->name} registered under status: Pending Review.",
                icon: 'user',
                color: 'bg-slate-500'
            );

            activity_log(
                event: 'resident.create',
                description: "Created tenant record: {$resident->name}",
                tenantId: $resident->tenant_id
            );

            return $resident;
        });
    }

    public function updateResident(Resident $resident, array $data): Resident
    {
        return DB::transaction(function () use ($resident, $data) {
            $oldStatus = $resident->status;
            $resident->update($data);

            if (isset($data['status']) && $data['status'] !== $oldStatus->value) {
                $newStatus = ResidentStatus::from($data['status']);
                $this->addTimelineEvent(
                    resident: $resident,
                    event: 'status_change',
                    title: 'Lifecycle Status Shifted',
                    description: "Lifecycle changed from {$oldStatus->label()} to {$newStatus->label()}.",
                    icon: 'refresh',
                    color: 'bg-indigo-500'
                );
            }

            activity_log(
                event: 'resident.update',
                description: "Updated tenant details for: {$resident->name}",
                tenantId: $resident->tenant_id
            );

            return $resident;
        });
    }

    public function deleteResident(Resident $resident): void
    {
        DB::transaction(function () use ($resident) {
            if ($resident->status === ResidentStatus::ACTIVE) {
                throw new \Exception("Active residents cannot be deleted. Checkout the resident first.");
            }

            // Cleanup documents
            foreach ($resident->documents as $doc) {
                Storage::disk('public')->delete($doc->file_path);
            }

            if ($resident->photo) {
                Storage::disk('public')->delete($resident->photo);
            }

            // Release room if reserved
            if ($resident->room_id && $resident->status === ResidentStatus::RESERVED) {
                Room::where('id', $resident->room_id)->update(['status' => 'available']);
            }

            $name = $resident->name;
            $tenantId = $resident->tenant_id;
            $resident->delete();

            activity_log(
                event: 'resident.delete',
                description: "Deleted tenant record: {$name}",
                tenantId: $tenantId
            );
        });
    }

    public function checkIn(Resident $resident, array $data): void
    {
        DB::transaction(function () use ($resident, $data) {
            // Find and validate room availability
            $room = Room::findOrFail($data['room_id']);
            if ($room->status === 'occupied' && $room->id !== $resident->room_id) {
                throw new \Exception("Target room #{$room->room_number} is already occupied by another resident.");
            }

            // Validate Active Contract exists
            $hasActiveContract = \App\Models\Contract::where('resident_id', $resident->id)
                ->where('status', \App\Enums\ContractStatus::ACTIVE)
                ->exists();
            if (!$hasActiveContract) {
                throw new \Exception("A resident cannot check in without an Active Lease Contract.");
            }

            // Validate KTP Document is complete
            $hasKtp = $resident->documents()->where('document_type', 'KTP')->exists();
            if (!$hasKtp) {
                throw new \Exception("KTP identity card scan must be uploaded to the document vault before check-in.");
            }

            // Update Resident Details
            $resident->update([
                'boarding_house_id' => $room->boarding_house_id,
                'room_id' => $room->id,
                'status' => ResidentStatus::ACTIVE,
                'check_in_date' => $data['check_in_date'],
                'move_in_time' => $data['move_in_time'] ?? null,
                'initial_meter_reading' => $data['initial_meter_reading'] ?? null,
                'security_deposit' => $data['security_deposit'] ?? 0.00,
                'check_in_notes' => $data['check_in_notes'] ?? null,
            ]);

            // Shift Room Status to Occupied
            $room->update(['status' => 'occupied']);

            // Timeline logs
            $this->addTimelineEvent(
                resident: $resident,
                event: 'check_in',
                title: 'Resident Checked In',
                description: "Checked into Room #{$room->room_number} ({$room->boardingHouse->name}). Initial meter: " . ($data['initial_meter_reading'] ?? '-') . " kWh.",
                icon: 'check',
                color: 'bg-emerald-500'
            );

            activity_log(
                event: 'resident.check_in',
                description: "Checked in resident {$resident->name} to room #{$room->room_number}",
                tenantId: $resident->tenant_id
            );
        });
    }

    public function checkOut(Resident $resident, array $data): void
    {
        DB::transaction(function () use ($resident, $data) {
            $room = $resident->room;

            // Update Resident Details
            $resident->update([
                'status' => ResidentStatus::FORMER,
                'check_out_date' => $data['check_out_date'],
                'final_meter_reading' => $data['final_meter_reading'] ?? null,
                'check_out_notes' => $data['check_out_notes'] ?? null,
                'damage_notes' => $data['damage_notes'] ?? null,
                'room_id' => null, // Clear active room links
            ]);

            // Release Room back to Available status
            if ($room) {
                $room->update(['status' => 'available']);
            }

            // Timeline logs
            $this->addTimelineEvent(
                resident: $resident,
                event: 'check_out',
                title: 'Resident Checked Out',
                description: "Checked out of room. Final meter: " . ($data['final_meter_reading'] ?? '-') . " kWh. Status changed to Former Tenant.",
                icon: 'logout',
                color: 'bg-rose-500'
            );

            activity_log(
                event: 'resident.check_out',
                description: "Checked out resident {$resident->name}",
                tenantId: $resident->tenant_id
            );
        });
    }

    public function addDocument(Resident $resident, string $type, string $filePath, ?string $label = null): ResidentDocument
    {
        return DB::transaction(function () use ($resident, $type, $filePath, $label) {
            $doc = $resident->documents()->create([
                'document_type' => $type,
                'file_path' => $filePath,
                'label' => $label,
            ]);

            $this->addTimelineEvent(
                resident: $resident,
                event: 'document_uploaded',
                title: "Identity Document Uploaded: {$type}",
                description: "Secure storage path linked for document validation.",
                icon: 'document',
                color: 'bg-indigo-500'
            );

            activity_log(
                event: 'resident.document_upload',
                description: "Uploaded document ({$type}) for {$resident->name}",
                tenantId: $resident->tenant_id
            );

            return $doc;
        });
    }

    public function removeDocument(ResidentDocument $document): void
    {
        DB::transaction(function () use ($document) {
            Storage::disk('public')->delete($document->file_path);
            
            $resident = $document->resident;
            $type = $document->document_type;
            $document->delete();

            $this->addTimelineEvent(
                resident: $resident,
                event: 'document_removed',
                title: "Document Removed: {$type}",
                description: "Secure linkage deleted from document lists.",
                icon: 'trash',
                color: 'bg-slate-400'
            );

            activity_log(
                event: 'resident.document_delete',
                description: "Deleted document ({$type}) for {$resident->name}",
                tenantId: $resident->tenant_id
            );
        });
    }

    public function addTimelineEvent(Resident $resident, string $event, string $title, ?string $description = null, ?string $icon = null, ?string $color = null): void
    {
        $resident->timeline()->create([
            'event' => $event,
            'title' => $title,
            'description' => $description,
            'icon' => $icon ?? 'check',
            'color' => $color ?? 'bg-indigo-500',
        ]);
    }
}
