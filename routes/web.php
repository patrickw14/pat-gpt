<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Models\Conversation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;

Route::get('/', function () {
    return redirect('chat');
});

Route::get('/chat', function () {
    $latestConversation = Conversation::where('user_id', auth()->user()->id)->latest()->first();
    return redirect('/chat/' . $latestConversation->id);
})->middleware(['auth', 'verified'])->name('chat');

Route::get('/chat/{conversationId}', [ChatController::class, 'index'])->middleware(['auth', 'verified'])->name('chat');

Route::post('/chat/{conversationId}/message', [ChatController::class, 'storeMessage'])->middleware(['auth', 'verified'])->name('chat.storeMessage');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Broadcast::routes(['middleware' => ['auth:api']]);

require __DIR__.'/auth.php';
