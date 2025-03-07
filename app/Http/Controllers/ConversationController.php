<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConversationController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        
        $connectedUsers = User::where('id', '!=', auth()->id())
            ->get()
            ->filter(function($user) {
                return auth()->user()->connectionStatus($user->id) === 'accepted';
            });

        $conversations = Auth::user()->conversations;
        return view('conversations.index', compact('conversations','connectedUsers'));
    }

    public function show(Conversation $conversation)
    {
        // Check if user is part of this conversation
        $this->authorize('view', $conversation);
        
        // Mark conversation as read
        $conversation->users()->updateExistingPivot(Auth::id(), [
            'last_read_at' => now()
        ]);
        
        return view('conversations.show', compact('conversation'));
    }
    

        public function store(Request $request)
        {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'title' => 'nullable|string|max:255'
            ]);
            
            $otherUser = User::findOrFail($request->user_id);
            
            // Check if conversation already exists between these users
            $existingConversation = Auth::user()->conversations()
                ->whereHas('users', function($query) use ($otherUser) {
                    $query->where('users.id', $otherUser->id);
                })
                ->first();
                
            if ($existingConversation) {
                return redirect()->route('conversations.show', $existingConversation);
            }
            
            // Create a new conversation
            $conversation = Conversation::create([
                'title' => $request->title ?? null
            ]);
            
            // Attach users to conversation
            $conversation->users()->attach([
                Auth::id() => ['last_read_at' => now()],
                $otherUser->id => ['last_read_at' => null]
            ]);
            
            return redirect()->route('conversations.show', $conversation);
        }
    

    }
