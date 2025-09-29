<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SubCategory extends Model
{
    use HasFactory;

    protected $table = 'sub_categories'; // explicitly map table (good practice)

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'sort_order',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'sort_order' => 'integer',
    ];

    /**
     * Auto-generate slug when creating/updating if not provided
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subCategory) {
            if (empty($subCategory->slug)) {
                $subCategory->slug = Str::slug($subCategory->name);
            }
        });

        static::updating(function ($subCategory) {
            if (empty($subCategory->slug)) {
                $subCategory->slug = Str::slug($subCategory->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug'; // or some other field
    }


    /**
     * Relationship: SubCategory belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Relationship: SubCategory has many FitLiveSessions
     */
    public function fitLiveSessions()
    {
        return $this->hasMany(FitLiveSession::class, 'sub_category_id');
    }
}
