<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Conversation;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Conversation::create(['title' => 'Conversation 1', 'user_id' => 1]);
        Conversation::create(['title' => 'Conversation 2', 'user_id' => 1]);
    }
}
