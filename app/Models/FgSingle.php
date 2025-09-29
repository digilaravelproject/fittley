<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FgSingle extends Model
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
        'duration_minutes',
        'feedback',
        'banner_image_path',
        'trailer_type',
        'trailer_url',
        'trailer_file_path',
        'video_type',
        'video_url',
        'video_file_path',
        'is_published',
    ];

    protected $casts = [
        'fg_category_id' => 'integer',
        'fg_sub_category_id' => 'integer',
        'cost' => 'decimal:2',
        'release_date' => 'date',
        'duration_minutes' => 'integer',
        'feedback' => 'decimal:2',
        'is_published' => 'boolean',
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
        
        static::creating(function ($single) {
            if (empty($single->slug)) {
                $single->slug = Str::slug($single->title);
            }
        });

        static::updating(function ($single) {
            if ($single->isDirty('title') && empty($single->slug)) {
                $single->slug = Str::slug($single->title);
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

    public function getVideoUrlAttribute($value)
    {
        if ($this->video_type === 'upload' && $this->video_file_path) {
            return asset('storage/app/public/' . $this->video_file_path);
        }
        return $value;
    }

    public function getTrailerUrlAttribute($value)
    {
        if ($this->trailer_type === 'upload' && $this->trailer_file_path) {
            return asset('storage/app/public/' . $this->trailer_file_path);
        }
        return $value;
    }

    public function getBannerImageUrlAttribute_old()
    {
        if ($this->banner_image_path) {
            return asset('storage/app/public/' . $this->banner_image_path);
        }
        return null;
    }

    public function getBannerImageUrlAttribute()
    {
        return $this->banner_image_path ? "https://purple-gaur-534336.hostingersite.com/storage/app/public/" . $this->banner_image_path : null;
    }

}
