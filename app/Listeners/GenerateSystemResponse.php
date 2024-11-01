<?php

namespace App\Listeners;

use App\Events\UserMessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Message;

class GenerateSystemResponse
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserMessageSent $event): void
    {
        $message = $event->message;
        $systemResponse = new Message();
        $systemResponse->conversation_id = $message->conversation_id;
        $systemResponse->content = 'This is a system response to your message: ' . $message->content;
        $systemResponse->type = 'system';
        $systemResponse->save();
    }
}
