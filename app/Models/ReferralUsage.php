<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralUsage extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_code_id',
        'referrer_id',
        'referred_user_id',
        'subscription_id',
        'discount_amount',
        'discount_percentage',
        'status',
    ];

    protected $casts = [
        'referral_code_id' => 'integer',
        'referrer_id' => 'integer',
        'referred_user_id' => 'integer',
        'subscription_id' => 'integer',
        'discount_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
    ];

    public function referralCode()
    {
        return $this->belongsTo(ReferralCode::class);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'subscription_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApplied($query)
    {
        return $query->where('status', 'applied');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function markAsApplied()
    {
        $this->update(['status' => 'applied']);
    }

    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
    }
} 