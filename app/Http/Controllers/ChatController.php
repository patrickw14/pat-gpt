<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Log;
use App\Events\UserMessageSent;

class ChatController extends Controller
{
    public function index($conversationId)
    {
        Log::info('yo whatever');
        $conversations = Conversation::where('user_id', auth()->user()->id)->get();
        $messages = [];

        if ($conversationId) {
            $messages = Message::where('conversation_id', $conversationId)
                ->orderBy('created_at', 'asc')
                ->get();
        }
        $selectedConversation = Conversation::find($conversationId);

        return view('chat', compact('conversations', 'messages', 'selectedConversation'));
    }

    public function storeMessage(Request $request, $conversationId)
    {
        $message = new Message();
        $message->conversation_id = $conversationId;
        $message->content = $request->content;
        $message->type = "user";
        $message->save();

        UserMessageSent::dispatch($message);

        return response()->json(['success' => true, 'message' => $message->content]);
    }
}
