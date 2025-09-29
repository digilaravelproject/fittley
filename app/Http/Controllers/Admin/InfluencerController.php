<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfluencerProfile;
use App\Models\InfluencerSale;
use App\Models\CommissionPayout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class InfluencerController extends Controller
{
    /**
     * Display influencer profiles listing
     */
    public function index(Request $request)
    {
        $influencers = InfluencerProfile::with(['user'])
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->get('search'), function ($query, $search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total' => InfluencerProfile::count(),
            'pending' => InfluencerProfile::pending()->count(),
            'approved' => InfluencerProfile::approved()->count(),
            'rejected' => InfluencerProfile::rejected()->count(),
            'total_sales' => InfluencerSale::confirmed()->sum('sale_amount'),
        ];

        $availableUsers = User::whereDoesntHave('influencerProfile')->orderBy('name')->get();

        return view('admin.influencer.index', compact('influencers', 'stats', 'availableUsers'));
    }

    /**
     * Show influencer profile details
     */
    public function show(InfluencerProfile $influencer)
    {
        $influencer->load([
            'user', 
            'links.sales', 
            'sales' => function ($query) {
                $query->latest()->take(10);
            },
            'payouts' => function ($query) {
                $query->latest()->take(10);
            }
        ]);

        // Check if user relationship exists
        if (!$influencer->user) {
            return redirect()->route('admin.influencers.index')
                ->with('error', 'Influencer user account not found or has been deleted.');
        }

        $monthlyStats = [
            'sales_this_month' => $influencer->sales_this_month ?? 0,
            'commission_this_month' => $influencer->commission_this_month ?? 0,
            'commission_rate' => $influencer->commission_rate ?? 0,
        ];

        return view('admin.influencer.show', compact('influencer', 'monthlyStats'));
    }

    /**
     * Approve influencer application
     */
    public function approve(InfluencerProfile $influencer)
    {
        try {
            $influencer->approve(Auth::id());

            // Assign influencer role to user
            $influencer->user->assignRole('influencer');

            return redirect()->back()
                ->with('success', 'Influencer application approved successfully!');
        } catch (\Exception $e) {
            \Log::error('Error approving influencer: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error approving influencer application!');
        }
    }

    /**
     * Reject influencer application
     */
    public function reject(Request $request, InfluencerProfile $influencer)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        try {
            $influencer->reject($request->rejection_reason, Auth::id());

            return redirect()->back()
                ->with('success', 'Influencer application rejected.');
        } catch (\Exception $e) {
            \Log::error('Error rejecting influencer: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error rejecting influencer application!');
        }
    }

    /**
     * Suspend influencer
     */
    public function suspend(Request $request, InfluencerProfile $influencer)
    {
        try {
            $influencer->update(['status' => 'suspended']);

            return redirect()->back()
                ->with('success', 'Influencer suspended successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error suspending influencer!');
        }
    }

    /**
     * Reactivate influencer
     */
    public function reactivate(InfluencerProfile $influencer)
    {
        try {
            $influencer->update(['status' => 'approved']);

            return redirect()->back()
                ->with('success', 'Influencer reactivated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error reactivating influencer!');
        }
    }

    /**
     * Show influencer sales
     */
    public function sales(Request $request)
    {
        $sales = InfluencerSale::with(['influencerProfile.user', 'customer', 'subscription.subscriptionPlan'])
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->get('influencer_id'), function ($query, $influencerId) {
                return $query->where('influencer_profile_id', $influencerId);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total_sales' => InfluencerSale::sum('sale_amount'),
            'total_commission' => InfluencerSale::confirmed()->sum('commission_amount'),
            'pending_sales' => InfluencerSale::pending()->count(),
            'confirmed_sales' => InfluencerSale::confirmed()->count(),
        ];

        return view('admin.influencer.sales.index', compact('sales', 'stats'));
    }

    /**
     * Confirm sale
     */
    public function confirmSale(InfluencerSale $sale)
    {
        try {
            $sale->confirm();

            return redirect()->back()
                ->with('success', 'Sale confirmed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error confirming sale!');
        }
    }

    /**
     * Cancel sale
     */
    public function cancelSale(InfluencerSale $sale)
    {
        try {
            $sale->cancel();

            return redirect()->back()
                ->with('success', 'Sale cancelled successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error cancelling sale!');
        }
    }

    /**
     * Show commission payouts
     */
    public function payouts(Request $request)
    {
        $payouts = CommissionPayout::with(['influencerProfile.user', 'approvedBy', 'processedBy'])
            ->when($request->get('status'), function ($query, $status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        $stats = [
            'total_requested' => CommissionPayout::sum('amount'),
            'total_paid' => CommissionPayout::completed()->sum('amount'),
            'pending_approval' => CommissionPayout::pending()->count(),
            'approved_pending_payment' => CommissionPayout::approved()->count(),
        ];

        return view('admin.influencer.payouts.index', compact('payouts', 'stats'));
    }

    /**
     * Approve payout
     */
    public function approvePayout(Request $request, CommissionPayout $payout)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        try {
            $payout->approve(Auth::id(), $request->admin_notes);

            return redirect()->back()
                ->with('success', 'Payout approved successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error approving payout!');
        }
    }

    /**
     * Reject payout
     */
    public function rejectPayout(Request $request, CommissionPayout $payout)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        try {
            $payout->reject(Auth::id(), $request->rejection_reason);

            return redirect()->back()
                ->with('success', 'Payout rejected.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error rejecting payout!');
        }
    }

    /**
     * Mark payout as processing
     */
    public function processPayout(CommissionPayout $payout)
    {
        try {
            $payout->markAsProcessing(Auth::id());

            return redirect()->back()
                ->with('success', 'Payout marked as processing!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error processing payout!');
        }
    }

    /**
     * Complete payout
     */
    public function completePayout(Request $request, CommissionPayout $payout)
    {
        $request->validate([
            'external_transaction_id' => 'nullable|string|max:255',
        ]);

        try {
            $payout->markAsCompleted($request->external_transaction_id);

            return redirect()->back()
                ->with('success', 'Payout completed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error completing payout!');
        }
    }

    /**
     * Get influencer analytics
     */
    public function analytics(Request $request): JsonResponse
    {
        $period = $request->get('period', '30'); // days
        $startDate = now()->subDays($period);

        $data = [
            'total_influencers' => InfluencerProfile::approved()->count(),
            'new_applications' => InfluencerProfile::where('created_at', '>=', $startDate)->count(),
            'total_sales' => InfluencerSale::where('sale_date', '>=', $startDate)->sum('sale_amount'),
            'total_commission' => InfluencerSale::confirmed()
                ->where('sale_date', '>=', $startDate)
                ->sum('commission_amount'),
            'top_performers' => $this->getTopPerformers($startDate),
            'daily_sales' => $this->getDailySales($startDate),
        ];

        return response()->json($data);
    }

    /**
     * Get top performing influencers
     */
    private function getTopPerformers($startDate)
    {
        return InfluencerProfile::with('user:id,name')
            ->withSum(['sales as total_sales' => function ($query) use ($startDate) {
                $query->confirmed()->where('sale_date', '>=', $startDate);
            }], 'sale_amount')
            ->withSum(['sales as total_commission' => function ($query) use ($startDate) {
                $query->confirmed()->where('sale_date', '>=', $startDate);
            }], 'commission_amount')
            ->orderByDesc('total_sales')
            ->take(10)
            ->get();
    }

    /**
     * Get daily sales data
     */
    private function getDailySales($startDate)
    {
        return InfluencerSale::selectRaw('DATE(sale_date) as date, COUNT(*) as sales_count, SUM(sale_amount) as total_amount, SUM(commission_amount) as total_commission')
            ->confirmed()
            ->where('sale_date', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Show influencer analytics dashboard
     */
    public function analyticsDashboard(Request $request)
    {
        $period = $request->get('range', '30'); // days
        $startDate = now()->subDays($period);

        $data = [
            'total_influencers' => InfluencerProfile::approved()->count(),
            'new_applications' => InfluencerProfile::where('created_at', '>=', $startDate)->count(),
            'total_sales' => InfluencerSale::where('sale_date', '>=', $startDate)->sum('sale_amount'),
            'total_commission' => InfluencerSale::confirmed()
                ->where('sale_date', '>=', $startDate)
                ->sum('commission_amount'),
            'top_performers' => $this->getTopPerformers($startDate),
            'daily_sales' => $this->getDailySales($startDate),
        ];

        return view('admin.influencer.analytics', compact('data'));
    }

    /**
     * Show create influencer form
     */
    public function create()
    {
        $availableUsers = User::whereDoesntHave('influencerProfile')->orderBy('name')->get();
        $commissionTiers = \App\Models\CommissionTier::orderBy('min_visits')->get();
        
        return view('admin.influencer.create', compact('availableUsers', 'commissionTiers'));
    }

    /**
     * Store new influencer
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:influencer_profiles,user_id',
            'commission_tier' => 'nullable|exists:commission_tiers,id',
            'manual_rate' => 'nullable|numeric|min:5|max:50',
            'bio' => 'nullable|string|max:1000',
        ]);

        try {
            // Determine commission rate
            $commissionRate = 10; // Default rate
            $commissionTierId = null;
            
            if ($request->manual_rate) {
                // Use manual rate override
                $commissionRate = $request->manual_rate;
            } elseif ($request->commission_tier) {
                // Use tier rate
                $tier = \App\Models\CommissionTier::find($request->commission_tier);
                if ($tier) {
                    $commissionRate = $tier->total_rate;
                    $commissionTierId = $tier->id;
                }
            }

            $influencer = InfluencerProfile::create([
                'user_id' => $request->user_id,
                'status' => 'approved',
                'commission_rate' => $commissionRate,
                'commission_tier_id' => $commissionTierId,
                'bio' => $request->bio,
                'approved_by' => Auth::id(),
                'approved_at' => now(),
            ]);

            // Assign influencer role to user
            $influencer->user->assignRole('influencer');

            return redirect()->route('admin.influencers.index')
                ->with('success', 'Influencer added successfully with ' . 
                       ($request->manual_rate ? 'custom rate' : 'tier-based rate') . '!');
                       
        } catch (\Exception $e) {
            \Log::error('Error creating influencer: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating influencer!')
                ->withInput();
        }
    }

    /**
     * Show edit influencer form
     */
    public function edit(InfluencerProfile $influencerProfile)
    {
        return view('admin.influencer.edit', compact('influencerProfile'));
    }

    /**
     * Update influencer
     */
    public function update(Request $request, InfluencerProfile $influencerProfile)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:5|max:30',
            'bio' => 'nullable|string|max:1000',
        ]);

        try {
            $influencerProfile->update([
                'commission_rate' => $request->commission_rate,
                'bio' => $request->bio,
            ]);

            return redirect()->route('admin.influencers.index')
                ->with('success', 'Influencer updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating influencer!')
                ->withInput();
        }
    }

    /**
     * Delete influencer
     */
    public function destroy(InfluencerProfile $influencerProfile)
    {
        try {
            // Remove influencer role from user
            $influencerProfile->user->removeRole('influencer');
            
            $influencerProfile->delete();

            return redirect()->route('admin.influencers.index')
                ->with('success', 'Influencer removed successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error removing influencer!');
        }
    }
} 