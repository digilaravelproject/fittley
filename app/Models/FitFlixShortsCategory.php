<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FitFlixShortsCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
        'banner_image_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot the model
     */
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

    /**
     * Relationship with shorts
     */
    public function shorts()
    {
        return $this->hasMany(FitFlixShorts::class, 'category_id');
    }

    /**
     * Get published shorts
     */
    public function publishedShorts()
    {
        return $this->shorts()->where('is_published', true);
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get banner image URL
     */
    public function getBannerImageUrlAttribute()
    {
        if ($this->banner_image_path && Storage::disk('public')->exists($this->banner_image_path)) {
            return Storage::disk('public')->url($this->banner_image_path);
        }
        return null;
    }

    /**
     * Check if category can be deleted
     */
    public function canBeDeleted()
    {
        return $this->shorts()->count() === 0;
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
} 