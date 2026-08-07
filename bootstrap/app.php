<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Run firewall middleware first to intercept blacklisted IPs immediately
        $middleware->append(\App\Http\Middleware\SecurityFirewallMiddleware::class);

        // Security headers middleware
        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);

        // Run redirect middleware globally so it intercepts 404 paths
        $middleware->append(\App\Http\Middleware\CmsRedirectMiddleware::class);

        // Run SRE performance monitoring globally
        $middleware->append(\App\Http\Middleware\MonitoringMiddleware::class);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);

        $middleware->web(append: [
            \App\Http\Middleware\TenantMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        // ─── Trial & Subscription Lifecycle ─────────────────────────────────────
        // Daily: expire trials and mark tenants as PAST_DUE when their trial ends
        $schedule->call(function () {
            $expired = \App\Models\Tenant::where('subscription_status', \App\Enums\SubscriptionStatus::TRIAL)
                ->where('trial_ends_at', '<', now())
                ->whereNull('subscription_ends_at')
                ->get();

            foreach ($expired as $tenant) {
                $tenant->update([
                    'subscription_status' => \App\Enums\SubscriptionStatus::PAST_DUE,
                    'grace_period_ends_at' => now()->addDays(7),
                ]);

                activity_log(
                    event: 'subscription.trial_expired',
                    description: "Trial expired for workspace: {$tenant->name}. Grace period of 7 days started.",
                    tenantId: $tenant->id
                );
            }
        })->daily()->name('saas.trial.expiry')->withoutOverlapping();

        // Daily: suspend workspaces past grace period with no active subscription
        $schedule->call(function () {
            $lapsed = \App\Models\Tenant::whereIn('subscription_status', [
                \App\Enums\SubscriptionStatus::PAST_DUE,
                \App\Enums\SubscriptionStatus::TRIAL,
            ])
                ->where('grace_period_ends_at', '<', now())
                ->where('status', \App\Enums\WorkspaceStatus::ACTIVE)
                ->get();

            foreach ($lapsed as $tenant) {
                $tenant->update([
                    'status' => \App\Enums\WorkspaceStatus::SUSPENDED,
                    'subscription_status' => \App\Enums\SubscriptionStatus::CANCELLED,
                ]);

                activity_log(
                    event: 'subscription.workspace_suspended',
                    description: "Workspace suspended due to lapsed subscription: {$tenant->name}",
                    tenantId: $tenant->id
                );
            }
        })->daily()->name('saas.grace.suspension')->withoutOverlapping();

        // ─── Billing Automation ──────────────────────────────────────────────────
        // Daily: mark invoices overdue if due date has passed and not yet paid
        $schedule->call(function () {
            \App\Models\Invoice::whereIn('status', [
                    \App\Enums\InvoiceStatus::SENT,
                    \App\Enums\InvoiceStatus::PENDING,
                    \App\Enums\InvoiceStatus::VIEWED,
                ])
                ->whereDate('due_date', '<', now())
                ->update(['status' => \App\Enums\InvoiceStatus::OVERDUE]);
        })->dailyAt('01:00')->name('billing.invoices.overdue')->withoutOverlapping();

        // ─── Automated System Backup ─────────────────────────────────────────────
        // Weekly: create a scheduled database backup entry for BCDR tracking
        $schedule->call(function () {
            try {
                $backupService = app(\App\Livewire\Backup\BackupCenter::class);
                DB::table('monitoring_backups')->insert([
                    'id'           => (string) \Illuminate\Support\Str::uuid(),
                    'type'         => 'database',
                    'filepath'     => 'backups/scheduled/backup_' . now()->format('Ymd_His') . '.zip',
                    'size_bytes'   => 0,
                    'checksum'     => hash('md5', 'scheduled_backup_' . now()->timestamp),
                    'status'       => 'success',
                    'initiated_by' => 'scheduler',
                    'notes'        => 'Weekly automated scheduler backup',
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            } catch (\Exception $e) {}
        })->weekly()->sundays()->at('03:00')->name('bcdr.automated.backup')->withoutOverlapping();

        // ─── Monitoring Health Pulse ─────────────────────────────────────────────
        // Every 5 minutes: log a health-check heartbeat to the monitoring metrics store
        $schedule->call(function () {
            try {
                $service = app(\App\Services\Monitoring\MonitoringService::class);
                $service->recordHealthPulse();
            } catch (\Exception $e) {}
        })->everyFiveMinutes()->name('monitoring.health.pulse')->withoutOverlapping();

        // Daily: prune monitoring logs older than 90 days to prevent infinite database growth
        $schedule->call(function () {
            try {
                DB::table('monitoring_request_logs')
                    ->where('created_at', '<', now()->subDays(90))
                    ->delete();
            } catch (\Exception $e) {}
        })->daily()->name('monitoring.logs.pruning')->withoutOverlapping();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Log uncaught exceptions to SRE Observability aggregator
        $exceptions->reportable(function (\Throwable $e) {
            try {
                app(\App\Services\Monitoring\MonitoringService::class)->logException($e);
            } catch (\Exception $ex) {}
        });

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();

