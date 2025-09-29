<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image_path',
        'icon',
        'color',
        'criteria',
        'type',
        'points',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'criteria' => 'array',
        'points' => 'integer',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($badge) {
            if (empty($badge->slug)) {
                $badge->slug = Str::slug($badge->name);
            }
        });
    }

    // Relationships
    public function userBadges()
    {
        return $this->hasMany(UserBadge::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')->withTimestamps()->withPivot('earned_at', 'achievement_data', 'is_visible');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrderBySort($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Methods
    public function checkAndAwardToUser($userId)
    {
        // Check if user already has this badge
        if ($this->isEarnedByUser($userId)) {
            return false;
        }

        // Check if user meets the criteria
        if ($this->userMeetsCriteria($userId)) {
            return $this->awardToUser($userId);
        }

        return false;
    }

    public function awardToUser($userId, $achievementData = null)
    {
        return UserBadge::create([
            'user_id' => $userId,
            'badge_id' => $this->id,
            'earned_at' => now(),
            'achievement_data' => $achievementData,
        ]);
    }

    public function isEarnedByUser($userId)
    {
        return $this->userBadges()->where('user_id', $userId)->exists();
    }

    protected function userMeetsCriteria($userId)
    {
        if (!$this->criteria || !is_array($this->criteria)) {
            return false;
        }

        $user = User::find($userId);
        if (!$user) return false;

        foreach ($this->criteria as $criterion => $value) {
            switch ($criterion) {
                case 'posts_count':
                    if ($user->communityPosts()->count() < $value) {
                        return false;
                    }
                    break;
                
                case 'likes_received':
                    $likesCount = $user->communityPosts()->sum('likes_count');
                    if ($likesCount < $value) {
                        return false;
                    }
                    break;
                
                case 'comments_made':
                    if ($user->postComments()->count() < $value) {
                        return false;
                    }
                    break;
                
                case 'days_active':
                    $daysActive = $user->created_at->diffInDays(now());
                    if ($daysActive < $value) {
                        return false;
                    }
                    break;
                
                case 'friends_count':
                    $friendsCount = $user->friends()->where('status', 'accepted')->count();
                    if ($friendsCount < $value) {
                        return false;
                    }
                    break;
                
                case 'groups_joined':
                    $groupsCount = $user->groupMemberships()->where('status', 'approved')->count();
                    if ($groupsCount < $value) {
                        return false;
                    }
                    break;
            }
        }

        return true;
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/app/public/' . $this->image_path) : null;
    }

    public function getEarnedCountAttribute()
    {
        return $this->userBadges()->count();
    }
} 