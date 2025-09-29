<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FitArenaEvent extends Model
{
    use HasFactory;

    protected $table = 'fitarena_events';

    protected $fillable = [
        'title',
        'description',
        'slug',
        'start_date',
        'end_date',
        'banner_image',
        'logo',
        'location',
        'status',
        'visibility',
        'dvr_enabled',
        'dvr_hours',
        'organizers',
        'schedule_overview',
        'expected_viewers',
        'peak_viewers',       
        'views_count',
        'likes_count',
        'comments_count',
        'shares_count',
        'is_featured',
        'event_type',
        'rules',
        'prizes',
        'sponsors',
        'max_participants',
        'instructor_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'dvr_enabled' => 'boolean',
        'dvr_hours' => 'integer',
        'organizers' => 'array',
        'expected_viewers' => 'integer',
        'peak_viewers' => 'integer',
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title);
            }
        });

        static::updating(function ($event) {
            // Auto-update status based on dates
            $now = Carbon::now()->toDateString();
            
            if ($event->start_date > $now) {
                $event->status = 'upcoming';
            } elseif ($event->start_date <= $now && $event->end_date >= $now) {
                if ($event->status === 'upcoming') {
                    $event->status = 'live';
                }
            } elseif ($event->end_date < $now) {
                $event->status = 'ended';
            }
        });
    }

    /**
     * Get the stages for this event
     */
    public function stages()
    {
        return $this->hasMany(FitArenaStage::class, 'event_id')->orderBy('sort_order');
    }

    /**
     * Get all sessions for this event
     */
    public function sessions()
    {
        return $this->hasMany(FitArenaSession::class, 'event_id');
    }

    /**
     * Get the primary stage for this event
     */
    public function primaryStage()
    {
        return $this->hasOne(FitArenaStage::class, 'event_id')->where('is_primary', true);
    }

    /**
     * Scope for upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming');
    }

    /**
     * Scope for live events
     */
    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    /**
     * Scope for ended events
     */
    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    /**
     * Scope for public events
     */
    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    /**
     * Scope for featured events
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Check if event is currently live
     */
    public function isLive()
    {
        return $this->status === 'live';
    }

    /**
     * Check if event is upcoming
     */
    public function isUpcoming()
    {
        return $this->status === 'upcoming';
    }

    /**
     * Check if event has ended
     */
    public function hasEnded()
    {
        return $this->status === 'ended';
    }

    /**
     * Get event duration in days
     */
    public function getDurationInDays()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Get days remaining until event starts
     */
    public function getDaysUntilStart()
    {
        if ($this->isUpcoming()) {
            return Carbon::now()->diffInDays($this->start_date);
        }
        return 0;
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDuration()
    {
        $days = $this->getDurationInDays();
        
        if ($days === 1) {
            return '1 Day';
        }
        
        return "{$days} Days";
    }

    /**
     * Get the status color for UI
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'live':
                return 'danger';
            case 'upcoming':
                return 'warning';
            case 'ended':
                return 'secondary';
            default:
                return 'light';
        }
    }

    /**
     * Get current live sessions count
     */
    public function getCurrentLiveSessionsCount()
    {
        return $this->sessions()->where('status', 'live')->count();
    }

    /**
     * Get total sessions count
     */
    public function getTotalSessionsCount()
    {
        return $this->sessions()->count();
    }

    /**
     * Check if DVR is available for this event
     */
    public function isDvrAvailable()
    {
        if (!$this->dvr_enabled) {
            return false;
        }

        if ($this->hasEnded()) {
            $dvrCutoff = Carbon::parse($this->end_date)->addHours($this->dvr_hours);
            return Carbon::now()->lessThan($dvrCutoff);
        }

        return true;
    }

    /**
     * Get the route key name for the model
     */
    public function getRouteKeyName()
    {
        // Use slug for public routes, ID for admin routes
        if (request()->is('admin/*')) {
            return 'id';
        }
        return 'slug';
    }
} 