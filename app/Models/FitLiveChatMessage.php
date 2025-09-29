<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FitLiveChatMessage extends Model
{
    use HasFactory;

    protected $table = 'fitlive_chat_messages';

    public $timestamps = false;

    protected $fillable = [
        'fitlive_session_id',
        'user_id',
        'body',
        'sent_at',
        'is_instructor',
    ];

    protected $casts = [
        'fitlive_session_id' => 'integer',
        'user_id' => 'integer',
        'sent_at' => 'datetime',
        'is_instructor' => 'boolean',
    ];

    public function fitLiveSession()
    {
        return $this->belongsTo(FitLiveSession::class, 'fitlive_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
