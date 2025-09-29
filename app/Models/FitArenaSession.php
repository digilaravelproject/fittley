<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class FitArenaSession extends Model
{
    use HasFactory;

    protected $table = 'fitarena_sessions';

    protected $fillable = [
        'event_id',
        'stage_id',
        'category_id',
        'sub_category_id',
        'title',
        'description',
        'speakers',
        'scheduled_start',
        'scheduled_end',
        'actual_start',
        'actual_end',
        'status',
        'session_type',
        'recording_url',
        'recording_enabled',
        'recording_status',
        'recording_duration',
        'recording_file_size',
        'viewer_count',
        'peak_viewers',
        'materials_url',
        'replay_available',
    ];

    protected $casts = [
        'event_id' => 'integer',
        'stage_id' => 'integer',
        'category_id' => 'integer',
        'sub_category_id' => 'integer',
        'speakers' => 'array',
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
        'recording_enabled' => 'boolean',
        'recording_duration' => 'integer',
        'recording_file_size' => 'integer',
        'viewer_count' => 'integer',
        'peak_viewers' => 'integer',
        'replay_available' => 'boolean',
    ];

    /**
     * Get the event this session belongs to
     */
    public function event()
    {
        return $this->belongsTo(FitArenaEvent::class, 'event_id');
    }

    /**
     * Get the stage this session belongs to
     */
    public function stage()
    {
        return $this->belongsTo(FitArenaStage::class, 'stage_id');
    }

    /**
     * Get the category this session belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the sub-category this session belongs to
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    /**
     * Scope for live sessions
     */
    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    /**
     * Scope for scheduled sessions
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope for ended sessions
     */
    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    /**
     * Scope for sessions with recordings
     */
    public function scopeWithRecordings($query)
    {
        return $query->where('recording_enabled', true)
                    ->whereNotNull('recording_url')
                    ->where('recording_status', 'completed');
    }

    /**
     * Scope for replay available sessions
     */
    public function scopeReplayAvailable($query)
    {
        return $query->where('replay_available', true);
    }

    /**
     * Check if session is currently live
     */
    public function isLive()
    {
        return $this->status === 'live';
    }

    /**
     * Check if session is scheduled
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if session has ended
     */
    public function hasEnded()
    {
        return $this->status === 'ended';
    }

    /**
     * Check if session was cancelled
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Get session duration in minutes
     */
    public function getScheduledDurationInMinutes()
    {
        return $this->scheduled_start->diffInMinutes($this->scheduled_end);
    }

    /**
     * Get actual session duration if it has ended
     */
    public function getActualDuration()
    {
        if ($this->actual_start && $this->actual_end) {
            return $this->actual_start->diffForHumans($this->actual_end, true);
        }
        return null;
    }

    /**
     * Get actual session duration in minutes
     */
    public function getActualDurationInMinutes()
    {
        if ($this->actual_start && $this->actual_end) {
            return $this->actual_start->diffInMinutes($this->actual_end);
        }
        return null;
    }

    /**
     * Get formatted scheduled duration
     */
    public function getFormattedScheduledDuration()
    {
        $minutes = $this->getScheduledDurationInMinutes();
        
        if ($minutes < 60) {
            return "{$minutes} min";
        }
        
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        
        if ($remainingMinutes === 0) {
            return "{$hours}h";
        }
        
        return "{$hours}h {$remainingMinutes}m";
    }

    /**
     * Get time until session starts
     */
    public function getTimeUntilStart()
    {
        if ($this->isScheduled() && $this->scheduled_start->isFuture()) {
            return $this->scheduled_start->diffForHumans();
        }
        return null;
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
            case 'ended':
                return 'success';
            case 'cancelled':
                return 'secondary';
            default:
                return 'light';
        }
    }

    /**
     * Check if session has a recording
     */
    public function hasRecording()
    {
        return $this->recording_enabled && 
               !empty($this->recording_url) && 
               $this->recording_status === 'completed';
    }

    /**
     * Check if replay is available
     */
    public function isReplayAvailable()
    {
        return $this->replay_available && $this->hasRecording();
    }

    /**
     * Get formatted recording duration
     */
    public function getFormattedRecordingDuration()
    {
        if (!$this->recording_duration) {
            return 'N/A';
        }

        $hours = floor($this->recording_duration / 3600);
        $minutes = floor(($this->recording_duration % 3600) / 60);
        $seconds = $this->recording_duration % 60;

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        }
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    /**
     * Get formatted recording file size
     */
    public function getFormattedRecordingFileSize()
    {
        if (!$this->recording_file_size) {
            return 'N/A';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $size = $this->recording_file_size;
        $unitIndex = 0;

        while ($size >= 1024 && $unitIndex < count($units) - 1) {
            $size /= 1024;
            $unitIndex++;
        }

        return round($size, 2) . ' ' . $units[$unitIndex];
    }

    /**
     * Get speakers as formatted string
     */
    public function getSpeakersListAttribute()
    {
        if (!$this->speakers || !is_array($this->speakers)) {
            return 'TBA';
        }

        $speakerNames = collect($this->speakers)->pluck('name')->filter();
        
        if ($speakerNames->isEmpty()) {
            return 'TBA';
        }

        return $speakerNames->join(', ');
    }

    /**
     * Check if session is happening now
     */
    public function isHappeningNow()
    {
        $now = Carbon::now();
        return $this->scheduled_start <= $now && $this->scheduled_end >= $now;
    }

    /**
     * Check if session is starting soon (within 15 minutes)
     */
    public function isStartingSoon()
    {
        if (!$this->isScheduled()) {
            return false;
        }

        $now = Carbon::now();
        $fifteenMinutesFromNow = $now->copy()->addMinutes(15);
        
        return $this->scheduled_start > $now && $this->scheduled_start <= $fifteenMinutesFromNow;
    }
} 