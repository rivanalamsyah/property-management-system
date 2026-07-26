<?php

namespace App\Livewire\Notification;

use App\Models\InAppNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationCenter extends Component
{
    public function markAsRead(string $id): void
    {
        $notif = InAppNotification::findOrFail($id);

        if ($notif->user_id !== Auth::id()) {
            return;
        }

        $notif->update(['read_at' => now()]);
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Notification marked as read.']);
    }

    public function markAllAsRead(): void
    {
        InAppNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->dispatch('toast', ['type' => 'success', 'message' => 'All notifications marked as read.']);
    }

    public function render()
    {
        $notifications = InAppNotification::where('user_id', Auth::id())
            ->latest()
            ->take(15)
            ->get();

        $unreadCount = InAppNotification::where('user_id', Auth::id())
            ->whereNull('read_at')
            ->count();

        return view('livewire.notification.notification-center', [
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
        ]);
    }
}
