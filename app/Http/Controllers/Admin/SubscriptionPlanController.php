<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class SubscriptionPlanController extends Controller
{
    /**
     * Display subscription plans listing
     */
    public function index()
    {
        $plans = SubscriptionPlan::withCount(['subscriptions', 'activeSubscriptions'])
            ->orderBy('sort_order')
            ->orderBy('price')
            ->paginate(15);

        return view('admin.subscription.plans.index', compact('plans'));
    }

    /**
     * Show create plan form
     */
    public function create()
    {
        return view('admin.subscription.plans.create');
    }

    /**
     * Store new subscription plan
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,quarterly,yearly',
            'billing_cycle_count' => 'required|integer|min:1',
            'trial_days' => 'required|integer|min:0',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'features' => 'nullable|array',
            'restrictions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $plan = SubscriptionPlan::create($validator->validated());

            return redirect()->route('admin.subscriptions.plans.index')
                ->with('success', 'Subscription plan created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating subscription plan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating subscription plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show subscription plan details
     */
    public function show(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->load(['subscriptions' => function ($query) {
            $query->latest()->take(10);
        }]);

        // Get plan statistics
        $stats = [
            'total_subscriptions' => $subscriptionPlan->subscriptions()->count(),
            'active_subscriptions' => $subscriptionPlan->activeSubscriptions()->count(),
            'total_revenue' => $subscriptionPlan->subscriptions()->sum('amount_paid'),
            'monthly_revenue' => $subscriptionPlan->subscriptions()
                ->where('created_at', '>=', now()->subMonth())
                ->sum('amount_paid'),
        ];

        return view('admin.subscription.plans.show', compact('subscriptionPlan', 'stats'));
    }

    /**
     * Show edit plan form
     */
    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        $plan = $subscriptionPlan;
        return view('admin.subscription.plans.edit', compact('plan'));
    }

    /**
     * Update subscription plan
     */
    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,quarterly,yearly',
            'billing_cycle_count' => 'required|integer|min:1',
            'trial_days' => 'required|integer|min:0',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'required|integer|min:0',
            'features' => 'nullable|array',
            'restrictions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $subscriptionPlan->update($validator->validated());

            return redirect()->route('admin.subscriptions.plans.index')
                ->with('success', 'Subscription plan updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Error updating subscription plan: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error updating subscription plan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Delete subscription plan
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        try {
            if ($subscriptionPlan->activeSubscriptions()->count() > 0) {
                return redirect()->route('admin.subscriptions.plans.index')
                    ->with('error', 'Cannot delete plan with active subscriptions!');
            }

            $subscriptionPlan->delete();

            return redirect()->route('admin.subscriptions.plans.index')
                ->with('success', 'Subscription plan deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Error deleting subscription plan: ' . $e->getMessage());
            return redirect()->route('admin.subscriptions.plans.index')
                ->with('error', 'Error deleting subscription plan!');
        }
    }

    /**
     * Toggle plan status
     */
    public function toggleStatus(SubscriptionPlan $subscriptionPlan)
    {
        try {
            $subscriptionPlan->update(['is_active' => !$subscriptionPlan->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Plan status updated successfully!',
                'is_active' => $subscriptionPlan->is_active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating plan status!'
            ], 500);
        }
    }

    /**
     * Get plans for API
     */
    public function apiIndex(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 15);
        $plans = SubscriptionPlan::withCount(['subscriptions', 'activeSubscriptions'])
            ->when($request->get('active_only'), function ($query) {
                return $query->active();
            })
            ->ordered()
            ->paginate($perPage);

        return response()->json($plans);
    }

    /**
     * Get single plan for API
     */
    public function apiShow(SubscriptionPlan $plan): JsonResponse
    {
        $plan->load(['subscriptions' => function ($query) {
            $query->latest()->take(10);
        }]);

        return response()->json($plan);
    }

    /**
     * Update plan via API
     */
    public function apiUpdate(Request $request, SubscriptionPlan $plan): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'billing_cycle' => 'sometimes|required|in:monthly,quarterly,yearly',
            'billing_cycle_count' => 'sometimes|required|integer|min:1',
            'trial_days' => 'sometimes|required|integer|min:0',
            'is_popular' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|required|integer|min:0',
            'features' => 'sometimes|nullable|array',
            'restrictions' => 'sometimes|nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $plan->update($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Plan updated successfully!',
                'plan' => $plan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating plan!'
            ], 500);
        }
    }
} 