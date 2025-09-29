<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FitArenaStage extends Model
{
    use HasFactory;

    protected $table = 'fitarena_stages';

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'color_code',
        'capacity',
        'livekit_room',
        'stream_key',
        'rtmp_url',
        'hls_url',
        'status',
        'is_primary',
        'sort_order',
    ];

    protected $casts = [
        'event_id' => 'integer',
        'capacity' => 'integer',
        'is_primary' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($stage) {
            if (empty($stage->livekit_room)) {
                $stage->livekit_room = 'fitarena.' . Str::random(10);
            }
            
            if (empty($stage->stream_key)) {
                $stage->stream_key = 'stage_' . Str::random(16);
            }
        });

        static::created(function ($stage) {
            // If this is marked as primary, unmark other primary stages in the same event
            if ($stage->is_primary) {
                static::where('event_id', $stage->event_id)
                    ->where('id', '!=', $stage->id)
                    ->update(['is_primary' => false]);
            }
        });

        static::updating(function ($stage) {
            // If this is being marked as primary, unmark other primary stages in the same event
            if ($stage->is_primary && $stage->isDirty('is_primary')) {
                static::where('event_id', $stage->event_id)
                    ->where('id', '!=', $stage->id)
                    ->update(['is_primary' => false]);
            }
        });
    }

    /**
     * Get the event this stage belongs to
     */
    public function event()
    {
        return $this->belongsTo(FitArenaEvent::class, 'event_id');
    }

    /**
     * Get all sessions for this stage
     */
    public function sessions()
    {
        return $this->hasMany(FitArenaSession::class, 'stage_id')->orderBy('scheduled_start');
    }

    /**
     * Get current live session for this stage
     */
    public function currentLiveSession()
    {
        return $this->hasOne(FitArenaSession::class, 'stage_id')->where('status', 'live');
    }

    /**
     * Get next scheduled session for this stage
     */
    public function nextSession()
    {
        return $this->hasOne(FitArenaSession::class, 'stage_id')
            ->where('status', 'scheduled')
            ->where('scheduled_start', '>', now())
            ->orderBy('scheduled_start');
    }

    /**
     * Scope for live stages
     */
    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    /**
     * Scope for scheduled stages
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope for primary stages
     */
    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    /**
     * Check if stage is currently live
     */
    public function isLive()
    {
        return $this->status === 'live';
    }

    /**
     * Check if stage is scheduled
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if stage has ended
     */
    public function hasEnded()
    {
        return $this->status === 'ended';
    }

    /**
     * Check if stage is on break
     */
    public function isOnBreak()
    {
        return $this->status === 'break';
    }

    /**
     * Get the status color for UI
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'live':
                return 'danger';
            case 'scheduled':
                return 'warning';
            case 'break':
                return 'info';
            case 'ended':
                return 'secondary';
            default:
                return 'light';
        }
    }

    /**
     * Get channel name for streaming
     */
    public function getChannelName()
    {
        return 'fitarena_stage_' . $this->id;
    }

    /**
     * Get current viewer count
     */
    public function getCurrentViewerCount()
    {
        $liveSession = $this->currentLiveSession;
        return $liveSession ? $liveSession->viewer_count : 0;
    }

    /**
     * Get total sessions count for this stage
     */
    public function getTotalSessionsCount()
    {
        return $this->sessions()->count();
    }

    /**
     * Get completed sessions count for this stage
     */
    public function getCompletedSessionsCount()
    {
        return $this->sessions()->where('status', 'ended')->count();
    }

    /**
     * Get stage utilization percentage
     */
    public function getUtilizationPercentage()
    {
        $total = $this->getTotalSessionsCount();
        $completed = $this->getCompletedSessionsCount();
        
        if ($total === 0) {
            return 0;
        }
        
        return round(($completed / $total) * 100, 1);
    }
} 