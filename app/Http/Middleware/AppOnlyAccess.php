<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppOnlyAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $userAgent = $request->header('User-Agent');
        $fromApp = $request->header('X-From-App');

        if (
            (is_string($userAgent) && str_contains($userAgent, 'MyFittellyApp')) || $fromApp === 'true'
        ) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'This feature is only available in the mobile app.',
            ], 403);
        }

        return response()->view('errors.only-in-app');
    }
}
