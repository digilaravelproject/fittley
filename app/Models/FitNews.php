<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FitNews extends Model
{
    protected $table = 'fit_news';
    
    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'status',
        'scheduled_at',
        'started_at',
        'ended_at',
        'channel_name',
        'streaming_config',
        'viewer_count',
        'recording_enabled',
        'recording_url',
        'recording_id',
        'views_count',
        'likes_count',
        'comments_count',
        'shares_count',
        'recording_status',
        'recording_duration',
        'recording_file_size',
        'created_by'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'streaming_config' => 'array',
        'recording_enabled' => 'boolean',
        'recording_duration' => 'integer',
        'recording_file_size' => 'integer',
    ];

    /**
     * Get the user who created this news stream
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if the stream is currently live
     */
    public function isLive(): bool
    {
        return $this->status === 'live';
    }

    /**
     * Check if the stream is scheduled
     */
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if the stream has ended
     */
    public function hasEnded(): bool
    {
        return $this->status === 'ended';
    }

    /**
     * Determine whether this FitNews stream has a completed recording.
     */
    public function hasRecording(): bool
    {
        return !empty($this->recording_url) && $this->recording_status === 'completed';
    }

    /**
     * Query scope: only FitNews records that have completed recordings.
     */
    public function scopeWithRecordings($query)
    {
        return $query->whereNotNull('recording_url')
                     ->where('recording_status', 'completed');
    }

    /**
     * Query scope: only published FitNews records.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get formatted duration if stream has ended
     */
    public function getDuration(): ?string
    {
        if ($this->started_at && $this->ended_at) {
            $duration = $this->started_at->diffInMinutes($this->ended_at);
            return $duration . ' minutes';
        }
        return null;
    }

    /**
     * Generate unique channel name
     */
    public function generateChannelName(): string
    {
        return 'fitnews_' . $this->id . '_' . time();
    }

    /**
     * Get a human-readable recording duration (HH:MM:SS or MM:SS).
     */
    public function getFormattedRecordingDuration(): string
    {
        if (!$this->recording_duration) {
            return 'N/A';
        }

        $hours   = floor($this->recording_duration / 3600);
        $minutes = floor(($this->recording_duration % 3600) / 60);
        $seconds = $this->recording_duration % 60;

        return $hours > 0
            ? sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds)
            : sprintf('%02d:%02d', $minutes, $seconds);
    }

    /**
     * Get a human-readable file-size string for the recording.
     */
    public function getFormattedRecordingFileSize(): string
    {
        if (!$this->recording_file_size) {
            return 'N/A';
        }

        $bytes = $this->recording_file_size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = 0;
        while ($bytes > 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute_old()
    {
        return $this->thumbnail ? asset('storage/app/public/' . $this->thumbnail) : null;
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail ? "https://purple-gaur-534336.hostingersite.com/storage/app/public/" . $this->thumbnail : null;
    }
}
