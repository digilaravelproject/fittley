<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupMessage extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'group_messages';

    protected $fillable = [
        'group_id',
        'sender_id',
        'content',
        'message_type',
        'media_url',
        'is_read',
        'reply_to_id'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $attributes = [
        'message_type' => 'text',
        'is_read' => false
    ];

    /**
     * Get the group that owns the message
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Get the sender of the message
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the message this is replying to
     */
    public function replyTo()
    {
        return $this->belongsTo(GroupMessage::class, 'reply_to_id');
    }

    /**
     * Get replies to this message
     */
    public function replies()
    {
        return $this->hasMany(GroupMessage::class, 'reply_to_id');
    }

    /**
     * Get users who have read this message
     */
    public function readBy()
    {
        return $this->hasMany(GroupMessageRead::class, 'message_id');
    }

    /**
     * Check if message is read by specific user
     */
    public function isReadBy($userId)
    {
        return $this->readBy()->where('user_id', $userId)->exists();
    }

    /**
     * Scope for unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for messages by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('message_type', $type);
    }
}
