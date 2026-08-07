<?php

namespace App\Livewire\Settings;

use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use App\Models\ActivityLog;
use App\Services\SaaS\UsageTracker;
use App\Services\SaaS\SubscriptionService;
use App\Enums\SubscriptionStatus;
use App\Enums\WorkspaceStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BillingPortal extends Component
{
    public string $activeTab = 'overview'; // overview, plan, history, settings

    // Settings fields
    public string $name = '';
    public string $company_name = '';
    public string $brand_name = '';
    public string $timezone = 'Asia/Jakarta';
    public string $currency = 'IDR';
    public string $language = 'id';
    public string $country = 'ID';

    public function mount(): void
    {
        if (!Auth::user()->hasRole('owner') && !Auth::user()->hasRole('super_admin')) {
            abort(403, 'Akses ditolak. Hanya pemilik ruang kerja yang dapat mengelola tagihan.');
        }

        $tenant = tenant();
        if (!$tenant) {
            $this->redirect(route('dashboard'));
            return;
        }

        $this->name = $tenant->name;
        $this->company_name = $tenant->company_name ?? '';
        $this->brand_name = $tenant->brand_name ?? '';
        $this->timezone = $tenant->timezone;
        $this->currency = $tenant->currency;
        $this->language = $tenant->language;
        $this->country = $tenant->country;
    }

    public function saveSettings(): void
    {
        if (!Auth::user()->hasRole('owner') && !Auth::user()->hasRole('super_admin')) {
            abort(403, 'Akses ditolak.');
        }

        $tenant = tenant();
        
        $tenant->update([
            'name' => $this->name,
            'company_name' => $this->company_name,
            'brand_name' => $this->brand_name,
            'timezone' => $this->timezone,
            'currency' => $this->currency,
            'language' => $this->language,
            'country' => $this->country,
        ]);

        activity_log(
            event: 'tenant.update_settings',
            description: "Workspace settings updated: {$tenant->name}",
            userId: Auth::id(),
            tenantId: $tenant->id
        );

        $this->dispatch('toast', ['type' => 'success', 'message' => 'Pengaturan berhasil disimpan!']);
    }

    public function changePlan(string $planId): void
    {
        if (!Auth::user()->hasRole('owner') && !Auth::user()->hasRole('super_admin')) {
            abort(403, 'Akses ditolak.');
        }

        $tenant = tenant();
        $plan = SubscriptionPlan::findOrFail($planId);

        $tenant->update([
            'subscription_plan_id' => $plan->id,
            'subscription_status' => SubscriptionStatus::ACTIVE,
            'subscription_ends_at' => now()->addDays(30),
            'next_billing_at' => now()->addDays(30),
            'grace_period_ends_at' => now()->addDays(37), // 7 days grace
        ]);

        activity_log(
            event: 'tenant.subscription_change',
            description: "Subscribed to plan: {$plan->name}",
            userId: Auth::id(),
            tenantId: $tenant->id
        );

        $this->dispatch('toast', ['type' => 'success', 'message' => "Berhasil meningkatkan ke paket {$plan->name}!"]);
    }

    public function cancelSubscription(): void
    {
        if (!Auth::user()->hasRole('owner') && !Auth::user()->hasRole('super_admin')) {
            abort(403, 'Akses ditolak.');
        }

        $tenant = tenant();
        $tenant->update([
            'subscription_status' => SubscriptionStatus::CANCELLED,
        ]);

        activity_log(
            event: 'tenant.subscription_cancel',
            description: "Cancelled subscription plan",
            userId: Auth::id(),
            tenantId: $tenant->id
        );

        $this->dispatch('toast', ['type' => 'warning', 'message' => "Langganan dibatalkan. Layanan akan tetap aktif hingga akhir siklus tagihan."]);
    }

    public function render()
    {
        $tenant = tenant();
        $usageTracker = app(UsageTracker::class);
        $subService = app(SubscriptionService::class);

        $usage = $usageTracker->getUsage($tenant);
        $plans = SubscriptionPlan::where('is_active', true)->get();

        $trialRemainingDays = $subService->getTrialRemainingDays($tenant);

        // Fetch Audit Logs for this tenant
        $auditLogs = ActivityLog::where('tenant_id', $tenant->id)
            ->latest()
            ->take(20)
            ->get();

        return view('livewire.settings.billing-portal', [
            'tenant' => $tenant,
            'usage' => $usage,
            'plans' => $plans,
            'trialRemainingDays' => $trialRemainingDays,
            'auditLogs' => $auditLogs,
        ]);
    }
}
