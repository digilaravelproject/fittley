<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FitFlixShorts extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'is_published',
        'is_featured',
        'published_at',
        'slug',
        'video_path',
        'thumbnail_path',
        'file_size',
        'video_format',
        'video_width',
        'video_height',
        'duration',
        'uploaded_by',   // 👈 Add this
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'shares_count' => 'integer',
        'duration' => 'integer',
        'file_size' => 'integer',
        'video_width' => 'integer',
        'video_height' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shorts) {
            if (empty($shorts->slug)) {
                $shorts->slug = Str::slug($shorts->title);
            }
            if ($shorts->is_published && !$shorts->published_at) {
                $shorts->published_at = now();
            }
        });

        static::updating(function ($shorts) {
            if ($shorts->isDirty('title') && empty($shorts->slug)) {
                $shorts->slug = Str::slug($shorts->title);
            }
            if ($shorts->is_published && !$shorts->published_at) {
                $shorts->published_at = now();
            }
        });

    }

    /**
     * Likes for this short
     */
    public function likes()
    {
        return $this->morphMany(PostLike::class, 'post', 'post_type', 'post_id')
                    ->where('post_type', 'fit_flix_video');
    }
    
    /**
     * Relationship with category
     */
    public function category()
    {
        return $this->belongsTo(FitFlixShortsCategory::class, 'category_id');
    }

    /**
     * Relationship with uploader
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Scope for published shorts
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for featured shorts
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for ordering by latest
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope for ordering by views
     */
    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    /**
     * Scope for category filter
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('meta_keywords', 'like', "%{$search}%");
        });
    }

    /**
     * Get video URL
     */
    public function getVideoUrlAttribute()
    {
        if ($this->video_path && Storage::disk('public')->exists($this->video_path)) {
            return Storage::disk('public')->url($this->video_path);
        }
        return null;
    }

    /**
     * Get thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail_path && Storage::disk('public')->exists($this->thumbnail_path)) {
            return Storage::disk('public')->url($this->thumbnail_path);
        }
        return null;
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return 'Unknown';
        }

        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $unit = 0;

        while ($size >= 1024 && $unit < count($units) - 1) {
            $size /= 1024;
            $unit++;
        }

        return round($size, 2) . ' ' . $units[$unit];
    }

    /**
     * Check if the video is vertical (shorts format)
     */
    public function getIsVerticalAttribute()
    {
        return $this->video_height > $this->video_width;
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
} 