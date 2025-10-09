<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FiBlog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fi_category_id',
        'author_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image_path',
        'featured_image_alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'social_image_path',
        'social_title',
        'social_description',
        'status',
        'published_at',
        'scheduled_at',
        'views_count',
        'likes_count',
        'shares_count',
        'reading_time',
        'allow_comments',
        'is_featured',
        'is_trending',
        'sort_order',
        'tags',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'scheduled_at' => 'datetime',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'shares_count' => 'integer',
        'reading_time' => 'decimal:2',
        'allow_comments' => 'boolean',
        'is_featured' => 'boolean',
        'is_trending' => 'boolean',
        'sort_order' => 'integer',
        'tags' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            
            // Auto-calculate reading time if not provided
            if (empty($blog->reading_time) && !empty($blog->content)) {
                $blog->reading_time = static::calculateReadingTime($blog->content);
            }
        });
        
        static::updating(function ($blog) {
            if ($blog->isDirty('title') && empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }
            
            // Recalculate reading time if content changed
            if ($blog->isDirty('content')) {
                $blog->reading_time = static::calculateReadingTime($blog->content);
            }
            
            // Auto-set published_at when status changes to published
            if ($blog->isDirty('status') && $blog->status === 'published' && !$blog->published_at) {
                $blog->published_at = now();
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(FiCategory::class, 'fi_category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')->whereNotNull('published_at');
        // return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled')->whereNotNull('scheduled_at');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('fi_category_id', $categoryId);
    }

    public function scopeByAuthor($query, $authorId)
    {
        return $query->where('author_id', $authorId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('excerpt', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%");
        });
    }

    public function scopeOrderByLatest($query)
    {
        return $query->orderBy('published_at', 'desc')->orderBy('created_at', 'desc');
    }

    public function scopeOrderByPopular($query)
    {
        return $query->orderBy('views_count', 'desc')->orderBy('likes_count', 'desc');
    }

    // Accessors
    public function getFeaturedImageUrlAttribute_old()
    {
        return $this->featured_image_path ? asset('storage/app/public/' . $this->featured_image_path) : null;
    }

    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image_path ? "https://fittelly.com/storage/app/public/" . $this->featured_image_path : null;
    }

    public function getSocialImageUrlAttribute()
    {
        return $this->social_image_path ? asset('storage/app/public/' . $this->social_image_path) : $this->featured_image_url;
    }

    public function getPublishedAtFormattedAttribute()
    {
        return $this->published_at ? $this->published_at->format('M d, Y') : null;
    }

    public function getReadingTimeFormattedAttribute()
    {
        if (!$this->reading_time) return null;
        
        $minutes = floor($this->reading_time);
        return $minutes . ' min read';
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'published' => 'success',
            'scheduled' => 'warning',
            'archived' => 'dark',
        ];
        
        return $badges[$this->status] ?? 'secondary';
    }

    public function getExcerptOrContentAttribute()
    {
        return $this->excerpt ?: Str::limit(strip_tags($this->content), 150);
    }

    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    // Helper Methods
    public function isPublished()
    {
        return $this->status === 'published' && $this->published_at && $this->published_at <= now();
    }

    public function isDraft()
    {
        return $this->status === 'draft';
    }

    public function isScheduled()
    {
        return $this->status === 'scheduled' && $this->scheduled_at && $this->scheduled_at > now();
    }

    public function canBePublished()
    {
        return in_array($this->status, ['draft', 'scheduled']);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function incrementLikes()
    {
        $this->increment('likes_count');
    }

    public function incrementShares()
    {
        $this->increment('shares_count');
    }

    // Static Methods
    public static function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $averageWordsPerMinute = 200; // Average reading speed
        return max(1, round($wordCount / $averageWordsPerMinute, 1));
    }

    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: $this->excerpt_or_content;
    }

    public function getSocialTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getSocialDescriptionAttribute($value)
    {
        return $value ?: $this->excerpt_or_content;
    }
}
