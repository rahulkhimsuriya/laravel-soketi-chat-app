<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class UserChatController extends Controller
{
    public function index(Request $request)
    {
        // get user's chat

        return Inertia::render('UserChat/Index');
    }
}
