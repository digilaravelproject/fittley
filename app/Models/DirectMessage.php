<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DirectMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'content',
        'attachments',
        'is_read',
        'read_at',
        'is_deleted_by_sender',
        'is_deleted_by_receiver',
        'message_type',
    ];

    protected $casts = [
        'sender_id' => 'integer',
        'receiver_id' => 'integer',
        'attachments' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_deleted_by_sender' => 'boolean',
        'is_deleted_by_receiver' => 'boolean',
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, function ($query) {
            $query->where(function ($q) {
                $q->where('user_one_id', $this->sender_id)->where('user_two_id', $this->receiver_id);
            })->orWhere(function ($q) {
                $q->where('user_one_id', $this->receiver_id)->where('user_two_id', $this->sender_id);
            });
        });
    }

    // Scopes
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeBetweenUsers($query, $userId1, $userId2)
    {
        return $query->where(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId1)->where('receiver_id', $userId2);
        })->orWhere(function ($q) use ($userId1, $userId2) {
            $q->where('sender_id', $userId2)->where('receiver_id', $userId1);
        });
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->where('is_deleted_by_sender', false);
        })->orWhere(function ($q) use ($userId) {
            $q->where('receiver_id', $userId)->where('is_deleted_by_receiver', false);
        });
    }

    public function scopeByType($query, $type)
    {
        return $query->where('message_type', $type);
    }

    // Methods
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }

    public function deleteForUser($userId)
    {
        if ($userId == $this->sender_id) {
            $this->update(['is_deleted_by_sender' => true]);
        } elseif ($userId == $this->receiver_id) {
            $this->update(['is_deleted_by_receiver' => true]);
        }

        // If deleted by both users, soft delete the message
        if ($this->is_deleted_by_sender && $this->is_deleted_by_receiver) {
            $this->delete();
        }
    }

    // Accessors
    public function getAttachmentUrlsAttribute()
    {
        if (!$this->attachments) return [];
        
        return collect($this->attachments)->map(function ($attachment) {
            return asset('storage/app/public/' . $attachment);
        })->toArray();
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getIsImageAttribute()
    {
        return $this->message_type === 'image';
    }

    public function getIsFileAttribute()
    {
        return $this->message_type === 'file';
    }

    public function getIsAudioAttribute()
    {
        return $this->message_type === 'audio';
    }
} 