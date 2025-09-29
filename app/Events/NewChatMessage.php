<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewChatMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;
    public $userName;
    public $sessionId;

    /**
     * Create a new event instance.
     */
    public function __construct($messageData)
    {
        $this->message = $messageData['message'] ?? '';
        $this->userId = $messageData['user_id'] ?? null;
        $this->userName = $messageData['user_name'] ?? 'Anonymous';
        $this->sessionId = $messageData['session_id'] ?? null;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('fitlive-chat.' . $this->sessionId),
            new PresenceChannel('fitlive-users.' . $this->sessionId)
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'message.new';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'message' => $this->message,
            'user_id' => $this->userId,
            'user_name' => $this->userName,
            'session_id' => $this->sessionId,
            'timestamp' => now()->toISOString()
        ];
    }
}
