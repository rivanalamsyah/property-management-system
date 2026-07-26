<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, Announcement $announcement): bool
    {
        if (!tenant()) {
            return false;
        }

        return $announcement->tenant_id === tenant()->id;
    }

    public function create(User $user): bool
    {
        return tenant() !== null;
    }

    public function update(User $user, Announcement $announcement): bool
    {
        if (!tenant() || $announcement->tenant_id !== tenant()->id) {
            return false;
        }

        return $user->hasPermission('manage-settings') || $user->hasRole('owner');
    }

    public function delete(User $user, Announcement $announcement): bool
    {
        if (!tenant() || $announcement->tenant_id !== tenant()->id) {
            return false;
        }

        return $user->hasRole('owner');
    }
}
