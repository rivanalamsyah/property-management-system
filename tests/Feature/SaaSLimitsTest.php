<?php

namespace Tests\Feature;

use App\Models\Tenant;
use App\Models\SubscriptionPlan;
use App\Services\SaaS\SubscriptionService;
use App\Services\SaaS\UsageTracker;
use App\Enums\SubscriptionStatus;
use App\Enums\WorkspaceStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaaSLimitsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed basic subscription plans
        $this->seed(\Database\Seeders\SaasPlansSeeder::class);
    }

    public function test_workspace_retrieves_limits_and_features_from_plan(): void
    {
        $plan = SubscriptionPlan::where('slug', 'starter')->first();
        
        $tenant = Tenant::create([
            'name' => 'Test Starter Workspace',
            'slug' => 'test-starter',
            'status' => WorkspaceStatus::ACTIVE,
            'subscription_plan_id' => $plan->id,
            'subscription_status' => SubscriptionStatus::ACTIVE,
        ]);

        $this->assertEquals(5, $tenant->getLimit('rooms'));
        $this->assertEquals(5, $tenant->getLimit('tenants'));
        $this->assertFalse($tenant->hasFeature('reports'));
        $this->assertTrue($tenant->hasFeature('announcements'));
    }

    public function test_workspace_custom_overrides_take_precedence(): void
    {
        $plan = SubscriptionPlan::where('slug', 'starter')->first();

        $tenant = Tenant::create([
            'name' => 'Custom Workspace',
            'slug' => 'custom-ws',
            'status' => WorkspaceStatus::ACTIVE,
            'subscription_plan_id' => $plan->id,
            'subscription_status' => SubscriptionStatus::ACTIVE,
            'custom_limits' => ['rooms' => 12],
            'feature_flags' => ['reports' => true],
        ]);

        $this->assertEquals(12, $tenant->getLimit('rooms'));
        $this->assertTrue($tenant->hasFeature('reports'));
    }

    public function test_subscription_service_correctly_calculates_trial_days(): void
    {
        $subService = new SubscriptionService();

        $tenant = Tenant::create([
            'name' => 'Trial Workspace',
            'slug' => 'trial-ws',
            'status' => WorkspaceStatus::TRIAL,
            'subscription_status' => SubscriptionStatus::TRIAL,
            'trial_ends_at' => now()->addDays(10),
        ]);

        $this->assertEquals(9, $subService->getTrialRemainingDays($tenant));
        $this->assertFalse($subService->isTrialExpired($tenant));

        // Travel to future to expire trial
        $tenant->update(['trial_ends_at' => now()->subDay()]);
        $this->assertTrue($subService->isTrialExpired($tenant));
    }
}
