<?php

namespace App\Events\Chat;

use App\Http\Resources\Chat\Message\MessageResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StoreMessageStatusEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $count;
    private $user_id;
    private $chat_id;
    private $message;

    /**
     * Create a new event instance.
     */
    public function __construct($count, $user_id, $chat_id, $message)
    {
        $this->count = $count;
        $this->user_id = $user_id;
        $this->chat_id = $chat_id;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('users-channel.' . $this->user_id),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'store-message-status-broadcast-name';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'count' => $this->count,
            'chat_id' => $this->chat_id,
            'message' => MessageResource::make($this->message)->resolve(),
        ];
    }
}
