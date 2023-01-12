<?php

namespace App\Http\Controllers;

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
            ->where(function (Builder $query) use ($user) {
                $query
                    ->where('sender_id', '=', Auth::id())
                    ->where('receiver_id', '=', $user->id);
            })
            ->orWhere(function (Builder $query) use ($user) {
                $query
                    ->where('sender_id', '=', $user->id)
                    ->where('receiver_id', '=', Auth::id());
            })
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

        Chat::create([
            'message' => $request->string('message'),
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id
        ]);

        return redirect(route('user.chat.index', ['user' => $user]));
    }
}
