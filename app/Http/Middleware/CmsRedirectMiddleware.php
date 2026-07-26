<?php

namespace App\Http\Middleware;

use App\Models\CmsRedirect;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CmsRedirectMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Get raw request path (e.g. /old-path or old-path)
        $path = '/' . ltrim($request->getPathInfo(), '/');

        // 2. Query matching redirect from DB
        try {
            $redirect = CmsRedirect::where('source_path', $path)
                ->where('is_active', true)
                ->first();

            if ($redirect) {
                return redirect()->to($redirect->target_path, $redirect->status_code);
            }
        } catch (\Exception $e) {
            // Safe fallback if tables are not migrated (e.g. during certain unit tests)
        }

        return $next($request);
    }
}
