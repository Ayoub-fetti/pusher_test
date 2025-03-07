<!-- filepath: /c:/laragon/www/LinkDev/resources/views/notification.blade.php -->
<x-app-layout>
    <div class="py-12 max-w-4xl mx-auto">
        <h2 class="text-xl font-semibold mb-4">Notifications</h2>
        <div class="bg-white shadow-md rounded-lg p-6">
            @if($receivedConnections->isEmpty() && $notifications->whereNull('read_at')->isEmpty())
                <p class="text-gray-500 text-center">No notifications available.</p>
            @else
                <!-- Combined notifications list -->
                <div class="space-y-4">
                    <!-- Connection requests -->
                    @foreach($receivedConnections as $connection)
                        <div class="flex items-center justify-between border-b pb-4">
                            <div class="flex items-center gap-3">
                                <img class="w-12 h-12 rounded-full" src="{{ asset('storage/' . $connection->sourceUser->profile_picture) }}" alt="Profile Picture">
                                <p class="text-gray-800"><span class="font-semibold">{{ $connection->sourceUser->name }}</span> wants to connect with you.</p>
                            </div>
                            <div class="flex gap-2">
                                <form action="{{ route('connections.accept') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="connection_id" value="{{ $connection->id }}">
                                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Accept</button>
                                </form>
                                <form action="{{ route('connections.reject') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="connection_id" value="{{ $connection->id }}">
                                    <button type="submit" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Reject</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <!-- Likes and Comments notifications - Only unread -->
                    @foreach($notifications->whereNull('read_at') as $notification)
                        <div class="flex items-center justify-between border-b pb-4">
                            <div class="flex items-center gap-3">
                                @if(isset($notification->data['user_image']))
                                    <img class="w-12 h-12 rounded-full" src="{{ asset('storage/' . $notification->data['user_image']) }}" alt="Profile Picture">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                @if($notification->type === 'App\Notifications\PostLiked')
                                    <p class="text-gray-800"><span class="font-semibold">{{ $notification->data['message'] }}</span></p>
                                @elseif($notification->type === 'App\Notifications\CommentNofication')
                                    <p class="text-gray-800"><span class="font-semibold">{{ $notification->data['message'] }}</span></p>
                                @else
                                    <p class="text-gray-800">{{ $notification->data['message'] }}</p>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-gray-400 hover:text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>