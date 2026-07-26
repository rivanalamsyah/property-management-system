<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class SecurityFirewallMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();

        try {
            // Check block list in firewall settings
            $blocked = DB::table('security_ip_rules')
                ->where('ip_address', $ip)
                ->where('type', 'block')
                ->first();

            if ($blocked) {
                // Record firewall trigger incident in DB
                DB::table('security_incidents')->insert([
                    'id' => (string) \Illuminate\Support\Str::uuid(),
                    'event_type' => 'blocked_ip',
                    'description' => "Blocked request from banned IP: {$ip}",
                    'ip_address' => $ip,
                    'severity' => 'medium',
                    'status' => 'open',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                abort(403, 'Forbidden. Your IP address is blocked by the system administrator.');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            // Safe fallback if database is not migrated yet
        }

        return $next($request);
    }
}
