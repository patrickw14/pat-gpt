<?php

namespace App\Listeners;

use App\Events\UserMessageSent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Message;
use App\Events\SystemMessageChunkCreated;

class GenerateSystemResponse implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(UserMessageSent $event): void
    {
        $userMessage = $event->message;

        // Generate system response in chunks
        $this->generateSystemResponseInChunks($userMessage->content, $userMessage->conversation_id);
    }

    private function generateSystemResponseInChunks($userMessageContent, $conversationId)
    {
        // Example: Simulate chunked response generation
        $chunks = [
            "System response part 1 to: " . $userMessageContent,
            "System response part 2 to: " . $userMessageContent,
            "System response part 3 to: " . $userMessageContent,
        ];

        foreach ($chunks as $chunk) {
            // Simulate delay
            usleep(300000);

            // Save system response chunk
            $systemMessage = new Message();
            $systemMessage->conversation_id = $conversationId;
            $systemMessage->content = $chunk;
            $systemMessage->type = 'system';
            $systemMessage->save();

            // Broadcast system message chunk
            SystemMessageChunkCreated::dispatch($systemMessage);
        }
    }
}
