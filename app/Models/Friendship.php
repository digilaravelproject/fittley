<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'friend_id',
        'status',
        'accepted_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'friend_id' => 'integer',
        'accepted_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    public function scopeBlocked($query)
    {
        return $query->where('status', 'blocked');
    }

    public function scopeBetweenUsers($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where('user_id', $userId1)->where('friend_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('user_id', $userId2)->where('friend_id', $userId1);
        });
    }

    // Methods
    public function accept()
    {
        $this->update([
            'status' => 'accepted',
            'accepted_at' => now(),
        ]);
    }

    public function decline()
    {
        $this->update(['status' => 'declined']);
    }

    public function block()
    {
        $this->update(['status' => 'blocked']);
    }

    // Static Methods
    public static function areFriends($userId1, $userId2)
    {
        return static::betweenUsers($userId1, $userId2)->accepted()->exists();
    }

    public static function hasPendingRequest($userId1, $userId2)
    {
        return static::betweenUsers($userId1, $userId2)->pending()->exists();
    }

    public static function sendFriendRequest($senderId, $receiverId)
    {
        // Check if friendship already exists
        $existing = static::betweenUsers($senderId, $receiverId)->first();
        
        if ($existing) {
            return $existing;
        }

        return static::create([
            'user_id' => $senderId,
            'friend_id' => $receiverId,
            'status' => 'pending',
        ]);
    }
} 