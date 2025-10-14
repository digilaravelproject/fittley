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
        'subscription_data' => 'array',
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /** RELATIONSHIPS */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(SubscriptionPlan::class, 'subscription_plan_id');
    }

    public function referralUsage()
    {
        return $this->hasOne(ReferralUsage::class, 'subscription_id');
    }

    public function paymentTransaction()
    {
        return $this->hasOne(PaymentTransaction::class, 'user_id', 'user_id');
    }

    public function influencerSale()
    {
        return $this->hasOne(InfluencerSale::class, 'user_subscription_id');
    }

    /** SCOPES */
    public function scopeActive($query)
    {
        return $query->where('status', 'active')->where('ends_at', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired')->orWhere('ends_at', '<=', now());
    }

    public function scopeTrial($query)
    {
        return $query->where('status', 'trial')->where('trial_ends_at', '>', now());
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /** STATUS CHECKS */
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

    /** REMAINING DAYS */
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

    /** LABEL */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'active' => 'Active',
            'trial' => 'Trial',
            'expired' => 'Expired',
            'cancelled' => 'Cancelled',
            default => 'Unknown',
        };
    }

    /** ACTIONS */
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

        if ($amountPaid !== null) {
            $updateData['amount_paid'] = $amountPaid;
        }

        $this->update($updateData);
    }
}
