<?php

namespace App\Services;

use App\Enums\AnnouncementStatus;
use App\Models\Announcement;
use App\Models\AnnouncementReadReceipt;
use App\Models\InAppNotification;
use App\Models\Resident;
use Illuminate\Support\Facades\DB;

class AnnouncementService
{
    public function createAnnouncement(array $data): Announcement
    {
        return DB::transaction(function () use ($data) {
            $publishAt = isset($data['publish_at']) ? \Carbon\Carbon::parse($data['publish_at']) : now();
            $data['publish_at'] = $publishAt;

            $status = $data['status'] ?? AnnouncementStatus::PUBLISHED;
            if ($status === AnnouncementStatus::PUBLISHED && $publishAt->isFuture()) {
                $status = AnnouncementStatus::SCHEDULED;
            }
            $data['status'] = $status;

            $announcement = Announcement::create($data);

            if ($announcement->status === AnnouncementStatus::PUBLISHED) {
                $this->sendBroadcastNotifications($announcement);
            }

            activity_log(
                event: 'announcement.create',
                description: "Created announcement: {$announcement->announcement_number}",
                tenantId: $announcement->tenant_id
            );

            return $announcement;
        });
    }

    public function publishScheduledAnnouncements(): void
    {
        DB::transaction(function () {
            $scheduled = Announcement::where('status', AnnouncementStatus::SCHEDULED)
                ->where('publish_at', '<=', now())
                ->get();

            foreach ($scheduled as $announcement) {
                $announcement->update(['status' => AnnouncementStatus::PUBLISHED]);
                $this->sendBroadcastNotifications($announcement);

                activity_log(
                    event: 'announcement.publish_scheduled',
                    description: "Published scheduled announcement: {$announcement->announcement_number}",
                    tenantId: $announcement->tenant_id
                );
            }
        });
    }

    public function sendBroadcastNotifications(Announcement $announcement): void
    {
        DB::transaction(function () use ($announcement) {
            // Find active target residents
            $residentsQuery = Resident::where('tenant_id', $announcement->tenant_id)
                ->whereHas('contracts', function ($q) {
                    $q->where('status', 'active');
                });

            if ($announcement->target_type === 'boarding_house') {
                $residentsQuery->where('boarding_house_id', $announcement->boarding_house_id);
            } elseif ($announcement->target_type === 'floor') {
                $floors = $announcement->target_filters['floors'] ?? [];
                if (!empty($floors)) {
                    $residentsQuery->whereHas('room', function ($q) use ($floors) {
                        $q->whereIn('floor', $floors);
                    });
                }
            } elseif ($announcement->target_type === 'room') {
                $rooms = $announcement->target_filters['rooms'] ?? [];
                if (!empty($rooms)) {
                    $residentsQuery->whereIn('room_id', $rooms);
                }
            } elseif ($announcement->target_type === 'selected_tenants') {
                $residents = $announcement->target_filters['residents'] ?? [];
                if (!empty($residents)) {
                    $residentsQuery->whereIn('id', $residents);
                }
            }

            $targetResidents = $residentsQuery->get();

            foreach ($targetResidents as $res) {
                // 1. Setup read receipts trace
                AnnouncementReadReceipt::updateOrCreate(
                    ['announcement_id' => $announcement->id, 'resident_id' => $res->id],
                    ['delivered_at' => now()]
                );

                // 2. Queue in-app notification record
                InAppNotification::create([
                    'tenant_id' => $announcement->tenant_id,
                    'resident_id' => $res->id,
                    'type' => 'announcement.new',
                    'data' => [
                        'title' => $announcement->title,
                        'announcement_id' => $announcement->id,
                        'summary' => $announcement->summary ?: 'New announcement from office.',
                    ],
                ]);
            }
        });
    }

    public function markAsRead(Announcement $announcement, Resident $resident): void
    {
        AnnouncementReadReceipt::where('announcement_id', $announcement->id)
            ->where('resident_id', $resident->id)
            ->update(['read_at' => now()]);
    }

    public function createStaffInAppNotification(int $userId, string $title, string $message, ?array $meta = []): void
    {
        InAppNotification::create([
            'tenant_id' => tenant()->id,
            'user_id' => $userId,
            'type' => 'staff.notice',
            'data' => array_merge([
                'title' => $title,
                'message' => $message,
            ], $meta),
        ]);
    }
}
