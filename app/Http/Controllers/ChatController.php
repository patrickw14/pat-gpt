<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;

class ChatController extends Controller
{
    public function index()
    {
        $conversations = Conversation::where('user_id', auth()->user()->id)->get();
        return view('chat', compact('conversations'));
    }
}
