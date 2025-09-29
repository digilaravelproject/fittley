<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FitDocEpisode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fit_doc_id',
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
        'episode_number' => 'integer',
        'duration_minutes' => 'integer',
        'is_published' => 'boolean',
    ];

    protected $attributes = [
        'is_published' => false,
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($episode) {
            if (empty($episode->slug)) {
                $episode->slug = Str::slug($episode->title);
            }
            
            // Update parent series episode count
            $episode->fitDoc->updateEpisodeCount();
        });

        static::updated(function ($episode) {
            $episode->fitDoc->updateEpisodeCount();
        });

        static::deleting(function ($episode) {
            // Delete associated video file
            if ($episode->video_file_path && Storage::exists($episode->video_file_path)) {
                Storage::delete($episode->video_file_path);
            }
        });

        static::deleted(function ($episode) {
            $episode->fitDoc->updateEpisodeCount();
        });
    }

    // Relationships
    public function fitDoc()
    {
        return $this->belongsTo(FitDoc::class);
    }

    // Accessor methods
    public function getVideoUrlAttribute()
    {
        if ($this->video_type === 'upload' && $this->video_file_path) {
            return asset('storage/app/public/' . $this->video_file_path);
        }
        return $this->attributes['video_url'] ?? null;
    }

    public function getFormattedDurationAttribute()
    {
        if (!$this->duration_minutes) return null;
        
        $hours = floor($this->duration_minutes / 60);
        $minutes = $this->duration_minutes % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . $minutes . 'm';
        }
        return $minutes . 'm';
    }

    public function getEpisodeDisplayAttribute()
    {
        return 'Episode ' . $this->episode_number;
    }

    public function getStatusDisplayAttribute()
    {
        return $this->is_published ? 'Published' : 'Draft';
    }

    // Scope methods
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByFitDoc($query, $fitDocId)
    {
        return $query->where('fit_doc_id', $fitDocId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('episode_number');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    // Helper methods
    public function canBeDeleted()
    {
        return true;
    }

    public function getNextEpisodeNumber()
    {
        $maxEpisode = static::where('fit_doc_id', $this->fit_doc_id)->max('episode_number');
        return $maxEpisode ? $maxEpisode + 1 : 1;
    }
}
