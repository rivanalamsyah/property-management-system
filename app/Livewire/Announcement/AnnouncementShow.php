<?php

namespace App\Livewire\Announcement;

use App\Enums\AnnouncementStatus;
use App\Models\Announcement;
use App\Models\AnnouncementReadReceipt;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnnouncementShow extends Component
{
    public string $announcementId;
    public string $searchRecipient = '';

    public function mount(string $id): void
    {
        $this->announcementId = $id;
        $ann = Announcement::findOrFail($id);

        if (Auth::user()->cannot('view', $ann)) {
            abort(403, 'Unauthorized.');
        }
    }

    public function updateStatus(string $status): void
    {
        $ann = Announcement::findOrFail($this->announcementId);

        if (Auth::user()->cannot('update', $ann)) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $enumStatus = AnnouncementStatus::from($status);
            $ann->update(['status' => $enumStatus]);

            activity_log(
                event: 'announcement.status_change',
                description: "Changed announcement status to: {$enumStatus->value}",
                tenantId: $ann->tenant_id
            );

            $this->dispatch('toast', ['type' => 'success', 'message' => "Announcement status changed to: {$enumStatus->label()}"]);
        } catch (\Exception $e) {
            $this->dispatch('toast', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function render()
    {
        $announcement = Announcement::with(['boardingHouse', 'author', 'readReceipts.resident.room'])
            ->findOrFail($this->announcementId);

        // Fetch recipients with name search filter
        $recipientsQuery = AnnouncementReadReceipt::with(['resident.room'])
            ->where('announcement_id', $this->announcementId)
            ->when($this->searchRecipient, function ($q) {
                $q->whereHas('resident', function ($sq) {
                    $sq->where('name', 'like', '%' . $this->searchRecipient . '%');
                });
            });

        $recipients = $recipientsQuery->get();

        $totalRecipients = $recipients->count();
        $readCount = $recipients->whereNotNull('read_at')->count();
        $unreadCount = $totalRecipients - $readCount;

        $engagementRate = $totalRecipients > 0 ? round(($readCount / $totalRecipients) * 100, 1) : 0;

        return view('livewire.announcement.announcement-show', [
            'announcement' => $announcement,
            'recipients' => $recipients,
            'totalRecipients' => $totalRecipients,
            'readCount' => $readCount,
            'unreadCount' => $unreadCount,
            'engagementRate' => $engagementRate,
        ])->layout('layouts.app');
    }
}
