<x-app-layout>
    <div class="mt-10 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">Edit Post</h3>
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full" value="{{ $post->title }}" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" class="mt-1 block w-full" required>{{ $post->content }}</textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-80 h-auto mt-2 rounded-lg">
                    @endif
                </div>
                <div class="mb-4">
                    <label for="hashtags" class="block text-sm font-medium text-gray-700">Existing Hashtags</label>
                    <select name="hashtags[]" id="hashtags" class="mt-1 block w-full" multiple>
                        @foreach($hashtags as $hashtag)
                            <option value="{{ $hashtag->id }}" @if(in_array($hashtag->id, $post->hashtags->pluck('id')->toArray())) selected @endif>{{ $hashtag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="new_hashtags" class="block text-sm font-medium text-gray-700">New Hashtags (comma separated)</label>
                    <input type="text" name="new_hashtags" id="new_hashtags" class="mt-1 block w-full">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Update Post</button>
            </form>
        </div>
    </div>
</x-app-layout>