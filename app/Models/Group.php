<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'groups';

    protected $fillable = [
        'name',
        'description',
        'image',
        'creator_id',
        'category_id',
        'is_private',
        'is_active',
        'max_members',
        'member_count',
        'last_activity_at',
        'last_message_at',
        'privacy'
    ];

    protected $casts = [
        'is_private' => 'boolean',
        'is_active' => 'boolean',
        'max_members' => 'integer',
        'member_count' => 'integer',
        'last_activity_at' => 'datetime',
        'last_message_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function category()
    {
        return $this->belongsTo(CommunityCategory::class, 'category_id');
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function activeMembers()
    {
        return $this->hasMany(GroupMember::class)->where('is_active', true);
    }

    public function messages()
    {
        return $this->hasMany(GroupMessage::class, 'group_id');
    }

    public function latestMessage()
    {
        return $this->hasOne(GroupMessage::class, 'group_id')->latest();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_private', false);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_private', true);
    }

    public function isMember($userId)
    {
        return $this->members()->where('user_id', $userId)->where('is_active', true)->exists();
    }

    public function isCreator($userId)
    {
        return $this->creator_id == $userId;
    }

    public function canJoin()
    {
        return $this->max_members === null || $this->member_count < $this->max_members;
    }

    public function incrementMemberCount()
    {
        $this->increment('member_count');
        $this->touch('last_activity_at');
    }

    public function decrementMemberCount()
    {
        $this->decrement('member_count');
        $this->touch('last_activity_at');
    }
}