<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CommunityGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'rules',
        'tags',
        'cover_image',
        'community_category_id',
        'admin_user_id', // optional
        'max_members',   // optional
        'members_count', // optional
        'join_type',     // optional
        'is_active',
    ];


    protected $casts = [
        'community_category_id' => 'integer',
        'admin_user_id' => 'integer',
        'max_members' => 'integer',
        'members_count' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($group) {
            if (empty($group->slug)) {
                $group->slug = Str::slug($group->name);
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    // Relationships
    public function category()
    {
        return $this->belongsTo(CommunityCategory::class, 'community_category_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function activeMembers()
    {
        return $this->hasMany(GroupMember::class)->where('status', 'approved');
    }

    public function posts()
    {
        return $this->hasMany(CommunityPost::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('community_category_id', $categoryId);
    }

    public function scopeOpen($query)
    {
        return $query->where('join_type', 'open');
    }

    // Methods
    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->where('status', 'approved')->exists();
    }

    public function hasPendingRequest($userId)
    {
        return $this->members()->where('user_id', $userId)->where('status', 'pending')->exists();
    }

    public function canJoin($userId)
    {
        if ($this->isMember($userId)) {
            return false;
        }

        if ($this->members_count >= $this->max_members) {
            return false;
        }

        return true;
    }

    public function joinUser($userId)
    {
        if (!$this->canJoin($userId)) {
            return false;
        }

        $status = $this->join_type === 'open' ? 'approved' : 'pending';

        GroupMember::create([
            'community_group_id' => $this->id,
            'user_id' => $userId,
            'status' => $status,
            'joined_at' => $status === 'approved' ? now() : null,
        ]);

        if ($status === 'approved') {
            $this->increment('members_count');
        }

        return true;
    }

    public function removeUser($userId)
    {
        $member = $this->members()->where('user_id', $userId)->first();
        
        if ($member) {
            if ($member->status === 'approved') {
                $this->decrement('members_count');
            }
            $member->delete();
            return true;
        }

        return false;
    }

    // Accessors
    public function getCoverImageUrlAttribute()
    {
        return $this->cover_image ? asset('storage/app/public/' . $this->cover_image) : null;
    }
} 