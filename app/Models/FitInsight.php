<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FitInsight extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category_id',
        'author_id',
        'is_published',
        'published_at',
        'views_count',
        'likes_count',
        'comments_count',
        'shares_count',
        'reading_time',
        'meta_data'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'shares_count' => 'integer',
        'reading_time' => 'integer',
        'meta_data' => 'array'
    ];

    protected $attributes = [
        'is_published' => false,
        'views_count' => 0,
        'likes_count' => 0,
        'comments_count' => 0,
        'shares_count' => 0,
        'reading_time' => 0
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($insight) {
            if (empty($insight->slug)) {
                $insight->slug = Str::slug($insight->title);
                
                // Ensure unique slug
                $originalSlug = $insight->slug;
                $counter = 1;
                while (static::where('slug', $insight->slug)->exists()) {
                    $insight->slug = $originalSlug . '-' . $counter;
                    $counter++;
                }
            }
            
            if (empty($insight->published_at) && $insight->is_published) {
                $insight->published_at = now();
            }
        });

        static::updating(function ($insight) {
            if ($insight->isDirty('title') && empty($insight->slug)) {
                $insight->slug = Str::slug($insight->title);
            }
            
            if ($insight->isDirty('is_published') && $insight->is_published && empty($insight->published_at)) {
                $insight->published_at = now();
            }
        });
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'fit_insight_tags');
    }

    // Accessors
    public function getFeaturedImageUrlAttribute()
    {
        return $this->featured_image ? asset('storage/app/public/' . $this->featured_image) : null;
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByAuthor($query, $authorId)
    {
        return $query->where('author_id', $authorId);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('excerpt', 'like', '%' . $search . '%')
              ->orWhere('content', 'like', '%' . $search . '%');
        });
    }

    // Helper methods
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getStatusDisplayAttribute()
    {
        return $this->is_published ? 'Published' : 'Draft';
    }
}
