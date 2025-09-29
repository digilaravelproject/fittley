<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FgSeries extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fg_category_id',
        'fg_sub_category_id',
        'title',
        'slug',
        'description',
        'language',
        'cost',
        'release_date',
        'total_episodes',
        'feedback',
        'banner_image_path',
        'trailer_type',
        'trailer_url',
        'trailer_file_path',
        'is_published',
    ];

    protected $casts = [
        'fg_category_id' => 'integer',
        'fg_sub_category_id' => 'integer',
        'cost' => 'decimal:2',
        'release_date' => 'date',
        'total_episodes' => 'integer',
        'feedback' => 'decimal:2',
        'is_published' => 'boolean',
    ];

    protected $attributes = [
        'is_published' => false,
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
        
        static::creating(function ($series) {
            if (empty($series->slug)) {
                $series->slug = Str::slug($series->title);
            }
        });

        static::updating(function ($series) {
            if ($series->isDirty('title') && empty($series->slug)) {
                $series->slug = Str::slug($series->title);
            }
        });
    }
    
    public function category()
    {
        return $this->belongsTo(FgCategory::class, 'fg_category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(FgSubCategory::class, 'fg_sub_category_id');
    }

    public function episodes()
    {
        return $this->hasMany(FgSeriesEpisode::class)->orderBy('episode_number');
    }

    public function publishedEpisodes()
    {
        return $this->hasMany(FgSeriesEpisode::class)->where('is_published', true)->orderBy('episode_number');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('fg_category_id', $categoryId);
    }

    public function scopeBySubCategory($query, $subCategoryId)
    {
        return $query->where('fg_sub_category_id', $subCategoryId);
    }

    public function getTrailerUrlAttribute($value)
    {
        if ($this->trailer_type === 'upload' && $this->trailer_file_path) {
            return asset('storage/app/public/' . $this->trailer_file_path);
        }
        return $value;
    }

    public function getBannerImageUrlAttribute()
    {
        if ($this->banner_image_path) {
            return asset('storage/app/public/' . $this->banner_image_path);
        }
        return null;
    }

    public function updateEpisodeCount()
    {
        $this->update(['total_episodes' => $this->episodes()->count()]);
    }
}
