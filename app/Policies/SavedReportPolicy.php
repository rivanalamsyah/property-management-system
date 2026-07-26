<?php

namespace App\Policies;

use App\Models\SavedReport;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SavedReportPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return tenant() !== null;
    }

    public function view(User $user, SavedReport $report): bool
    {
        if (!tenant()) {
            return false;
        }

        return $report->tenant_id === tenant()->id;
    }

    public function create(User $user): bool
    {
        return tenant() !== null;
    }

    public function update(User $user, SavedReport $report): bool
    {
        if (!tenant() || $report->tenant_id !== tenant()->id) {
            return false;
        }

        return $report->user_id === $user->id || $user->hasRole('owner');
    }

    public function delete(User $user, SavedReport $report): bool
    {
        if (!tenant() || $report->tenant_id !== tenant()->id) {
            return false;
        }

        return $report->user_id === $user->id || $user->hasRole('owner');
    }
}
