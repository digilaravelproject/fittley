<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CommunityPost extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'community_category_id',
        'community_group_id',
        'content',
        'images',
        'likes_count',
        'comments_count',
        'shares_count',
        'is_achievement',
        'is_challenge',
        'visibility',
        'is_active',
        'is_flagged',
        'flagged_at',
        'flag_reason',
        'flagged_by',
        'is_featured',
        'is_published',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'community_category_id' => 'integer',
        'community_group_id' => 'integer',
        'images' => 'array',
        'likes_count' => 'integer',
        'comments_count' => 'integer',
        'shares_count' => 'integer',
        'is_achievement' => 'boolean',
        'is_challenge' => 'boolean',
        'is_active' => 'boolean',
        'is_flagged' => 'boolean',
        'flagged_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'flagged_by' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(CommunityCategory::class, 'community_category_id');
    }

    public function group()
    {
        return $this->belongsTo(CommunityGroup::class, 'community_group_id');
    }

    public function likes()
    {
        return $this->morphMany(PostLike::class, 'post');
    }

    public function comments()
    {
        return $this->morphMany(PostComment::class, 'post')->whereNull('parent_id')->orderBy('created_at', 'desc');
    }

    public function allComments()
    {
        return $this->morphMany(PostComment::class, 'post');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('community_category_id', $categoryId);
    }

    public function scopeByGroup($query, $groupId)
    {
        return $query->where('community_group_id', $groupId);
    }

    public function scopeAchievements($query)
    {
        return $query->where('is_achievement', true);
    }

    public function scopeChallenges($query)
    {
        return $query->where('is_challenge', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('visibility', 'public')
              ->orWhere('user_id', $userId)
              ->orWhere(function ($q2) use ($userId) {
                  $q2->where('visibility', 'friends')
                     ->whereHas('user.friends', function ($q3) use ($userId) {
                         $q3->where('friend_id', $userId)
                            ->where('status', 'accepted');
                     });
              });
        });
    }

    // Methods
    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function incrementLikes()
    {
        $this->increment('likes_count');
    }

    public function decrementLikes()
    {
        $this->decrement('likes_count');
    }

    public function incrementComments()
    {
        $this->increment('comments_count');
    }

    public function decrementComments()
    {
        $this->decrement('comments_count');
    }

    public function incrementShares()
    {
        $this->increment('shares_count');
    }

    // Accessors
    public function getImageUrlsAttribute()
    {
        if (!$this->images) return [];
        
        return collect($this->images)->map(function ($image) {
            return asset('storage/app/public/' . $image);
        })->toArray();
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}