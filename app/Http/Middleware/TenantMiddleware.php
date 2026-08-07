<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    protected TenantManager $tenantManager;

    public function __construct(TenantManager $tenantManager)
    {
        $this->tenantManager = $tenantManager;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $tenant = null;

        // 1. Resolve by host subdomain
        $host = $request->getHost();
        $parts = explode('.', $host);
        
        // e.g. tenant-a.kosan.test or tenant-a.localhost
        // we check if the first part is a valid slug and not a main domain / generic sub
        if (count($parts) > 2) {
            $subdomain = $parts[0];
            if (!in_array($subdomain, ['www', 'admin', 'api', 'localhost'])) {
                $tenant = Tenant::where('slug', $subdomain)->first();
            }
        }

        // 2. Resolve by session fallback (useful for local development or path-based route setup)
        if (!$tenant && $request->hasSession()) {
            $tenantId = $request->session()->get('tenant_id');
            if ($tenantId) {
                $tenant = Tenant::find($tenantId);
            }
        }

        // 3. Resolve by user's first tenant if authenticated
        if (!$tenant && auth()->check()) {
            $user = auth()->user();
            $firstTenant = $user->tenants()->where('is_active', true)->first();
            if ($firstTenant) {
                $tenant = $firstTenant;
                if ($request->hasSession()) {
                    $request->session()->put('tenant_id', $tenant->id);
                }
            }
        }

        // 4. Set Tenant context if resolved
        if ($tenant) {
            if ($request->is('dashboard*') && ($tenant->status === \App\Enums\WorkspaceStatus::SUSPENDED || $tenant->status === \App\Enums\WorkspaceStatus::BLOCKED || $tenant->status === \App\Enums\WorkspaceStatus::ARCHIVED)) {
                abort(403, 'Your workspace is currently suspended or inactive.');
            }
            
            $this->tenantManager->setTenant($tenant);

            // Set Spatie permission team context
            setPermissionsTeamId($tenant->id);

            // Redirect to onboarding if pending
            if ($tenant->status === \App\Enums\WorkspaceStatus::PENDING && !$request->is('onboarding*') && !$request->is('logout') && !$request->is('email/*')) {
                return redirect()->route('onboarding');
            }
        } else {
            // If we are accessing a tenant-required path (e.g. /dashboard) and have no tenant
            if (auth()->check() && $request->is('dashboard*')) {
                // If the user belongs to no tenant, we redirect them to create workspace
                if (auth()->user()->tenants()->count() === 0) {
                    // We will redirect to a workspace creation page, or create one for them.
                    // For safety, let's allow them to access workspace creation route without workspace restriction
                    if (!$request->is('dashboard/workspaces/create')) {
                        return redirect()->route('workspace.create');
                    }
                }
            }
        }

        return $next($request);
    }
}
