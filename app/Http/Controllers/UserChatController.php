<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserChatController extends Controller
{
    public function index(Request $request, User $user)
    {
        $chats = Chat::query()
            ->with(['sender'])
            ->chatHistoryFor(Auth::user(), $user)
            ->get();

        return Inertia::render('UserChat/Index', [
            'chats' => $chats,
            'sender' => $user
        ]);
    }

    public function store(Request $request, User $user)
    {
        request()->validate([
            'message' => ['required']
        ]);

        /** @var Chat */
        $chat = Chat::create([
            'message' => $request->string('message'),
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id
        ]);

        $chat->load('sender');

        broadcast(new NewMessage($chat));

        return redirect(route('user.chat.index', ['user' => $user]));
    }
}
