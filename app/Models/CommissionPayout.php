<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CommissionPayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'influencer_profile_id',
        'payout_id',
        'amount',
        'status',
        'payment_method',
        'payment_details',
        'requested_at',
        'approved_at',
        'processed_at',
        'completed_at',
        'approved_by',
        'processed_by',
        'admin_notes',
        'rejection_reason',
        'external_transaction_id',
        'payout_metadata',
    ];

    protected $casts = [
        'influencer_profile_id' => 'integer',
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'approved_by' => 'integer',
        'processed_by' => 'integer',
        'payout_metadata' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($payout) {
            if (empty($payout->payout_id)) {
                $payout->payout_id = static::generatePayoutId();
            }
        });
    }

    public function influencerProfile()
    {
        return $this->belongsTo(InfluencerProfile::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function approve($approvedBy, $notes = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => $approvedBy,
            'admin_notes' => $notes,
        ]);
    }

    public function reject($rejectedBy, $reason)
    {
        $this->update([
            'status' => 'cancelled',
            'approved_by' => $rejectedBy,
            'rejection_reason' => $reason,
            'processed_at' => now(),
        ]);

        // Return commission back to influencer
        $this->influencerProfile->increment('pending_commission', $this->amount);
    }

    public function markAsProcessing($processedBy)
    {
        $this->update([
            'status' => 'processing',
            'processed_at' => now(),
            'processed_by' => $processedBy,
        ]);
    }

    public function markAsCompleted($transactionId = null)
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'external_transaction_id' => $transactionId,
        ]);

        // Update influencer profile
        $this->influencerProfile->payCommission($this->amount);
    }

    public function markAsFailed($reason = null)
    {
        $this->update([
            'status' => 'failed',
            'rejection_reason' => $reason,
        ]);

        // Return commission back to influencer
        $this->influencerProfile->increment('pending_commission', $this->amount);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending Approval',
            'approved' => 'Approved',
            'processing' => 'Processing',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'cancelled' => 'Cancelled',
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public function getFormattedAmountAttribute()
    {
        return '₹' . number_format($this->amount, 2);
    }

    public static function generatePayoutId()
    {
        do {
            $id = 'PO' . date('Ymd') . strtoupper(Str::random(6));
        } while (static::where('payout_id', $id)->exists());

        return $id;
    }

    public static function createPayout($influencerProfile, $amount, $paymentMethod, $paymentDetails)
    {
        // Deduct from pending commission
        $influencerProfile->decrement('pending_commission', $amount);

        return static::create([
            'influencer_profile_id' => $influencerProfile->id,
            'amount' => $amount,
            'payment_method' => $paymentMethod,
            'payment_details' => $paymentDetails,
            'status' => 'pending',
            'requested_at' => now(),
        ]);
    }
} 