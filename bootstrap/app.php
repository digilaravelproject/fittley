<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);

        // Add content negotiation middleware globally
        $middleware->web(append: [
            \App\Http\Middleware\ContentNegotiationMiddleware::class,
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'subscription' => \App\Http\Middleware\CheckSubscription::class,
            'content_negotiation' => \App\Http\Middleware\ContentNegotiationMiddleware::class,
            'app_only_access' => \App\Http\Middleware\AppOnlyAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle API exceptions
        $exceptions->render(function (\App\Exceptions\ApiException $e, $request) {
            return $e->render();
        });

        // Handle validation exceptions for API requests
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, $request) {
            if ($request->attributes->get('is_api_request', false) || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'data' => null,
                    'errors' => $e->errors(),
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 422);
            }
        });

        // Handle authentication exceptions for API requests
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            if ($request->attributes->get('is_api_request', false) || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required',
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 401);
            }
        });

        // Handle authorization exceptions for API requests
        $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, $request) {
            if ($request->attributes->get('is_api_request', false) || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Access forbidden',
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 403);
            }
        });

        // Handle model not found exceptions for API requests
        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            if ($request->attributes->get('is_api_request', false) || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Resource not found',
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 404);
            }
        });

        // Handle HTTP not found exceptions for API requests
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            if ($request->attributes->get('is_api_request', false) || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint not found',
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 404);
            }
        });

        // Handle method not allowed exceptions for API requests
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException $e, $request) {
            if ($request->attributes->get('is_api_request', false) || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Method not allowed',
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 405);
            }
        });

        // Handle rate limiting exceptions for API requests
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            if ($request->attributes->get('is_api_request', false) || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Too many requests',
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0',
                        'retry_after' => $e->getHeaders()['Retry-After'] ?? null
                    ]
                ], 429);
            }
        });

        // Handle general exceptions for API requests
        $exceptions->render(function (\Throwable $e, $request) {
            if ($request->attributes->get('is_api_request', false) || $request->expectsJson()) {
                // Log the exception
                \Illuminate\Support\Facades\Log::error('API Exception: ' . $e->getMessage(), [
                    'exception' => $e,
                    'request' => $request->all(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_id' => auth()->id()
                ]);

                // Don't expose internal errors in production
                $message = app()->environment('production')
                    ? 'An error occurred while processing your request'
                    : $e->getMessage();

                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'data' => null,
                    'meta' => [
                        'timestamp' => now()->toISOString(),
                        'version' => '1.0'
                    ]
                ], 500);
            }
        });
    })->create();
