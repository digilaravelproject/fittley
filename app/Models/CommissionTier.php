<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class CommissionTier extends Model
{
    protected $fillable = [
        'name',
        'description',
        'min_visits',
        'min_conversions',
        'min_revenue',
        'min_active_days',
        'commission_percentage',
        'bonus_percentage',
        'has_priority_support',
        'can_create_custom_links',
        'max_custom_links',
        'gets_analytics_access',
        'maintain_visits_per_month',
        'maintain_conversions_per_month',
        'maintain_revenue_per_month',
        'is_active',
        'sort_order',
        'color_code',
        'icon'
    ];

    protected $casts = [
        'min_visits' => 'integer',
        'min_conversions' => 'integer',
        'min_revenue' => 'decimal:2',
        'min_active_days' => 'integer',
        'commission_percentage' => 'decimal:2',
        'bonus_percentage' => 'decimal:2',
        'has_priority_support' => 'boolean',
        'can_create_custom_links' => 'boolean',
        'max_custom_links' => 'integer',
        'gets_analytics_access' => 'boolean',
        'maintain_visits_per_month' => 'integer',
        'maintain_conversions_per_month' => 'integer',
        'maintain_revenue_per_month' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'current_commission_tier_id');
    }

    public function influencerProfiles(): HasMany
    {
        return $this->hasMany(InfluencerProfile::class, 'commission_tier_id');
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrderedByTier(Builder $query): Builder
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Static Methods for Tier Management
    public static function getDefaultTier(): ?CommissionTier
    {
        return static::active()->orderBy('sort_order', 'asc')->first();
    }

    public static function getHighestTier(): ?CommissionTier
    {
        return static::active()->orderBy('sort_order', 'desc')->first();
    }

    public static function calculateTierForUser(User $user): ?CommissionTier
    {
        // Get user's influencer profile
        $influencerProfile = $user->influencerProfile;
        if (!$influencerProfile) {
            return static::getDefaultTier();
        }

        // Calculate user's performance metrics
        $metrics = static::calculateUserMetrics($user);
        
        // Apply the exact commission structure from requirements
        $conversions = $metrics['total_conversions'];
        
        if ($conversions >= 100) {
            // 100+ people: 15% commission
            return static::getOrCreateTier('Platinum', 15.0, 100);
        } elseif ($conversions >= 51) {
            // 51-100 people: 12% commission  
            return static::getOrCreateTier('Gold', 12.0, 51);
        } elseif ($conversions >= 50) {
            // 50 people: 10% commission
            return static::getOrCreateTier('Silver', 10.0, 50);
        }
        
        // Default tier for new influencers
        return static::getOrCreateTier('Bronze', 5.0, 0);
    }
    
    public static function getOrCreateTier($name, $commission, $minConversions): CommissionTier
    {
        return static::firstOrCreate(
            ['name' => $name],
            [
                'description' => "Tier for {$name} level influencers",
                'min_conversions' => $minConversions,
                'commission_percentage' => $commission,
                'is_active' => true,
                'sort_order' => $commission * 10, // Use commission as sort order
                'color_code' => match($name) {
                    'Platinum' => '#E5E4E2',
                    'Gold' => '#FFD700', 
                    'Silver' => '#C0C0C0',
                    'Bronze' => '#CD7F32',
                    default => '#6B7280'
                }
            ]
        );
    }

    public static function calculateUserMetrics(User $user): array
    {
        $influencerProfile = $user->influencerProfile;
        if (!$influencerProfile) {
            return [
                'total_visits' => 0,
                'total_conversions' => 0,
                'total_revenue' => 0,
                'active_days' => 0,
                'monthly_visits' => 0,
                'monthly_conversions' => 0,
                'monthly_revenue' => 0
            ];
        }

        // Get all influencer links for this user
        $linkIds = $influencerProfile->links()->pluck('id');
        
        // Calculate total metrics
        $totalVisits = InfluencerLinkVisit::whereIn('influencer_link_id', $linkIds)->count();
        $totalConversions = InfluencerLinkVisit::whereIn('influencer_link_id', $linkIds)
                                              ->where('is_converted', true)
                                              ->count();
        $totalRevenue = InfluencerLinkVisit::whereIn('influencer_link_id', $linkIds)
                                          ->where('is_converted', true)
                                          ->sum('conversion_value');

        // Calculate active days (days with at least one visit)
        $activeDays = InfluencerLinkVisit::whereIn('influencer_link_id', $linkIds)
                                        ->selectRaw('DATE(created_at) as date')
                                        ->distinct()
                                        ->count();

        // Calculate monthly metrics (current month)
        $monthlyVisits = InfluencerLinkVisit::whereIn('influencer_link_id', $linkIds)
                                           ->whereMonth('created_at', Carbon::now()->month)
                                           ->whereYear('created_at', Carbon::now()->year)
                                           ->count();

        $monthlyConversions = InfluencerLinkVisit::whereIn('influencer_link_id', $linkIds)
                                                ->whereMonth('created_at', Carbon::now()->month)
                                                ->whereYear('created_at', Carbon::now()->year)
                                                ->where('is_converted', true)
                                                ->count();

        $monthlyRevenue = InfluencerLinkVisit::whereIn('influencer_link_id', $linkIds)
                                            ->whereMonth('created_at', Carbon::now()->month)
                                            ->whereYear('created_at', Carbon::now()->year)
                                            ->where('is_converted', true)
                                            ->sum('conversion_value');

        return [
            'total_visits' => $totalVisits,
            'total_conversions' => $totalConversions,
            'total_revenue' => $totalRevenue ?? 0,
            'active_days' => $activeDays,
            'monthly_visits' => $monthlyVisits,
            'monthly_conversions' => $monthlyConversions,
            'monthly_revenue' => $monthlyRevenue ?? 0
        ];
    }

    public static function userQualifiesForTier(CommissionTier $tier, array $metrics): bool
    {
        // Check if user meets any of the minimum requirements (OR logic)
        $qualifies = false;

        if ($tier->min_visits && $metrics['total_visits'] >= $tier->min_visits) {
            $qualifies = true;
        }

        if ($tier->min_conversions && $metrics['total_conversions'] >= $tier->min_conversions) {
            $qualifies = true;
        }

        if ($tier->min_revenue && $metrics['total_revenue'] >= $tier->min_revenue) {
            $qualifies = true;
        }

        if ($tier->min_active_days && $metrics['active_days'] >= $tier->min_active_days) {
            $qualifies = true;
        }

        // If they qualify for the tier, check maintenance requirements
        if ($qualifies && static::userMaintainsTier($tier, $metrics)) {
            return true;
        }

        return false;
    }

    public static function userMaintainsTier(CommissionTier $tier, array $metrics): bool
    {
        // Check monthly maintenance requirements (AND logic)
        if ($tier->maintain_visits_per_month && $metrics['monthly_visits'] < $tier->maintain_visits_per_month) {
            return false;
        }

        if ($tier->maintain_conversions_per_month && $metrics['monthly_conversions'] < $tier->maintain_conversions_per_month) {
            return false;
        }

        if ($tier->maintain_revenue_per_month && $metrics['monthly_revenue'] < $tier->maintain_revenue_per_month) {
            return false;
        }

        return true;
    }

    public static function updateUserTier(User $user): bool
    {
        $newTier = static::calculateTierForUser($user);
        
        if (!$newTier) {
            return false;
        }

        $oldTierId = $user->current_commission_tier_id;
        
        // Only update if tier changed
        if ($oldTierId !== $newTier->id) {
            $user->update([
                'current_commission_tier_id' => $newTier->id,
                'tier_achieved_at' => now()
            ]);

            // Update influencer profile commission rate
            if ($user->influencerProfile) {
                $user->influencerProfile->update([
                    'commission_rate' => $newTier->commission_percentage
                ]);
            }

            return true;
        }

        return false;
    }

    // Helper Methods
    public function getTotalCommission(): float
    {
        return $this->commission_percentage + $this->bonus_percentage;
    }

    public function canUserCreateCustomLinks(User $user): bool
    {
        if (!$this->can_create_custom_links) {
            return false;
        }

        if ($this->max_custom_links) {
            $existingLinks = $user->influencerProfile?->links()->count() ?? 0;
            return $existingLinks < $this->max_custom_links;
        }

        return true;
    }

    public function getColorCode(): string
    {
        return $this->color_code ?: '#6c757d'; // Default gray
    }

    public function getIcon(): string
    {
        return $this->icon ?: 'fas fa-medal'; // Default medal icon
    }

    // Batch tier update for all users
    public static function updateAllUserTiers(): int
    {
        $updatedCount = 0;
        
        User::whereHas('influencerProfile')
            ->chunk(100, function ($users) use (&$updatedCount) {
                foreach ($users as $user) {
                    if (static::updateUserTier($user)) {
                        $updatedCount++;
                    }
                }
            });

        return $updatedCount;
    }
}
