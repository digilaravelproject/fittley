<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReferralCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'usage_count',
        'max_usage',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'usage_count' => 'integer',
        'max_usage' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($referralCode) {
            if (empty($referralCode->code)) {
                $referralCode->code = static::generateUniqueCode();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function usages()
    {
        return $this->hasMany(ReferralUsage::class);
    }

    public function successfulUsages()
    {
        return $this->hasMany(ReferralUsage::class)->where('status', 'applied');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', $code);
    }

    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at < now()) {
            return false;
        }

        if ($this->max_usage && $this->usage_count >= $this->max_usage) {
            return false;
        }

        return true;
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    public function getRemainingUsagesAttribute()
    {
        if (!$this->max_usage) {
            return null; // Unlimited
        }

        return max(0, $this->max_usage - $this->usage_count);
    }

    public function getDiscountPercentageAttribute()
    {
        $successfulReferrals = $this->usage_count;
        
        if ($successfulReferrals >= 4) {
            return 30;
        } elseif ($successfulReferrals == 3) {
            return 25;
        } elseif ($successfulReferrals == 2) {
            return 20;
        }
        
        return 0;
    }

    public function getNewUserDiscountPercentageAttribute()
    {
        $successfulReferrals = $this->usage_count;
        
        if ($successfulReferrals >= 4) {
            return 20; // 20% off to new user when referrer has 4+ referrals
        } elseif ($successfulReferrals == 3) {
            return 15; // 15% off to new user when referrer has 3 referrals
        } elseif ($successfulReferrals == 2) {
            return 10; // 10% off to new user when referrer has 2 referrals
        }
        
        return 5; // 5% default discount for new users
    }

    public function getReferrerBonusPercentageAttribute()
    {
        return $this->getDiscountPercentageAttribute();
    }

    public static function generateUniqueCode($length = 8)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (static::where('code', $code)->exists());

        return $code;
    }

    public static function findByCode($code)
    {
        return static::where('code', $code)->first();
    }
} 