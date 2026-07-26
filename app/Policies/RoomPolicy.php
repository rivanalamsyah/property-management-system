<?php

namespace App\Policies;

use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, Room $room): bool
    {
        if (!tenant() || !$room->boardingHouse || $room->boardingHouse->tenant_id !== tenant()->id) {
            return false;
        }

        if ($user->hasRole('tenant')) {
            $res = $user->resident();
            return $res && $res->room_id === $room->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        if (!tenant()) {
            return false;
        }

        return $user->hasPermission('manage-rooms');
    }

    public function update(User $user, Room $room): bool
    {
        if (!tenant() || !$room->boardingHouse || $room->boardingHouse->tenant_id !== tenant()->id) {
            return false;
        }

        return $user->hasPermission('manage-rooms');
    }

    public function delete(User $user, Room $room): bool
    {
        if (!tenant() || !$room->boardingHouse || $room->boardingHouse->tenant_id !== tenant()->id) {
            return false;
        }

        // Only owners or staff with settings access can delete rooms
        if ($room->status === 'occupied') {
            return false; // prevent deleting occupied rooms
        }

        return $user->hasRole('owner') || $user->hasPermission('manage-rooms');
    }
}
