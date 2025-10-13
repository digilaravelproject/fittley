<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{


    public function index()
    {
        $user = Auth::user();

        // Role redirect
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('instructor')) {
            return redirect()->route('instructor.dashboard');
        }

        // Get active subscription
        $subscription = $user->currentSubscription()->first();

        $planName = null;
        $timeLeft = null;

        if ($subscription) {

            // 1️⃣ Get plan name
            $plan = SubscriptionPlan::find($subscription->subscription_plan_id);
            $planName = $plan ? $plan->name : null;

            // 2️⃣ Calculate time difference correctly using ends_at
            $timeLeft = now()->diffForHumans(
                $subscription->ends_at,
                [
                    'parts' => 2,  // e.g. 11 months 2 days
                    'short' => false,
                    'syntax' => \Carbon\CarbonInterface::DIFF_RELATIVE_TO_NOW, // "in 11 months"
                ]
            );
        }

        return view('user.dashboard', compact('user', 'planName', 'timeLeft'));
    }
}
