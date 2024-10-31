<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::create(['conversation_id' => 1, 'content' => 'Message 1 in Conversation 1', 'type' => 'user']);
        Message::create(['conversation_id' => 1, 'content' => 'Message 2 in Conversation 1', 'type' => 'system']);
        Message::create(['conversation_id' => 2, 'content' => 'Message 1 in Conversation 2', 'type' => 'user']);
        Message::create(['conversation_id' => 2, 'content' => 'Message 2 in Conversation 2', 'type' => 'system']);
    }
}
