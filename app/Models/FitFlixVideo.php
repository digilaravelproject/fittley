<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitFlixVideo extends Model
{
    use HasFactory;

    protected $table = 'fit_flix_shorts';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'uploaded_by',
        'video_path',
        'thumbnail_path',
        'duration',
        'file_size',
        'video_format',
        'video_width',
        'video_height',
        'views_count',
        'likes_count',
        'shares_count',
        'is_published',
        'is_featured',
        'published_at',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'sequence_order',
        'is_active'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'shares_count' => 'integer',
        'duration' => 'integer',
        'file_size' => 'integer',
        'video_width' => 'integer',
        'video_height' => 'integer',
        'sequence_order' => 'integer'
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the category that owns the video
     */
    public function category()
    {
        return $this->belongsTo(FitFlixShortsCategory::class, 'category_id');
    }

    /**
     * Get the user who uploaded the video
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the likes for this video
     */
    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id')->where('post_type', 'fit_flix_video');
    }

    /**
     * Get the comments for this video
     */
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id')->where('post_type', 'fit_flix_video');
    }

    /**
     * Scope to get only published videos
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope to get featured videos
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the video URL
     */
    public function getVideoUrlAttribute()
    {
        return $this->video_path ? asset('storage/app/public/' . $this->video_path) : null;
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? asset('storage/app/public/' . $this->thumbnail_path) : null;
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->duration) {
            return null;
        }
        
        $minutes = floor($this->duration / 60);
        $seconds = $this->duration % 60;
        
        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    /**
     * Get formatted file size
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) {
            return null;
        }
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->file_size;
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Increment views count
     */
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    /**
     * Increment likes count
     */
    public function incrementLikes()
    {
        $this->increment('likes_count');
    }

    /**
     * Increment shares count
     */
    public function incrementShares()
    {
        $this->increment('shares_count');
    }
}