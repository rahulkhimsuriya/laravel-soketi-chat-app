<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageDeleted;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatDeleteController extends Controller
{
    public function __invoke(Request $request, Chat $chat)
    {
        $this->authorize('delete', $chat);

        $chat->delete();

        broadcast(new ChatMessageDeleted(
            chatId: $chat->id,
            senderId: $chat->sender_id,
            receiverId: $chat->receiver_id
        ));

        return redirect()->back();
    }
}
