<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralCode;
use App\Models\ReferralUsage;
use App\Models\UserSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ReferralController extends Controller
{
    /**
     * Display referral codes listing
     */
    public function index(Request $request)
    {
        try {
            // Basic data initialization – start with an **empty** paginator instance to avoid
            // calling `paginate()` on a Collection (which would otherwise trigger
            // `BadMethodCallException` and yield a blank page).
            $referralCodes = ReferralCode::query()
                ->whereRaw('1 = 0') // guaranteed empty result set
                ->paginate(20);
            $stats = [
                'total_codes' => 0,
                'active_codes' => 0,
                'total_usages' => 0,
                'successful_usages' => 0,
                'total_discount_given' => 0,
                'revenue_from_referrals' => 0,
            ];

            // Try to get data from database
            try {
                $referralCodes = ReferralCode::with(['user'])
                    ->when($request->get('status'), function ($query, $status) {
                        return $query->where('is_active', $status === 'active');
                    })
                    ->latest()
                    ->paginate(20);

                $stats['total_codes'] = ReferralCode::count();
                $stats['active_codes'] = ReferralCode::where('is_active', true)->count();
                
                // Handle stats that might have relationship issues
                try {
                    $stats['total_usages'] = ReferralUsage::count();
                    $stats['successful_usages'] = ReferralUsage::whereNotNull('used_at')->count();
                    $stats['total_discount_given'] = ReferralUsage::sum('discount_amount') ?? 0;
                } catch (\Exception $e) {
                    \Log::warning('Referral usage stats error: ' . $e->getMessage());
                }

            } catch (\Exception $e) {
                \Log::error('Referral data fetch error: ' . $e->getMessage());
                // Continue with empty data
            }

            return view('admin.referral.index', compact('referralCodes', 'stats'));
            
        } catch (\Exception $e) {
            \Log::error('Referral Controller Fatal Error: ' . $e->getMessage());
            
            // Build an empty paginator for the fallback as well
            $emptyPaginator = ReferralCode::query()->whereRaw('1 = 0')->paginate(20);

            return response()->view('admin.referral.index', [
                'referralCodes' => $emptyPaginator,
                'stats' => [
                    'total_codes' => 0,
                    'active_codes' => 0,
                    'total_usages' => 0,
                    'successful_usages' => 0,
                    'total_discount_given' => 0,
                    'revenue_from_referrals' => 0,
                ]
            ])->header('X-Debug-Info', 'Emergency fallback used');
        }
    }

    /**
     * Show create referral form
     */
    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('admin.referral.create', compact('users'));
    }

    /**
     * Store new referral code
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'nullable|string|max:50|unique:referral_codes,code',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:today',
            'is_active' => 'boolean',
        ]);

        try {
            $code = $request->code ?: Str::upper(Str::random(8));
            
            // Ensure code is unique
            while (ReferralCode::where('code', $code)->exists()) {
                $code = Str::upper(Str::random(8));
            }

            ReferralCode::create([
                'user_id' => $request->user_id,
                'code' => $code,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'max_uses' => $request->max_uses,
                'expires_at' => $request->expires_at,
                'is_active' => $request->boolean('is_active', true),
            ]);

            return redirect()->route('admin.subscriptions.referrals.index')
                ->with('success', 'Referral code created successfully!');
        } catch (\Exception $e) {
            \Log::error('Error creating referral code: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error creating referral code!')
                ->withInput();
        }
    }

    /**
     * Show referral code details
     */
    public function show(ReferralCode $referralCode)
    {
        $referralCode->load(['user', 'usages.user', 'usages.subscription.subscriptionPlan']);
        
        $stats = [
            'total_uses' => $referralCode->usages()->count(),
            'successful_uses' => $referralCode->usages()->whereNotNull('used_at')->count(),
            'total_discount_given' => $referralCode->usages()->sum('discount_amount'),
            'revenue_generated' => $referralCode->usages()
                ->whereHas('subscription')
                ->with('subscription')
                ->get()
                ->sum('subscription.amount_paid'),
        ];

        return view('admin.referral.show', compact('referralCode', 'stats'));
    }

    /**
     * Show edit referral form
     */
    public function edit(ReferralCode $referralCode)
    {
        $users = User::orderBy('name')->get();
        return view('admin.referral.edit', compact('referralCode', 'users'));
    }

    /**
     * Update referral code
     */
    public function update(Request $request, ReferralCode $referralCode)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:referral_codes,code,' . $referralCode->id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'boolean',
        ]);

        try {
            $referralCode->update([
                'code' => $request->code,
                'discount_type' => $request->discount_type,
                'discount_value' => $request->discount_value,
                'max_uses' => $request->max_uses,
                'expires_at' => $request->expires_at,
                'is_active' => $request->boolean('is_active'),
            ]);

            return redirect()->route('admin.subscriptions.referrals.index')
                ->with('success', 'Referral code updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating referral code!')
                ->withInput();
        }
    }

    /**
     * Delete referral code
     */
    public function destroy(ReferralCode $referralCode)
    {
        try {
            if ($referralCode->usages()->whereNotNull('used_at')->count() > 0) {
                return redirect()->back()
                    ->with('error', 'Cannot delete referral code that has been used!');
            }

            $referralCode->delete();

            return redirect()->route('admin.subscriptions.referrals.index')
                ->with('success', 'Referral code deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error deleting referral code!');
        }
    }

    /**
     * Show referral analytics dashboard
     */
    public function analyticsDashboard(Request $request)
    {
        $period = $request->get('range', '30');
        $startDate = now()->subDays($period);

        try {
            $data = [
                'total_codes' => ReferralCode::count(),
                'active_codes' => ReferralCode::where('is_active', true)->count(),
                'total_usages' => ReferralUsage::where('created_at', '>=', $startDate)->count(),
                'successful_usages' => ReferralUsage::where('used_at', '>=', $startDate)->count(),
                'total_discount_given' => ReferralUsage::where('created_at', '>=', $startDate)->sum('discount_amount'),
                'revenue_from_referrals' => UserSubscription::whereHas('referralUsage', function($query) use ($startDate) {
                    $query->where('used_at', '>=', $startDate);
                })->sum('amount_paid'),
                'top_codes' => $this->getTopReferralCodes($startDate),
                'daily_usage' => $this->getDailyUsage($startDate),
            ];

            return view('admin.referral.analytics', compact('data'));
        } catch (\Exception $e) {
            \Log::error('Error loading referral analytics: ' . $e->getMessage());
            
            $data = [
                'total_codes' => 0,
                'active_codes' => 0,
                'total_usages' => 0,
                'successful_usages' => 0,
                'total_discount_given' => 0,
                'revenue_from_referrals' => 0,
                'top_codes' => collect(),
                'daily_usage' => collect(),
            ];

            return view('admin.referral.analytics', compact('data'))
                ->with('warning', 'Analytics data may not be available.');
        }
    }

    /**
     * Get top performing referral codes
     */
    private function getTopReferralCodes($startDate)
    {
        return ReferralCode::withCount(['usages' => function($query) use ($startDate) {
            $query->where('used_at', '>=', $startDate);
        }])
        ->with('user:id,name,email')
        ->orderByDesc('usages_count')
        ->take(10)
        ->get();
    }

    /**
     * Get daily usage statistics
     */
    private function getDailyUsage($startDate)
    {
        return ReferralUsage::selectRaw('DATE(used_at) as date, COUNT(*) as count, SUM(discount_amount) as total_discount')
            ->where('used_at', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
} 