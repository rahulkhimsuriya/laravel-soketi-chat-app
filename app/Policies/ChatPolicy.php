<?php

namespace App\Policies;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Chat $chat)
    {
        return (int) $user->id === (int) $chat->sender_id;
    }
}
