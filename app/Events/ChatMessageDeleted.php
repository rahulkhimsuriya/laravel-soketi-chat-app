<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public readonly int $chatId,
        public readonly int $senderId,
        public readonly int $receiverId
    ) {
    }

    public function broadcastOn()
    {
        return new Channel("chat.sender.{$this->senderId}.receiver.{$this->receiverId}");
    }

    public function broadcastAs(): string
    {
        return 'chat-message-deleted';
    }
}
