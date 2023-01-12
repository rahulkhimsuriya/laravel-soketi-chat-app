<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->where('id', '!=', Auth::id())
            ->get();

        return Inertia::render('User/Index', [
            'users' => $users
        ]);
    }
}
