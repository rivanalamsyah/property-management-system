<?php

namespace App\Services\SaaS;

use App\Models\Tenant;
use App\Enums\SubscriptionStatus;
use App\Enums\WorkspaceStatus;
use Carbon\Carbon;

class SubscriptionService
{
    public function getTrialRemainingDays(Tenant $tenant): int
    {
        if (!$tenant->trial_ends_at) {
            return 0;
        }

        $now = Carbon::now();
        $ends = Carbon::parse($tenant->trial_ends_at);

        if ($now->greaterThanOrEqualTo($ends)) {
            return 0;
        }

        return (int)$now->diffInDays($ends);
    }

    public function isTrialExpired(Tenant $tenant): bool
    {
        if (!$tenant->trial_ends_at) {
            return true;
        }
        return Carbon::now()->greaterThanOrEqualTo(Carbon::parse($tenant->trial_ends_at));
    }

    public function isGracePeriodActive(Tenant $tenant): bool
    {
        if (!$tenant->grace_period_ends_at) {
            return false;
        }
        return Carbon::now()->lessThanOrEqualTo(Carbon::parse($tenant->grace_period_ends_at));
    }

    public function isSubscriptionActive(Tenant $tenant): bool
    {
        // Active if subscription status is ACTIVE and not expired, or still in trial
        if ($tenant->subscription_status === SubscriptionStatus::ACTIVE) {
            if ($tenant->subscription_ends_at && Carbon::now()->greaterThan(Carbon::parse($tenant->subscription_ends_at))) {
                return $this->isGracePeriodActive($tenant);
            }
            return true;
        }

        if ($tenant->subscription_status === SubscriptionStatus::TRIAL) {
            return !$this->isTrialExpired($tenant) || $this->isGracePeriodActive($tenant);
        }

        return false;
    }

    public function hasFeatureAccess(Tenant $tenant, string $feature): bool
    {
        // Block premium features if subscription is inactive and not in grace period
        if (!$this->isSubscriptionActive($tenant)) {
            return false;
        }

        return $tenant->hasFeature($feature);
    }

    public function checkLimit(Tenant $tenant, string $metric, int $currentCount): bool
    {
        $limit = $tenant->getLimit($metric);
        
        // -1 means unlimited
        if ($limit === -1) {
            return true;
        }

        return $currentCount < $limit;
    }
}
