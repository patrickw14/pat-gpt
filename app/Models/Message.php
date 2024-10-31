<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'content', 'conversation_id'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
