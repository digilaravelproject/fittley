<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FittalkSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'user_id',
        'session_title',
        'session_description',
        'session_type',
        'status',
        'chat_rate_per_minute',
        'call_rate_per_minute',
        'free_minutes',
        'duration_minutes',
        'total_amount',
        'scheduled_at',
        'started_at',
        'ended_at',
        'agora_channel',
        'recording_url',
        'payment_status',
        'payment_intent_id',
    ];

    protected $casts = [
        'instructor_id' => 'integer',
        'user_id' => 'integer',
        'chat_rate_per_minute' => 'decimal:2',
        'call_rate_per_minute' => 'decimal:2',
        'free_minutes' => 'integer',
        'duration_minutes' => 'integer',
        'total_amount' => 'decimal:2',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    // Relationships
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function messages()
    {
        return $this->hasMany(FittalkMessage::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeByInstructor($query, $instructorId)
    {
        return $query->where('instructor_id', $instructorId);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('session_type', $type);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    // Methods
    public function start()
    {
        $this->update([
            'status' => 'active',
            'started_at' => now(),
        ]);

        // Generate Agora channel for voice/video calls
        if (in_array($this->session_type, ['voice_call', 'video_call'])) {
            $agoraService = app(AgoraService::class);
            $this->update([
                'agora_channel' => $agoraService->generateChannelName('fittalk_' . $this->id),
            ]);
        }
    }

    public function end()
    {
        $duration = $this->started_at ? now()->diffInMinutes($this->started_at) : 0;
        
        $this->update([
            'status' => 'completed',
            'ended_at' => now(),
            'duration_minutes' => $duration,
        ]);

        // Calculate and process payment
        $this->processPayment();
    }

    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
        ]);
    }

    protected function processPayment()
    {
        $chargeableMinutes = max(0, $this->duration_minutes - $this->free_minutes);
        
        if ($chargeableMinutes > 0) {
            $rate = $this->session_type === 'chat' ? $this->chat_rate_per_minute : $this->call_rate_per_minute;
            $totalAmount = $chargeableMinutes * $rate;
            
            $this->update([
                'total_amount' => $totalAmount,
            ]);

            // Here you would integrate with payment processor
            // For now, we'll mark as pending
            $this->update(['payment_status' => 'pending']);
        } else {
            $this->update([
                'total_amount' => 0,
                'payment_status' => 'paid', // Free session
            ]);
        }
    }

    public function getAgoraConfig()
    {
        if (!$this->agora_channel) {
            return null;
        }

        $agoraService = app(AgoraService::class);
        
        return [
            'channel' => $this->agora_channel,
            'app_id' => $agoraService->getAppId(),
            'instructor_token' => $agoraService->generateRtcToken($this->agora_channel, $this->instructor_id, 'publisher'),
            'user_token' => $agoraService->generateRtcToken($this->agora_channel, $this->user_id, 'subscriber'),
        ];
    }

    public function canStart()
    {
        return $this->status === 'scheduled' && 
               (!$this->scheduled_at || $this->scheduled_at <= now());
    }

    public function canEnd()
    {
        return $this->status === 'active';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    // Accessors
    public function getDurationFormattedAttribute()
    {
        if (!$this->duration_minutes) return '0 min';
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }

    public function getChargeableMinutesAttribute()
    {
        return max(0, $this->duration_minutes - $this->free_minutes);
    }

    public function getRemainingFreeMinutesAttribute()
    {
        if (!$this->started_at || $this->isCompleted()) {
            return $this->free_minutes;
        }
        
        $elapsedMinutes = now()->diffInMinutes($this->started_at);
        return max(0, $this->free_minutes - $elapsedMinutes);
    }
} 