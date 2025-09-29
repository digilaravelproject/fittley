<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class InfluencerLinkVisit extends Model
{
    protected $fillable = [
        'influencer_link_id',
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'referrer_url',
        'utm_parameters',
        'country',
        'city',
        'device_type',
        'browser',
        'os',
        'is_converted',
        'converted_at',
        'subscription_id',
        'conversion_value',
        'page_views',
        'time_on_site',
        'last_activity'
    ];

    protected $casts = [
        'utm_parameters' => 'array',
        'is_converted' => 'boolean',
        'converted_at' => 'datetime',
        'last_activity' => 'datetime',
        'conversion_value' => 'decimal:2'
    ];

    // Relationships
    public function influencerLink(): BelongsTo
    {
        return $this->belongsTo(InfluencerLink::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(UserSubscription::class, 'subscription_id');
    }

    // Scopes
    public function scopeConverted(Builder $query): Builder
    {
        return $query->where('is_converted', true);
    }

    public function scopeNotConverted(Builder $query): Builder
    {
        return $query->where('is_converted', false);
    }

    public function scopeFromToday(Builder $query): Builder
    {
        return $query->whereDate('created_at', Carbon::today());
    }

    public function scopeFromThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfWeek(),
            Carbon::now()->endOfWeek()
        ]);
    }

    public function scopeFromThisMonth(Builder $query): Builder
    {
        return $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
    }

    public function scopeFromDateRange(Builder $query, $startDate, $endDate): Builder
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Helper Methods
    public function markAsConverted(UserSubscription $subscription): bool
    {
        return $this->update([
            'is_converted' => true,
            'converted_at' => now(),
            'subscription_id' => $subscription->id,
            'conversion_value' => $subscription->amount_paid,
            'user_id' => $subscription->user_id
        ]);
    }

    public function updatePageViews(): bool
    {
        return $this->increment('page_views');
    }

    public function updateTimeOnSite(int $timeSpent): bool
    {
        return $this->update([
            'time_on_site' => ($this->time_on_site ?? 0) + $timeSpent,
            'last_activity' => now()
        ]);
    }

    // Accessors
    public function getDeviceTypeAttribute($value): string
    {
        return $value ?? $this->detectDeviceType();
    }

    public function getBrowserAttribute($value): string
    {
        return $value ?? $this->detectBrowser();
    }

    public function getOsAttribute($value): string
    {
        return $value ?? $this->detectOS();
    }

    // Device Detection Methods
    private function detectDeviceType(): string
    {
        $userAgent = $this->user_agent ?? '';
        
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            if (preg_match('/iPad/', $userAgent)) {
                return 'tablet';
            }
            return 'mobile';
        }
        
        return 'desktop';
    }

    private function detectBrowser(): string
    {
        $userAgent = $this->user_agent ?? '';
        
        if (preg_match('/Chrome/', $userAgent)) return 'Chrome';
        if (preg_match('/Firefox/', $userAgent)) return 'Firefox';
        if (preg_match('/Safari/', $userAgent)) return 'Safari';
        if (preg_match('/Edge/', $userAgent)) return 'Edge';
        if (preg_match('/Opera/', $userAgent)) return 'Opera';
        
        return 'Unknown';
    }

    private function detectOS(): string
    {
        $userAgent = $this->user_agent ?? '';
        
        if (preg_match('/Windows/', $userAgent)) return 'Windows';
        if (preg_match('/Mac OS X/', $userAgent)) return 'macOS';
        if (preg_match('/Linux/', $userAgent)) return 'Linux';
        if (preg_match('/Android/', $userAgent)) return 'Android';
        if (preg_match('/iOS/', $userAgent)) return 'iOS';
        
        return 'Unknown';
    }

    // Static Methods for Analytics
    public static function getConversionRate(int $influencerLinkId): float
    {
        $total = static::where('influencer_link_id', $influencerLinkId)->count();
        $converted = static::where('influencer_link_id', $influencerLinkId)
                          ->where('is_converted', true)
                          ->count();

        return $total > 0 ? ($converted / $total) * 100 : 0;
    }

    public static function getTotalRevenue(int $influencerLinkId): float
    {
        return static::where('influencer_link_id', $influencerLinkId)
                    ->where('is_converted', true)
                    ->sum('conversion_value') ?? 0;
    }

    public static function getUniqueVisitors(int $influencerLinkId): int
    {
        return static::where('influencer_link_id', $influencerLinkId)
                    ->distinct('session_id')
                    ->count('session_id');
    }
}
