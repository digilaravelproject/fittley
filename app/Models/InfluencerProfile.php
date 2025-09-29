<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfluencerProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'status',
        'application_status',
        'bio',
        'social_instagram',
        'social_youtube',
        'social_facebook',
        'social_twitter',
        'social_tiktok',
        'followers_count',
        'niche',
        'previous_work',
        'total_commission_earned',
        'total_commission_paid',
        'pending_commission',
        'commission_settings',
        'approved_at',
        'approved_by',
        'rejection_reason',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'followers_count' => 'integer',
        'total_commission_earned' => 'decimal:2',
        'total_commission_paid' => 'decimal:2',
        'pending_commission' => 'decimal:2',
        'commission_settings' => 'array',
        'approved_at' => 'datetime',
        'approved_by' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function links()
    {
        return $this->hasMany(InfluencerLink::class);
    }

    public function activeLinks()
    {
        return $this->hasMany(InfluencerLink::class)->where('is_active', true);
    }

    public function sales()
    {
        return $this->hasMany(InfluencerSale::class);
    }

    public function confirmedSales()
    {
        return $this->hasMany(InfluencerSale::class)->where('status', 'confirmed');
    }

    public function payouts()
    {
        return $this->hasMany(CommissionPayout::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function approve($approvedBy = null)
    {
        $this->update([
            'status' => 'approved',
            'application_status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedBy,
            'rejection_reason' => null,
        ]);
    }

    public function reject($reason = null, $rejectedBy = null)
    {
        $this->update([
            'status' => 'rejected',
            'application_status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_by' => $rejectedBy,
            'approved_at' => null,
        ]);
    }

    public function getCommissionRateAttribute()
    {
        $salesThisMonth = $this->confirmedSales()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();

        if ($salesThisMonth >= 101) {
            return 15;
        } elseif ($salesThisMonth >= 51) {
            return 12;
        } elseif ($salesThisMonth >= 50) {
            return 10;
        }

        return 5; // Default rate
    }

    public function getSalesThisMonthAttribute()
    {
        return $this->confirmedSales()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->count();
    }

    public function getCommissionThisMonthAttribute()
    {
        return $this->confirmedSales()
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('commission_amount');
    }

    public function addCommission($amount)
    {
        $this->increment('total_commission_earned', $amount);
        $this->increment('pending_commission', $amount);
    }

    public function payCommission($amount)
    {
        $this->increment('total_commission_paid', $amount);
        $this->decrement('pending_commission', $amount);
    }
} 