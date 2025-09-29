<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentNegotiationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Determine if this should be treated as an API request
        $isApiRequest = $this->shouldReturnJson($request);
        
        // Set a flag on the request to indicate API vs Web
        $request->attributes->set('is_api_request', $isApiRequest);
        
        // Set appropriate headers for API requests
        if ($isApiRequest) {
            $request->headers->set('Accept', 'application/json');
        }

        $response = $next($request);

        // Add CORS headers for API requests
        if ($isApiRequest && method_exists($response, 'header')) {
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept');
            $response->header('Content-Type', 'application/json');
        }

        return $response;
    }

    /**
     * Determine if the request should return JSON
     *
     * @param Request $request
     * @return bool
     */
    private function shouldReturnJson(Request $request): bool
    {
        // Check if it's an API route
        if ($request->is('api/*')) {
            return true;
        }

        // Check Accept header
        if ($request->header('Accept') === 'application/json') {
            return true;
        }

        // Check if it's an AJAX request
        if ($request->ajax()) {
            return true;
        }

        // Check if it's from a mobile app (common user agents)
        $userAgent = $request->header('User-Agent', '');
        $mobileIndicators = [
            'Fittelly-Mobile',  // Custom app identifier
            'Flutter',          // Flutter apps
            'Dart/',            // Dart HTTP client
            'okhttp',           // Android HTTP client
            'CFNetwork',        // iOS HTTP client
        ];

        foreach ($mobileIndicators as $indicator) {
            if (stripos($userAgent, $indicator) !== false) {
                return true;
            }
        }

        // Check for JSON content type in request
        if ($request->isJson()) {
            return true;
        }

        // Check for specific query parameter
        if ($request->has('format') && $request->get('format') === 'json') {
            return true;
        }

        // Default to web response
        return false;
    }
}