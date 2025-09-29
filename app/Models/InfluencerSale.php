<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfluencerSale extends Model
{
    use HasFactory;

    protected $fillable = [
        'influencer_profile_id',
        'influencer_link_id',
        'user_subscription_id',
        'customer_id',
        'sale_amount',
        'commission_rate',
        'commission_amount',
        'status',
        'commission_status',
        'sale_date',
        'sale_metadata',
    ];

    protected $casts = [
        'influencer_profile_id' => 'integer',
        'influencer_link_id' => 'integer',
        'user_subscription_id' => 'integer',
        'customer_id' => 'integer',
        'sale_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'sale_date' => 'datetime',
        'sale_metadata' => 'array',
    ];

    public function influencerProfile()
    {
        return $this->belongsTo(InfluencerProfile::class);
    }

    public function influencerLink()
    {
        return $this->belongsTo(InfluencerLink::class);
    }

    public function subscription()
    {
        return $this->belongsTo(UserSubscription::class, 'user_subscription_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeCommissionPending($query)
    {
        return $query->where('commission_status', 'pending');
    }

    public function scopeCommissionCalculated($query)
    {
        return $query->where('commission_status', 'calculated');
    }

    public function scopeCommissionPaid($query)
    {
        return $query->where('commission_status', 'paid');
    }

    public function confirm()
    {
        $this->update(['status' => 'confirmed']);
        $this->calculateCommission();
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function calculateCommission()
    {
        if ($this->status === 'confirmed' && $this->commission_status === 'pending') {
            $this->update(['commission_status' => 'calculated']);
            
            // Add commission to influencer profile
            $this->influencerProfile->addCommission($this->commission_amount);
        }
    }

    public function markCommissionAsPaid()
    {
        $this->update(['commission_status' => 'paid']);
    }

    public static function createSale($influencerProfile, $subscription, $influencerLink = null)
    {
        $commissionRate = $influencerProfile->commission_rate;
        $saleAmount = $subscription->amount_paid;
        $commissionAmount = ($saleAmount * $commissionRate) / 100;

        return static::create([
            'influencer_profile_id' => $influencerProfile->id,
            'influencer_link_id' => $influencerLink?->id,
            'user_subscription_id' => $subscription->id,
            'customer_id' => $subscription->user_id,
            'sale_amount' => $saleAmount,
            'commission_rate' => $commissionRate,
            'commission_amount' => $commissionAmount,
            'status' => 'pending',
            'commission_status' => 'pending',
            'sale_date' => now(),
        ]);
    }
} 