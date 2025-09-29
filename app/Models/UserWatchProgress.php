<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWatchProgress extends Model
{
    use HasFactory;

    protected $table = 'user_watch_progress';

    protected $fillable = [
        'user_id',
        'watchable_type',
        'watchable_id',
        'progress_seconds',
        'duration_seconds',
        'progress_percentage',
        'completed',
        'last_watched_at'
    ];

    protected $casts = [
        'progress_percentage' => 'decimal:2',
        'completed' => 'boolean',
        'last_watched_at' => 'datetime'
    ];

    /**
     * Get the user that owns the watch progress.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the watchable model (FitDoc, FitGuide, etc.).
     */
    public function watchable()
    {
        return $this->morphTo();
    }

    /**
     * Update progress and calculate percentage.
     */
    public function updateProgress(int $progressSeconds, int $durationSeconds = null)
    {
        if ($durationSeconds) {
            $this->duration_seconds = $durationSeconds;
        }

        $this->progress_seconds = $progressSeconds;
        
        if ($this->duration_seconds > 0) {
            $this->progress_percentage = min(100, ($progressSeconds / $this->duration_seconds) * 100);
            $this->completed = $this->progress_percentage >= 90; // Consider 90% as completed
        }

        $this->last_watched_at = now();
        $this->save();
    }

    /**
     * Scope for incomplete items.
     */
    public function scopeIncomplete($query)
    {
        return $query->where('completed', false)->where('progress_seconds', '>', 0);
    }

    /**
     * Scope for completed items.
     */
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    /**
     * Scope for recently watched.
     */
    public function scopeRecentlyWatched($query, $days = 30)
    {
        return $query->where('last_watched_at', '>=', now()->subDays($days));
    }
}
