<?php

namespace App\Policies;

use App\Models\BoardingHouse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardingHousePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, BoardingHouse $boardingHouse): bool
    {
        if (!tenant()) {
            return false;
        }

        return $boardingHouse->tenant_id === tenant()->id;
    }

    public function create(User $user): bool
    {
        if (!tenant()) {
            return false;
        }

        return $user->hasPermission('manage-settings');
    }

    public function update(User $user, BoardingHouse $boardingHouse): bool
    {
        if (!tenant() || $boardingHouse->tenant_id !== tenant()->id) {
            return false;
        }

        return $user->hasPermission('manage-settings');
    }

    public function delete(User $user, BoardingHouse $boardingHouse): bool
    {
        if (!tenant() || $boardingHouse->tenant_id !== tenant()->id) {
            return false;
        }

        // Only owners can delete entire boarding houses
        return $user->hasRole('owner');
    }
}
