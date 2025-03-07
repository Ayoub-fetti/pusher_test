<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Events\MessageSent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MessageController extends Controller
{

    use AuthorizesRequests;
    public function store(Request $request, Conversation $conversation)
    {
        $request->validate([
            'body' => 'required|string'
        ]);
        
        // Check if user is part of this conversation
        $this->authorize('view', $conversation);
        
        $message = $conversation->messages()->create([
            'user_id' => Auth::id(),
            'body' => $request->body
        ]);
        
        // Update conversation timestamp
        $conversation->touch();
        
        // Update last_read_at for current user
        $conversation->users()->updateExistingPivot(Auth::id(), [
            'last_read_at' => now()
        ]);
        
        // Broadcast event
        broadcast(new MessageSent($conversation, $message, Auth::user()))->toOthers();
        
        return back();
    }
} 