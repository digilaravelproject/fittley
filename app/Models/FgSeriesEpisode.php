<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FgSeriesEpisode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fg_series_id',
        'title',
        'slug',
        'description',
        'episode_number',
        'duration_minutes',
        'video_type',
        'video_url',
        'video_file_path',
        'is_published',
    ];

    protected $casts = [
        'fg_series_id' => 'integer',
        'episode_number' => 'integer',
        'duration_minutes' => 'integer',
        'is_published' => 'boolean',
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'episode_number';
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($episode) {
            if (empty($episode->slug)) {
                $episode->slug = Str::slug($episode->title);
            }
        });

        static::updating(function ($episode) {
            if ($episode->isDirty('title') && empty($episode->slug)) {
                $episode->slug = Str::slug($episode->title);
            }
        });

        static::created(function ($episode) {
            $episode->series->updateEpisodeCount();
        });

        static::deleted(function ($episode) {
            $episode->series->updateEpisodeCount();
        });
    }

    public function series()
    {
        return $this->belongsTo(FgSeries::class, 'fg_series_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByEpisodeNumber($query, $episodeNumber)
    {
        return $query->where('episode_number', $episodeNumber);
    }

    public function getVideoUrlAttribute($value)
    {
        if ($this->video_type === 'upload' && $this->video_file_path) {
            return asset('storage/app/public/' . $this->video_file_path);
        }
        return $value;
    }

    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_minutes) {
            return null;
        }
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        
        return $minutes . 'm';
    }
}
