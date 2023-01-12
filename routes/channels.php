<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.sender.{senderId}.receiver.{receiverId}', function ($user, $senderId, $receiverId) {
    return [
        'sender_id' => $senderId,
        'receiver_id' => $receiverId
    ];
});
