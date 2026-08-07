<?php

namespace App\Providers;

use App\Services\TenantManager;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TenantManager::class, function () {
            return new TenantManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Global Gate hook to check permissions dynamically per active tenant
        Gate::before(function ($user, $ability) {
            if ($user->email === 'admin@kosan.test' || $user->email === 'superadmin@example.test') {
                return true;
            }
            if (method_exists($user, 'hasPermission') && $user->hasPermission($ability)) {
                return true;
            }
        });
    }
}
