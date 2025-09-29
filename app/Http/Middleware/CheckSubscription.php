<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $contentType = null): Response
    {
        $user = $request->user();
        
        // If user is not authenticated, redirect to login
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Authentication required',
                    'message' => 'Please login to access this content'
                ], 401);
            }
            
            return redirect()->route('login')->with('error', 'Please login to access this content.');
        }
        
        // Admin users bypass subscription checks
        if ($user->hasRole('admin')) {
            return $next($request);
        }
        
        // Instructors bypass subscription checks for their own sessions
        if ($user->hasRole('instructor') && $this->isInstructorSession($request, $user)) {
            return $next($request);
        }
        
        // Check if user has active subscription
        if (!$user->hasActiveSubscription()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Subscription required',
                    'message' => 'An active subscription is required to access this content',
                    'subscription_status' => $user->getSubscriptionStatus(),
                    'available_plans' => \App\Models\SubscriptionPlan::active()->get(['id', 'name', 'price', 'duration_months'])
                ], 403);
            }
            
            // For web requests, redirect to subscription page
            return redirect()->route('subscription.plans')
                ->with('error', 'An active subscription is required to access this content.');
        }
        
        // Check content-specific restrictions if specified
        if ($contentType && !$user->canAccessContent($contentType)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Content restriction',
                    'message' => "Your current subscription plan doesn't include access to {$contentType} content",
                    'current_plan' => $user->currentSubscription?->subscriptionPlan->name
                ], 403);
            }
            
            return redirect()->route('subscription.plans')
                ->with('error', "Your current subscription plan doesn't include access to {$contentType} content.");
        }
        
        return $next($request);
    }
    
    /**
     * Check if the instructor is accessing their own session
     */
    private function isInstructorSession(Request $request, $user): bool
    {
        // Check if this is a FitLive session route
        if (!str_contains($request->path(), 'fitlive/')) {
            return false;
        }
        
        // Extract session ID from route parameters
        $sessionId = $request->route('id');
        if (!$sessionId) {
            return false;
        }
        
        // Check if user is the instructor for this session
        $session = \App\Models\FitLiveSession::find($sessionId);
        return $session && $session->instructor_id === $user->id;
    }
} 