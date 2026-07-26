<?php

namespace App\Services\Monitoring;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Throwable;

class MonitoringService
{
    /**
     * Log an HTTP request performance metrics.
     */
    public function logRequest(
        string $method,
        string $url,
        int $statusCode,
        int $durationMs,
        ?string $tenantId = null,
        ?int $userId = null
    ): void {
        try {
            DB::table('monitoring_request_logs')->insert([
                'tenant_id' => $tenantId,
                'user_id' => $userId,
                'method' => $method,
                'url' => $url,
                'status_code' => $statusCode,
                'duration_ms' => $durationMs,
                'ip_address' => request()->ip(),
                'created_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Silently fail to not crash application requests
        }
    }

    /**
     * Group and log duplicate uncaught application throwables.
     */
    public function logException(Throwable $e, ?string $url = null): void
    {
        try {
            $class = get_class($e);
            $message = $e->getMessage();
            $stackTrace = $e->getTraceAsString();

            $existing = DB::table('monitoring_exceptions')
                ->where('exception_class', $class)
                ->where('message', $message)
                ->first();

            if ($existing) {
                DB::table('monitoring_exceptions')
                    ->where('id', $existing->id)
                    ->update([
                        'occurrences_count' => $existing->occurrences_count + 1,
                        'last_occurred_at' => now(),
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('monitoring_exceptions')->insert([
                    'id' => (string) Str::uuid(),
                    'exception_class' => $class,
                    'message' => $message,
                    'stack_trace' => substr($stackTrace, 0, 5000),
                    'url' => $url ?? request()->fullUrl(),
                    'occurrences_count' => 1,
                    'last_occurred_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } catch (\Exception $ex) {
            // Silently fail to not cause infinite crash loops
        }
    }

    /**
     * Calculate average response time, P95, and P99 percentiles.
     */
    public function getPerformanceMetrics(): array
    {
        try {
            $durations = DB::table('monitoring_request_logs')->pluck('duration_ms')->toArray();
            if (empty($durations)) {
                return ['avg' => 0, 'p95' => 0, 'p99' => 0];
            }

            sort($durations);
            $count = count($durations);

            $avg = array_sum($durations) / $count;

            $idx95 = max(0, (int)($count * 0.95) - 1);
            $p95 = $durations[$idx95];

            $idx99 = max(0, (int)($count * 0.99) - 1);
            $p99 = $durations[$idx99];

            return [
                'avg' => round($avg, 1),
                'p95' => $p95,
                'p99' => $p99,
            ];
        } catch (\Exception $e) {
            return ['avg' => 0, 'p95' => 0, 'p99' => 0];
        }
    }

    /**
     * Gathers server memory and size metrics.
     */
    public function getSystemHealth(): array
    {
        $dbSize = '0.00 MB';
        try {
            $dbName = DB::connection()->getDatabaseName();
            if (config('database.default') === 'sqlite') {
                if (file_exists($dbName)) {
                    $dbSize = round(filesize($dbName) / 1024 / 1024, 2) . ' MB';
                }
            } else {
                $query = "SELECT SUM(data_length + index_length) / 1024 / 1024 AS size FROM information_schema.TABLES WHERE table_schema = ?";
                $result = DB::select($query, [$dbName]);
                if (!empty($result) && isset($result[0]->size)) {
                    $dbSize = round($result[0]->size, 2) . ' MB';
                }
            }
        } catch (\Exception $e) {}

        return [
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB',
            'database_size' => $dbSize,
            'cpu_usage' => mt_rand(5, 18) . '%', // CPU preparation mock
        ];
    }

    /**
     * Record a scheduled health-check heartbeat into the request log.
     * Called every 5 minutes by the Laravel Scheduler.
     */
    public function recordHealthPulse(): void
    {
        try {
            DB::table('monitoring_request_logs')->insert([
                'tenant_id'   => null,
                'user_id'     => null,
                'method'      => 'SCHEDULER',
                'url'         => '/health-pulse',
                'status_code' => 200,
                'duration_ms' => 0,
                'ip_address'  => '127.0.0.1',
                'created_at'  => now(),
            ]);
        } catch (\Exception $e) {
            // Silently fail — never crash the scheduler for a heartbeat
        }
    }
}
