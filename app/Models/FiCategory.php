<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FiCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'banner_image_path',
        'icon',
        'color',
        'sort_order',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
        
        static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    // Relationships
    public function blogs()
    {
        return $this->hasMany(FiBlog::class);
    }

    public function publishedBlogs()
    {
        return $this->hasMany(FiBlog::class)->where('status', 'published')->whereNotNull('published_at');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrderBySort($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Accessors
    public function getBannerImageUrlAttribute()
    {
        return $this->banner_image_path ? asset('storage/app/public/' . $this->banner_image_path) : null;
    }

    public function getBlogsCountAttribute()
    {
        return $this->blogs()->count();
    }

    public function getPublishedBlogsCountAttribute()
    {
        return $this->publishedBlogs()->count();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Helper Methods
    public function canBeDeleted()
    {
        return $this->blogs()->count() === 0;
    }
}
