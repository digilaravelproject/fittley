<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_type',
        'post_id',
        'parent_id',
        'content',
        'likes_count',
        'is_active',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'post_id' => 'integer',
        'parent_id' => 'integer',
        'likes_count' => 'integer',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Scope for FitInsight comments only.
     */
    public function scopeForFitInsight($query)
    {
        return $query->where('post_type', 'fit_insight_video');
    }

    public function post()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id')->orderBy('created_at', 'asc');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeReplies($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Methods
    public function incrementLikes()
    {
        $this->increment('likes_count');
    }

    public function decrementLikes()
    {
        $this->decrement('likes_count');
    }

    // Accessors
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsReplyAttribute()
    {
        return !is_null($this->parent_id);
    }
}