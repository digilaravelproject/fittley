<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;
use carbon\carbon;

class FitLiveSession extends Model
{
    use HasFactory;

    protected $table = 'fitlive_sessions';

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'instructor_id',
        'title',
        'description',
        'scheduled_at',
        'started_at',
        'ended_at',
        'status',
        'chat_mode',
        'session_type',
        'livekit_room',
        'hls_url',
        'mp4_path',
        'banner_image',
        'viewer_peak',
        'views_count',
        'shares_count',
        'likes_count',
        'comments_count',
        'visibility',
        'recording_enabled',
        'recording_id',
        'recording_url',
        'recording_status',
        'recording_duration',
        'recording_file_size',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'sub_category_id' => 'integer',
        'instructor_id' => 'integer',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'viewer_peak' => 'integer',
        'recording_enabled' => 'boolean',
        'recording_duration' => 'integer',
        'recording_file_size' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($session) {
            if (empty($session->livekit_room)) {
                $session->livekit_room = 'fitlive.' . Str::random(10);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function chatMessages()
    {
        return $this->hasMany(FitLiveChatMessage::class, 'fitlive_session_id');
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    /**
     * Get the color associated with the session status.
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'live':
                return 'danger';
            case 'scheduled':
                return 'warning';
            case 'ended':
                return 'secondary';
            default:
                return 'light';
        }
    }

    /**
     * Check if the session is currently live.
     */
    public function isLive()
    {
        return $this->status === 'live';
    }

    /**
     * Check if the session is scheduled.
     */
    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    public function isEnded()
    {
        return $this->status === 'ended';
    }

    /**
     * Check if the session has ended and get duration
     */
    public function hasEnded()
    {
        return $this->status === 'ended' && $this->ended_at;
    }

    /**
     * Get session duration if it has ended
     */
    public function getDuration()
    {
        if ($this->started_at && $this->ended_at) {
            return $this->started_at->diffForHumans($this->ended_at, true);
        }
        return null;
    }

    /**
     * Get channel name for streaming
     */
    public function getChannelName()
    {
        return 'fitlive_' . $this->id;
    }

    /**
     * Check if recording is enabled for this session
     */
    public function isRecordingEnabled()
    {
        return $this->recording_enabled;
    }

    /**
     * Check if session has a completed recording
     */
    public function hasRecording()
    {
        return !empty($this->recording_url) && $this->recording_status === 'completed';
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

        $bytes = $this->recording_file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Scope for sessions with recordings
     */
    public function scopeWithRecordings($query)
    {
        return $query->whereNotNull('recording_url')
                    ->where('recording_status', 'completed');
    }

    /**
     * Get the banner image URL
     */
    public function getBannerImageUrlAttribute()
    {
        return $this->banner_image ? asset('storage/app/public/' . $this->banner_image) : null;
    }

    public function scopeToday($query)
    {
        return $query->whereDate('scheduled_at', Carbon::today());
    }

    public function scopeLiveToday($query)
    {
        return $query->whereDate('scheduled_at', Carbon::today());
    }

    public function scopeArchivedToday($query)
    {
        return $query->whereDate('scheduled_at', Carbon::today())
            ->whereTime('scheduled_at', '<', Carbon::now()->format('H:i:s'));
    }
}
