<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBadge extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'badge_id',
        'earned_at',
        'achievement_data',
        'is_visible',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'badge_id' => 'integer',
        'earned_at' => 'datetime',
        'achievement_data' => 'array',
        'is_visible' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }

    // Scopes
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    public function scopeByBadgeType($query, $type)
    {
        return $query->whereHas('badge', function ($q) use ($type) {
            $q->where('type', $type);
        });
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('earned_at', 'desc');
    }

    // Methods
    public function hide()
    {
        $this->update(['is_visible' => false]);
    }

    public function show()
    {
        $this->update(['is_visible' => true]);
    }

    // Accessors
    public function getTimeAgoAttribute()
    {
        return $this->earned_at->diffForHumans();
    }
} 