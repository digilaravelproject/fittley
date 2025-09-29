<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FitDoc extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'description',
        'language',
        'cost',
        'release_date',
        'duration_minutes',
        'total_episodes',
        'feedback',
        'banner_image_path',
        'trailer_type',
        'trailer_url',
        'trailer_file_path',
        'video_type',
        'video_url',
        'video_file_path',
        'is_published',
        'is_active',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'release_date' => 'date',
        'duration_minutes' => 'integer',
        'total_episodes' => 'integer',
        'feedback' => 'decimal:2',
        'is_published' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'is_published' => false,
        'is_active' => true,
        'cost' => 0,
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($fitDoc) {
            if (empty($fitDoc->slug)) {
                $fitDoc->slug = Str::slug($fitDoc->title);
                
                // Ensure unique slug
                $originalSlug = $fitDoc->slug;
                $counter = 1;
                while (static::where('slug', $fitDoc->slug)->exists()) {
                    $fitDoc->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
        });

        static::updating(function ($fitDoc) {
            if ($fitDoc->isDirty('title') && empty($fitDoc->slug)) {
                $fitDoc->slug = Str::slug($fitDoc->title);
            }
        });

        static::deleting(function ($fitDoc) {
            // Delete associated files
            if ($fitDoc->banner_image_path && Storage::exists($fitDoc->banner_image_path)) {
                Storage::delete($fitDoc->banner_image_path);
            }
            
            if ($fitDoc->trailer_file_path && Storage::exists($fitDoc->trailer_file_path)) {
                Storage::delete($fitDoc->trailer_file_path);
            }
            
            if ($fitDoc->video_file_path && Storage::exists($fitDoc->video_file_path)) {
                Storage::delete($fitDoc->video_file_path);
            }
        });
    }

    // Relationships
    public function episodes()
    {
        return $this->hasMany(FitDocEpisode::class)->orderBy('episode_number');
    }

    public function publishedEpisodes()
    {
        return $this->hasMany(FitDocEpisode::class)->where('is_published', true)->orderBy('episode_number');
    }

    // Accessor methods
    public function getBannerImageUrlAttribute_old()
    {
        return $this->banner_image_path ? asset('storage/app/public/' . $this->banner_image_path) : null;
    }

    public function getBannerImageUrlAttribute()
    {
        return $this->banner_image_path ? "https://purple-gaur-534336.hostingersite.com/storage/app/public/" . $this->banner_image_path : null;
    }


    public function getTrailerUrlAttribute()
    {
        if ($this->trailer_type === 'upload' && $this->trailer_file_path) {
            return asset('storage/app/public/' . $this->trailer_file_path);
        }
        return $this->attributes['trailer_url'] ?? null;
    }

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

    public function getEpisodesCountAttribute()
    {
        return $this->episodes()->count();
    }

    public function getPublishedEpisodesCountAttribute()
    {
        return $this->publishedEpisodes()->count();
    }

    // Scope methods
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    }

    // Helper methods
    public function updateEpisodeCount()
    {
        if ($this->type === 'series') {
            $this->update(['total_episodes' => $this->episodes()->count()]);
        }
    }

    public function canBeDeleted()
    {
        return true; // No dependencies to check unlike FitGuide
    }

    public function getTypeDisplayAttribute()
    {
        return ucfirst($this->type);
    }

    public function getStatusDisplayAttribute()
    {
        return $this->is_published ? 'Published' : 'Draft';
    }
}
