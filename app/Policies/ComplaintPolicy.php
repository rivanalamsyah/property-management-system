<?php

namespace App\Policies;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplaintPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, Complaint $complaint): bool
    {
        if (!tenant() || $complaint->tenant_id !== tenant()->id) {
            return false;
        }

        if ($user->hasRole('tenant')) {
            $res = $user->resident();
            return $res && $complaint->resident_id === $res->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        return tenant() !== null;
    }

    public function update(User $user, Complaint $complaint): bool
    {
        if (!tenant() || $complaint->tenant_id !== tenant()->id) {
            return false;
        }

        return $user->hasPermission('manage-complaints');
    }

    public function delete(User $user, Complaint $complaint): bool
    {
        if (!tenant() || $complaint->tenant_id !== tenant()->id) {
            return false;
        }

        // Only allow owner to delete complaints
        return $user->hasRole('owner');
    }
}
