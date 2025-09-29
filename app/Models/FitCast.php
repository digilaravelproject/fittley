<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FitCast extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fit_casts';

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'video_url',
        'duration',
        'category_id',
        'instructor_id',
        'is_active',
        'is_featured',
        'views_count',
        'likes_count',
        'published_at'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id')->where('post_type', 'fit_cast');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id')->where('post_type', 'fit_cast');
    }

    public function watchProgress()
    {
        return $this->hasMany(UserWatchProgress::class, 'content_id')->where('content_type', 'fit_cast');
    }

    public function watchlist()
    {
        return $this->hasMany(UserWatchlist::class, 'content_id')->where('content_type', 'fit_cast');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }
}