<div>
    <input type="text" wire:model="search" placeholder="Search posts..." class="w-full p-2 mb-4 border rounded">

    @foreach($posts as $post)
        <div class="bg-white p-4 rounded-lg shadow-md flex flex-col justify-between mb-6">
            <div class="flex items-center mb-2">
                <img src="{{ asset('storage/' . $post->user->profile_picture) }}" alt="Avatar" class="w-10 h-10 rounded-full mr-3">
                <div>
                    <h4 class="text-lg font-semibold">{{ $post->user->name }}</h4>
                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <p class="text-gray-800 text-sm">{{ $post->content }}</p>
            <p class="text-blue-800 text-xs">
                @foreach($post->hashtags as $hashtag)
                    {{ $hashtag->name }}
                @endforeach
            </p>
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-auto mt-2 rounded-lg">
            @endif
            <div class="flex items-center justify-between mt-3 text-gray-600 text-sm">
                <button class="flex items-center hover:text-red-600">
                    <i class="far fa-heart text-red-500 mr-1"></i>Like
                </button>
                <button onclick="toggleCommentSection({{ $post->id }})" class="flex items-center hover:text-blue-600">
                    <i class="far fa-comment text-blue-500 mr-1"></i> Comment <span class="ml-2" id="comment-count-{{ $post->id}}">({{$post->comments->count()}})</span>
                </button>
                <button class="flex items-center hover:text-green-500">
                    <i class="fas fa-share text-green-500 mr-1"></i> Share
                </button>
                @if (Auth::id() === $post->user_id)
                    <a href="{{ route('posts.edit', $post->id) }}" class="flex items-center hover:text-orange-500">
                        <i class="fas fa-pen text-orange-500 mr-1"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('posts.destroy', $post->id) }}" onsubmit="return confirm('Voulez-vous vraiment supprimer ce post ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center hover:text-red-600">
                            <i class="far fa-minus-square text-red-500 mr-1"></i> Supprimer
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @endforeach
</div>