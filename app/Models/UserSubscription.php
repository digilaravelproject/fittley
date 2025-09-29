<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_plan_id',
        'status',
        'amount_paid',
        'payment_method',
        'transaction_id',
        'gateway_subscription_id',
        'started_at',
        'ends_at',
        'trial_ends_at',
        'cancelled_at',
        'subscription_data',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'subscription_plan_id' => 'integer',
        'amount_paid' => 'decimal:2',
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'subscription_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptionPlan()
    {
        return $this->belongsTo(SubscriptionPlan::class);
    }

    public function referralUsage()
    {
        return $this->hasOne(ReferralUsage::class, 'subscription_id');
    }

    public function paymentTransaction()
    {
        return $this->hasOne(paymentTransaction::class, 'user_id');
    }

    public function influencerSale()
    {
        return $this->hasOne(InfluencerSale::class, 'user_subscription_id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeTrial($query)
    {
        return $query->where('status', 'trial');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function isActive()
    {
        return $this->status === 'active' && $this->ends_at > now();
    }

    public function isTrial()
    {
        return $this->status === 'trial' && $this->trial_ends_at > now();
    }

    public function isExpired()
    {
        return $this->status === 'expired' || $this->ends_at <= now();
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function getRemainingDaysAttribute()
    {
        if ($this->isTrial()) {
            return max(0, $this->trial_ends_at->diffInDays(now()));
        }
        
        if ($this->isActive()) {
            return max(0, $this->ends_at->diffInDays(now()));
        }
        
        return 0;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'active' => 'Active',
            'trial' => 'Trial',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);
    }

    public function markAsExpired()
    {
        $this->update(['status' => 'expired']);
    }

    public function renew($newEndDate, $amountPaid = null)
    {
        $updateData = [
            'status' => 'active',
            'ends_at' => $newEndDate,
            'cancelled_at' => null,
        ];

        if ($amountPaid) {
            $updateData['amount_paid'] = $amountPaid;
        }

        $this->update($updateData);
    }
} 