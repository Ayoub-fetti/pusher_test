<x-app-layout>
    <div class="mt-10 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">My Conversations</h3>
            
            @if($conversations->isEmpty())
                <p class="text-gray-500">You don't have any conversations yet.</p>
            @else
                <div class="space-y-3">
                    @foreach($conversations as $conversation)
                        <a href="{{ route('conversations.show', $conversation) }}" class="block p-4 border rounded-lg hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @php
                                        $otherUser = $conversation->users->where('id', '!=', auth()->id())->first();
                                    @endphp
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset('storage/' . $otherUser->profile_picture) }}" 
                                             class="h-12 w-12 rounded-full object-cover border-2 border-gray-200" 
                                             alt="{{ $otherUser->name }}'s profile picture">
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="font-medium text-gray-900">
                                            {{ $otherUser ? $otherUser->name : 'Group Conversation' }}
                                        </h4>
                                        <p class="text-sm text-gray-500 truncate">
                                            {{ $conversation->lastMessage ? $conversation->lastMessage->body : 'Start a conversation' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-xs text-gray-500">
                                        {{ $conversation->updated_at->diffForHumans() }}
                                    </span>
                                    @php
                                        $unreadCount = $conversation->unreadMessagesFor(auth()->user());
                                    @endphp
                                    @if($unreadCount > 0)
                                        <span class="bg-blue-500 text-white text-xs rounded-full px-2 py-1 mt-1">
                                            {{ $unreadCount }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
            
            <div class="mt-6">
                <h4 class="font-medium mb-2">Start a New Conversation</h4>
                <form action="{{ route('conversations.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Select User</label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            <option value="">Select a user</option>

                            @foreach($connectedUsers as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="title" class="block text-sm font-medium text-gray-700">Conversation Title (Optional)</label>
                        <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Start Conversation</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>