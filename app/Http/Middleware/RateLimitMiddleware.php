<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RateLimitMiddleware
{
    protected $limiter;

    public function __construct(RateLimiter $limiter)
    {
        $this->limiter = $limiter;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $maxAttempts = '60', string $decayMinutes = '1'): Response
    {
        $key = $this->resolveRequestSignature($request);
        
        // Different limits for different user types
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('admin')) {
                $maxAttempts = 1000; // Higher limit for admins
            } elseif ($user->subscription_status === 'active') {
                $maxAttempts = 300; // Higher limit for subscribers
            } else {
                $maxAttempts = 120; // Regular authenticated users
            }
        } else {
            $maxAttempts = 60; // Lower limit for guests
        }

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = $this->limiter->availableIn($key);
            
            return response()->json([
                'error' => 'Too many requests',
                'message' => 'Rate limit exceeded. Try again in ' . $retryAfter . ' seconds.',
                'retry_after' => $retryAfter
            ], 429)->header('Retry-After', $retryAfter);
        }

        $this->limiter->hit($key, $decayMinutes * 60);

        $response = $next($request);

        // Add rate limit headers
        $response->headers->set('X-RateLimit-Limit', $maxAttempts);
        $response->headers->set('X-RateLimit-Remaining', $maxAttempts - $this->limiter->attempts($key));
        $response->headers->set('X-RateLimit-Reset', $this->limiter->availableIn($key) + time());

        return $response;
    }

    /**
     * Resolve the rate limiting key for the request.
     */
    protected function resolveRequestSignature(Request $request): string
    {
        if (Auth::check()) {
            return 'api_rate_limit:user:' . Auth::id();
        }

        return 'api_rate_limit:ip:' . $request->ip();
    }
}
