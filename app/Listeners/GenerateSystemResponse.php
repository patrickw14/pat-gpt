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

        $this->simulateSystemResponse($userMessage->content, $userMessage->conversation_id);
    }

    private function simulateSystemResponse($userMessageContent, $conversationId)
    {
        $systemResponse = "This is the system response to '" . $userMessageContent . "', which is being streamed as if its coming from an LLM, even though it isn't.";
        // Example: Simulate chunked response generation

        // Chunk $systemResponse into 12-character chunks
        $chunks = str_split($systemResponse, 12);

        // Save system response chunk
        $messageId = Message::max('id') + 1;
        $systemMessage = new Message();
        $systemMessage->id = $messageId;
        $systemMessage->conversation_id = $conversationId;
        // Create a message with empty content to represent the system message
        $systemMessage->content = '';
        $systemMessage->type = 'system';
        $systemMessage->save();

        foreach ($chunks as $chunk) {
            // Simulate delay
            usleep(100000);

            // Update the message from earlier to include this chunk
            $systemMessage->content = $systemMessage->content . $chunk;
            $systemMessage->save();

            // Broadcast system message chunk
            SystemMessageChunkCreated::dispatch($conversationId, $messageId, $chunk);
        }
    }
}
