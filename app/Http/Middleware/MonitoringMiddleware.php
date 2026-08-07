<?php

namespace App\Http\Middleware;

use App\Services\Monitoring\MonitoringService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class MonitoringMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        // Calculate transaction duration in milliseconds
        $durationMs = (int) ((microtime(true) - $startTime) * 1000);

        // Only log web routes, skip assets, livewire messages poll, and health pings
        $url = $request->getRequestUri();
        if ($this->shouldLog($url)) {
            $tenantId = function_exists('tenant') && tenant() ? tenant()->id : null;
            $userId = Auth::id();

            try {
                $service = app(MonitoringService::class);
                $service->logRequest(
                    method: $request->method(),
                    url: $request->getPathInfo(),
                    statusCode: $response->getStatusCode(),
                    durationMs: $durationMs,
                    tenantId: $tenantId,
                    userId: $userId
                );
            } catch (\Exception $e) {}
        }

        return $response;
    }

    /**
     * Exclude assets and health endpoints from db bloat.
     */
    protected function shouldLog(string $url): bool
    {
        $excludes = [
            '/up',
            '/livewire/livewire.js',
            '/livewire/update',
            '/vite',
            '/images/',
            '/favicon.ico',
            '/favicon.png',
        ];

        foreach ($excludes as $ex) {
            if (str_starts_with($url, $ex)) {
                return false;
            }
        }

        return true;
    }
}
