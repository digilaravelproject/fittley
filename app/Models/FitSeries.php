<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FitSeries extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fg_series';

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
        'is_published'
    ];

    protected $casts = [
        'release_date' => 'date',
        'cost' => 'decimal:2',
        'feedback' => 'decimal:2',
        'is_published' => 'boolean',
        'total_episodes' => 'integer'
    ];

    protected $dates = [
        'release_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the category that owns the series
     */
    public function category()
    {
        return $this->belongsTo(FgCategory::class, 'fg_category_id');
    }

    /**
     * Get the sub category that owns the series
     */
    public function subCategory()
    {
        return $this->belongsTo(FgSubCategory::class, 'fg_sub_category_id');
    }

    /**
     * Get the episodes for the series
     */
    public function episodes()
    {
        return $this->hasMany(FgSeriesEpisode::class, 'fg_series_id');
    }

    /**
     * Get published episodes
     */
    public function publishedEpisodes()
    {
        return $this->episodes()->where('is_published', true);
    }

    /**
     * Scope to get only published series
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the banner image URL
     */
    public function getBannerImageUrlAttribute_old()
    {
        return $this->banner_image_path ? asset('storage/app/public/' . $this->banner_image_path) : null;
    }

    /**
     * Get the trailer URL based on type
     */
    public function getTrailerUrlAttribute($value)
    {
        if ($this->trailer_type === 'youtube') {
            // return $this->trailer_url;
            return $value;
        } elseif ($this->trailer_type === 's3' || $this->trailer_type === 'upload') {
            return $this->trailer_file_path ? asset('storage/app/public/' . $this->trailer_file_path) : null;
        }
        return $value;
    }

    public function getBannerImageUrlAttribute()
    {
        return $this->banner_image_path ? "https://fittelly.com/storage/app/public/" . $this->banner_image_path : null;
    }
}