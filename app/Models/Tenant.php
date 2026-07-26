<?php

namespace App\Models;

use App\Enums\SubscriptionStatus;
use App\Enums\WorkspaceStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tenant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'slug',
        'status',
        'settings',
        'company_name',
        'brand_name',
        'logo',
        'timezone',
        'currency',
        'language',
        'country',
        'subscription_plan_id',
        'subscription_status',
        'trial_ends_at',
        'subscription_ends_at',
        'next_billing_at',
        'trial_reminder_sent_at',
        'grace_period_ends_at',
        'feature_flags',
        'custom_limits',
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => WorkspaceStatus::class,
        'subscription_status' => SubscriptionStatus::class,
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'next_billing_at' => 'datetime',
        'trial_reminder_sent_at' => 'datetime',
        'grace_period_ends_at' => 'datetime',
        'feature_flags' => 'array',
        'custom_limits' => 'array',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user')
            ->withPivot('role_id', 'is_active', 'joined_at')
            ->withTimestamps();
    }

    public function subscriptionPlan(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    /**
     * Check if a feature is enabled for the workspace.
     */
    public function hasFeature(string $feature): bool
    {
        // 1. Check custom override flags on tenant level
        if (isset($this->feature_flags[$feature])) {
            return (bool) $this->feature_flags[$feature];
        }

        // 2. Fallback to plan limits
        $plan = $this->subscriptionPlan;
        if (!$plan) {
            return false;
        }

        return match ($feature) {
            'reports' => $plan->has_reports,
            'analytics' => $plan->has_analytics,
            'resident_portal' => $plan->has_resident_portal,
            'maintenance' => $plan->has_maintenance,
            'announcements' => $plan->has_announcements,
            default => isset($plan->feature_flags[$feature]) ? (bool)$plan->feature_flags[$feature] : false,
        };
    }

    /**
     * Get the limit for a particular metric.
     */
    public function getLimit(string $metric): int
    {
        // 1. Custom override on tenant level
        if (isset($this->custom_limits[$metric])) {
            return (int)$this->custom_limits[$metric];
        }

        // 2. Plan limits
        $plan = $this->subscriptionPlan;
        if (!$plan) {
            return 0;
        }

        return match ($metric) {
            'rooms' => $plan->max_rooms,
            'tenants' => $plan->max_tenants,
            'staff' => $plan->max_staff,
            'branches' => $plan->max_branches,
            'storage' => $plan->storage_limit_mb,
            'upload' => $plan->max_upload_size_mb,
            default => 0,
        };
    }
}
