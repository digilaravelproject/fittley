<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_one_id',
        'user_two_id',
        'message_count',
        'message_limit',
        'is_accepted',
        'accepted_at',
        'last_message_at',
    ];

    protected $casts = [
        'user_one_id' => 'integer',
        'user_two_id' => 'integer',
        'message_count' => 'integer',
        'message_limit' => 'integer',
        'is_accepted' => 'boolean',
        'accepted_at' => 'datetime',
        'last_message_at' => 'datetime',
    ];

    // Relationships
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages_old()
    {
        return $this->hasMany(DirectMessage::class, function ($query) {
            $query->betweenUsers($this->user_one_id, $this->user_two_id);
        });
    }

    public function messages()
    {
        return $this->hasMany(DirectMessage::class, 'id')
            ->where(function ($q) {
                $q->betweenUsers($this->user_one_id, $this->user_two_id);
            });
    }


    public function latestMessage_old()
    {
        return $this->hasOne(DirectMessage::class, function ($query) {
            $query->betweenUsers($this->user_one_id, $this->user_two_id)->latest();
        });
    }

    public function latestMessage()
    {
        return $this->hasOne(DirectMessage::class, 'conversation_id')->latestOfMany();
    }


    public function lastMessage_old()
    {
        return $this->hasOne(DirectMessage::class, function ($query) {
            $query->betweenUsers($this->user_one_id, $this->user_two_id)->latest();
        });
    }

    public function lastMessage_oldd()
    {
        return $this->hasOne(DirectMessage::class, 'conversation_id')->latestOfMany();
    }

    public function lastMessage()
    {
        return $this->hasOne(DirectMessage::class, 'sender_id')
            ->where(function ($q) {
                $q->betweenUsers($this->user_one_id, $this->user_two_id);
            })
            ->latest();
    }
    
    public function participants_old()
    {
        // This is a virtual relationship for easier loading
        // We'll handle this in the controller by loading userOne and userTwo
        return collect([$this->userOne, $this->userTwo])->filter();
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'conversation_user', 'conversation_id', 'user_id');
    }


    // Scopes
    public function scopeAccepted($query)
    {
        return $query->where('is_accepted', true);
    }

    public function scopePending($query)
    {
        return $query->where('is_accepted', false);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_one_id', $userId)->orWhere('user_two_id', $userId);
    }

    public function scopeBetweenUsers($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where('user_one_id', $userId1)->where('user_two_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('user_one_id', $userId2)->where('user_two_id', $userId1);
        });
    }

    // Methods
    public function getOtherUser($userId)
    {
        return $userId == $this->user_one_id ? $this->userTwo : $this->userOne;
    }

    public function incrementMessageCount()
    {
        $this->increment('message_count');
        $this->touch('last_message_at');
    }

    public function canSendMessage($senderId)
    {
        // If conversation is accepted, unlimited messages
        if ($this->is_accepted) {
            return true;
        }

        // Check if users are friends
        if (Friendship::areFriends($this->user_one_id, $this->user_two_id)) {
            return true;
        }

        // Check message limit for non-friends
        return $this->message_count < $this->message_limit;
    }

    public function accept()
    {
        $this->update([
            'is_accepted' => true,
            'accepted_at' => now(),
        ]);
    }

    public function updateLastMessageTime()
    {
        $this->touch('last_message_at');
    }

    // Static Methods
    public static function getOrCreateConversation($userId1, $userId2)
    {
        // Ensure consistent ordering
        if ($userId1 > $userId2) {
            [$userId1, $userId2] = [$userId2, $userId1];
        }

        return static::firstOrCreate([
            'user_one_id' => $userId1,
            'user_two_id' => $userId2,
        ], [
            'message_limit' => config('community.default_message_limit', 5),
        ]);
    }

    // Accessors
    public function getUnreadCountForUserAttribute()
    {
        // This should be calculated dynamically based on the requesting user
        return 0; // Placeholder - would need to be calculated in controller
    }

    public function getLastMessageTimeAgoAttribute()
    {
        return $this->last_message_at ? $this->last_message_at->diffForHumans() : null;
    }

    public function getUnreadCount($userId)
    {
        return $this->messages()
            ->where('sender_id', '!=', $userId)
            ->where('is_read', false)
            ->count();
    }

    public function getOtherParticipant($userId)
    {
        if ($this->user_one_id == $userId) {
            return $this->userTwo;
        } elseif ($this->user_two_id == $userId) {
            return $this->userOne;
        }
        return null;
    }

    public function hasParticipant($userId)
    {
        return $this->user_one_id == $userId || $this->user_two_id == $userId;
    }
}