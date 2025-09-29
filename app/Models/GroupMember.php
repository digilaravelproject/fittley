<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'community_group_id',
        'group_id',
        'user_id',
        'role',
        'status',
        'joined_at',
    ];

    protected $casts = [
        'community_group_id' => 'integer',
        'group_id' => 'integer',
        'user_id' => 'integer',
        'joined_at' => 'datetime',
    ];

    // Relationships
    public function communityGroup()
    {
        return $this->belongsTo(CommunityGroup::class, 'community_group_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeModerators($query)
    {
        return $query->where('role', 'moderator');
    }

    public function scopeMembers($query)
    {
        return $query->where('role', 'member');
    }

    // Methods
    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'joined_at' => now(),
        ]);

        // Update appropriate group member count
        if ($this->community_group_id) {
            $this->communityGroup->increment('members_count');
        }
        if ($this->group_id) {
            $this->group->increment('member_count');
        }
    }

    public function decline()
    {
        $this->update(['status' => 'declined']);
    }

    public function ban()
    {
        if ($this->status === 'approved') {
            if ($this->community_group_id) {
                $this->communityGroup->decrement('members_count');
            }
            if ($this->group_id) {
                $this->group->decrement('member_count');
            }
        }
        
        $this->update(['status' => 'banned']);
    }

    public function promoteToModerator()
    {
        $this->update(['role' => 'moderator']);
    }

    public function promoteToAdmin()
    {
        $this->update(['role' => 'admin']);
    }

    public function demoteToMember()
    {
        $this->update(['role' => 'member']);
    }

    // Accessors
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    public function getIsModeratorAttribute()
    {
        return $this->role === 'moderator';
    }

    public function getIsMemberAttribute()
    {
        return $this->role === 'member';
    }

    public function getCanModerateAttribute()
    {
        return in_array($this->role, ['admin', 'moderator']);
    }
}