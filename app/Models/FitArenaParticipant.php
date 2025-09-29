<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitArenaParticipant extends Model
{
    use HasFactory;

    protected $table = 'fitarena_participants';

    protected $fillable = [
        'user_id',
        'fitarena_session_id',
        'joined_at',
        'left_at',
        'duration_seconds',
        'completed',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
        'duration_seconds' => 'integer',
        'completed' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fitarenaSession()
    {
        return $this->belongsTo(FitArenaSession::class);
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeBySession($query, $sessionId)
    {
        return $query->where('fitarena_session_id', $sessionId);
    }

    // Methods
    public function markCompleted()
    {
        $this->update(['completed' => true]);
    }

    public function calculateDuration()
    {
        if ($this->left_at && $this->joined_at) {
            $this->duration_seconds = $this->joined_at->diffInSeconds($this->left_at);
            $this->save();
        }
    }
}
