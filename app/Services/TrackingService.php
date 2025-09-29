<?php

namespace App\Services;

use App\Models\User;
use App\Models\InfluencerLink;
use App\Models\InfluencerLinkVisit;
use App\Models\ReferralCode;
use App\Models\ReferralUsage;
use App\Models\CommissionTier;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class TrackingService
{
    /**
     * Track influencer link visit
     */
    public function trackInfluencerVisit(InfluencerLink $influencerLink, Request $request): InfluencerLinkVisit
    {
        $sessionId = Session::getId();
        
        // Check if this session already visited this link
        $existingVisit = InfluencerLinkVisit::where('influencer_link_id', $influencerLink->id)
                                           ->where('session_id', $sessionId)
                                           ->first();

        if ($existingVisit) {
            // Update existing visit
            $existingVisit->updatePageViews();
            return $existingVisit;
        }

        // Create new visit record
        return InfluencerLinkVisit::create([
            'influencer_link_id' => $influencerLink->id,
            'session_id' => $sessionId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer_url' => $request->headers->get('referer'),
            'utm_parameters' => $this->extractUtmParameters($request),
            'country' => $this->getCountryFromIP($request->ip()),
            'device_type' => $this->detectDeviceType($request->userAgent()),
            'browser' => $this->detectBrowser($request->userAgent()),
            'os' => $this->detectOS($request->userAgent()),
        ]);
    }

    /**
     * Track referral code usage
     */
    public function trackReferralCode(string $code, Request $request): ?ReferralUsage
    {
        $referralCode = ReferralCode::where('code', $code)
                                   ->where('is_active', true)
                                   ->first();

        if (!$referralCode || !$this->isReferralCodeValid($referralCode)) {
            return null;
        }

        $sessionId = Session::getId();

        // Check if already used in this session
        $existingUsage = ReferralUsage::where('referral_code_id', $referralCode->id)
                                     ->where('session_id', $sessionId)
                                     ->first();

        if ($existingUsage) {
            return $existingUsage;
        }

        // Create referral usage record
        return ReferralUsage::create([
            'referral_code_id' => $referralCode->id,
            'session_id' => $sessionId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'utm_parameters' => $this->extractUtmParameters($request),
        ]);
    }

    /**
     * Handle user signup with tracking
     */
    public function handleUserSignup(User $user, Request $request): void
    {
        $sessionId = Session::getId();

        // Update user with signup tracking info
        $user->update([
            'signup_session_id' => $sessionId,
            'signup_ip' => $request->ip(),
            'signup_user_agent' => $request->userAgent(),
            'signup_utm_params' => $this->extractUtmParameters($request),
            'first_visit_at' => now(),
        ]);

        // Check for influencer link visit
        $influencerVisit = InfluencerLinkVisit::where('session_id', $sessionId)
                                             ->whereNull('user_id')
                                             ->first();

        if ($influencerVisit) {
            $influencerVisit->update(['user_id' => $user->id]);
            
            $user->update([
                'referral_source' => 'influencer',
                'influencer_link_id' => $influencerVisit->influencer_link_id,
                'referred_by_user_id' => $influencerVisit->influencerLink->influencerProfile->user_id,
                'first_touch_source' => 'influencer_link',
                'last_touch_source' => 'influencer_link',
            ]);
        }

        // Check for referral code usage
        $referralUsage = ReferralUsage::where('session_id', $sessionId)
                                     ->whereNull('user_id')
                                     ->first();

        if ($referralUsage) {
            $referralUsage->update(['user_id' => $user->id]);
            
            $user->update([
                'referral_source' => 'referral_code',
                'referral_code_id' => $referralUsage->referral_code_id,
                'referred_by_user_id' => $referralUsage->referralCode->user_id,
                'first_touch_source' => 'referral_code',
                'last_touch_source' => 'referral_code',
            ]);
        }

        // If no specific referral source, mark as organic
        if (!$user->referral_source) {
            $user->update([
                'referral_source' => 'organic',
                'first_touch_source' => 'organic',
                'last_touch_source' => 'organic',
            ]);
        }
    }

    /**
     * Handle subscription conversion
     */
    public function handleSubscriptionConversion(UserSubscription $subscription): void
    {
        $user = $subscription->user;
        $sessionId = $user->signup_session_id;

        // Mark influencer visit as converted
        if ($user->influencer_link_id) {
            $influencerVisit = InfluencerLinkVisit::where('influencer_link_id', $user->influencer_link_id)
                                                 ->where('user_id', $user->id)
                                                 ->first();

            if ($influencerVisit && !$influencerVisit->is_converted) {
                $influencerVisit->markAsConverted($subscription);
                
                // Update tier for referring influencer
                $this->updateInfluencerTier($user->referredByUser);
            }
        }

        // Mark referral code as used
        if ($user->referral_code_id) {
            $referralUsage = ReferralUsage::where('referral_code_id', $user->referral_code_id)
                                         ->where('user_id', $user->id)
                                         ->first();

            if ($referralUsage && !$referralUsage->used_at) {
                $discount = $this->calculateReferralDiscount($referralUsage->referralCode, $subscription);
                
                $referralUsage->update([
                    'used_at' => now(),
                    'subscription_id' => $subscription->id,
                    'discount_amount' => $discount,
                ]);

                // Update referring user's referral stats
                if ($user->referredByUser) {
                    $user->referredByUser->increment('total_referrals_made');
                }
            }
        }
    }

    /**
     * Update influencer tier based on performance
     */
    public function updateInfluencerTier(User $influencer): bool
    {
        if (!$influencer || !$influencer->influencerProfile) {
            return false;
        }

        return CommissionTier::updateUserTier($influencer);
    }

    /**
     * Generate unique trackable link for influencer
     */
    public function generateInfluencerLink(User $influencer, array $options = []): string
    {
        $baseUrl = config('app.url');
        $code = $options['custom_code'] ?? $this->generateUniqueCode('influencer');
        
        // Create influencer link record if doesn't exist
        $influencerLink = InfluencerLink::firstOrCreate([
            'influencer_profile_id' => $influencer->influencerProfile->id,
            'code' => $code,
        ], [
            'name' => $options['name'] ?? 'Main Link',
            'target_url' => $options['target_url'] ?? route('subscription.plans'),
            'is_active' => true,
        ]);

        return "{$baseUrl}/inf/{$code}";
    }

    /**
     * Generate unique referral code
     */
    public function generateReferralCode(User $user, array $options = []): string
    {
        $code = $options['custom_code'] ?? $this->generateUniqueCode('referral');
        
        ReferralCode::firstOrCreate([
            'user_id' => $user->id,
            'code' => $code,
        ], [
            'discount_type' => $options['discount_type'] ?? 'percentage',
            'discount_value' => $options['discount_value'] ?? 10,
            'max_uses' => $options['max_uses'] ?? null,
            'expires_at' => $options['expires_at'] ?? null,
            'is_active' => true,
        ]);

        return $code;
    }

    /**
     * Calculate dynamic commission for influencer
     */
    public function calculateInfluencerCommission(InfluencerLinkVisit $visit): float
    {
        $influencer = $visit->influencerLink->influencerProfile->user;
        $tier = $influencer->currentCommissionTier ?? CommissionTier::getDefaultTier();
        
        if (!$tier || !$visit->conversion_value) {
            return 0;
        }

        $baseCommission = ($visit->conversion_value * $tier->commission_percentage) / 100;
        $bonus = ($visit->conversion_value * $tier->bonus_percentage) / 100;
        
        return $baseCommission + $bonus;
    }

    /**
     * Get analytics for influencer
     */
    public function getInfluencerAnalytics(User $influencer, int $days = 30): array
    {
        if (!$influencer->influencerProfile) {
            return [];
        }

        $linkIds = $influencer->influencerProfile->links()->pluck('id');
        $startDate = now()->subDays($days);

        $visits = InfluencerLinkVisit::whereIn('influencer_link_id', $linkIds)
                                   ->where('created_at', '>=', $startDate);

        return [
            'total_visits' => $visits->count(),
            'unique_visitors' => $visits->distinct('session_id')->count('session_id'),
            'conversions' => $visits->where('is_converted', true)->count(),
            'revenue' => $visits->where('is_converted', true)->sum('conversion_value'),
            'conversion_rate' => $this->calculateConversionRate($visits),
            'top_countries' => $this->getTopCountries($visits),
            'device_breakdown' => $this->getDeviceBreakdown($visits),
            'daily_stats' => $this->getDailyStats($visits, $days),
        ];
    }

    // Private helper methods
    private function extractUtmParameters(Request $request): array
    {
        return [
            'utm_source' => $request->get('utm_source'),
            'utm_medium' => $request->get('utm_medium'),
            'utm_campaign' => $request->get('utm_campaign'),
            'utm_term' => $request->get('utm_term'),
            'utm_content' => $request->get('utm_content'),
        ];
    }

    private function generateUniqueCode(string $type): string
    {
        do {
            $code = strtoupper(Str::random(8));
            
            if ($type === 'influencer') {
                $exists = InfluencerLink::where('code', $code)->exists();
            } else {
                $exists = ReferralCode::where('code', $code)->exists();
            }
        } while ($exists);

        return $code;
    }

    private function isReferralCodeValid(ReferralCode $referralCode): bool
    {
        // Check expiration
        if ($referralCode->expires_at && $referralCode->expires_at < now()) {
            return false;
        }

        // Check usage limit
        if ($referralCode->max_uses) {
            $usageCount = $referralCode->usages()->whereNotNull('used_at')->count();
            if ($usageCount >= $referralCode->max_uses) {
                return false;
            }
        }

        return true;
    }

    private function calculateReferralDiscount(ReferralCode $referralCode, UserSubscription $subscription): float
    {
        if ($referralCode->discount_type === 'percentage') {
            return ($subscription->amount_paid * $referralCode->discount_value) / 100;
        }

        return min($referralCode->discount_value, $subscription->amount_paid);
    }

    private function getCountryFromIP(string $ip): ?string
    {
        // This would integrate with a GeoIP service
        // For now, return null or implement basic detection
        return null;
    }

    private function detectDeviceType(string $userAgent): string
    {
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            return preg_match('/iPad/', $userAgent) ? 'tablet' : 'mobile';
        }
        return 'desktop';
    }

    private function detectBrowser(string $userAgent): string
    {
        if (preg_match('/Chrome/', $userAgent)) return 'Chrome';
        if (preg_match('/Firefox/', $userAgent)) return 'Firefox';
        if (preg_match('/Safari/', $userAgent)) return 'Safari';
        if (preg_match('/Edge/', $userAgent)) return 'Edge';
        return 'Other';
    }

    private function detectOS(string $userAgent): string
    {
        if (preg_match('/Windows/', $userAgent)) return 'Windows';
        if (preg_match('/Mac OS X/', $userAgent)) return 'macOS';
        if (preg_match('/Linux/', $userAgent)) return 'Linux';
        if (preg_match('/Android/', $userAgent)) return 'Android';
        if (preg_match('/iOS/', $userAgent)) return 'iOS';
        return 'Other';
    }

    private function calculateConversionRate($visits): float
    {
        $total = $visits->count();
        return $total > 0 ? ($visits->where('is_converted', true)->count() / $total) * 100 : 0;
    }

    private function getTopCountries($visits): array
    {
        return $visits->whereNotNull('country')
                     ->selectRaw('country, COUNT(*) as count')
                     ->groupBy('country')
                     ->orderByDesc('count')
                     ->limit(5)
                     ->get()
                     ->toArray();
    }

    private function getDeviceBreakdown($visits): array
    {
        return $visits->selectRaw('device_type, COUNT(*) as count')
                     ->groupBy('device_type')
                     ->get()
                     ->toArray();
    }

    private function getDailyStats($visits, int $days): array
    {
        $stats = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayVisits = $visits->whereDate('created_at', $date);
            
            $stats[] = [
                'date' => $date,
                'visits' => $dayVisits->count(),
                'conversions' => $dayVisits->where('is_converted', true)->count(),
                'revenue' => $dayVisits->where('is_converted', true)->sum('conversion_value'),
            ];
        }
        return $stats;
    }
} 