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

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public readonly Chat $chat)
    {
        //
    }

    public function broadcastOn(): Channel
    {
        return new Channel("chat.sender.{$this->chat->sender_id}.receiver.{$this->chat->receiver_id}");
    }

    public function broadcastAs(): string
    {
        return 'new-message';
    }
}
