<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWatchlist extends Model
{
    use HasFactory;

    protected $table = 'user_watchlist';

    protected $fillable = [
        'user_id',
        'watchable_type',
        'watchable_id',
        'added_at'
    ];

    protected $casts = [
        'added_at' => 'datetime'
    ];

    /**
     * Get the user that owns the watchlist item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the watchable model (FitDoc, FitGuide, etc.).
     */
    public function watchable()
    {
        return $this->morphTo();
    }

    /**
     * Scope for recent additions.
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('added_at', '>=', now()->subDays($days));
    }
}
