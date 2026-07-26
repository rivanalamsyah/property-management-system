<?php

namespace App\Policies;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResidentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, Resident $resident): bool
    {
        if (!tenant() || $resident->tenant_id !== tenant()->id) {
            return false;
        }

        if ($user->hasRole('tenant')) {
            $res = $user->resident();
            return $res && $res->id === $resident->id;
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

    public function update(User $user, Resident $resident): bool
    {
        if (!tenant() || $resident->tenant_id !== tenant()->id) {
            return false;
        }

        return $user->hasPermission('manage-rooms');
    }

    public function delete(User $user, Resident $resident): bool
    {
        if (!tenant() || $resident->tenant_id !== tenant()->id) {
            return false;
        }

        // Bypassed if active or occupied
        if ($resident->status->value === 'active') {
            return false;
        }

        return $user->hasRole('owner');
    }
}
