<!-- filepath: /c:/laragon/www/LinkDev/resources/views/profile/post/add.blade.php -->
<x-app-layout>
    <div class="mt-10 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">Add Post</h3>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea name="content" id="content" class="mt-1 block w-full" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full">
                </div>
                <div class="mb-4">
                    <label for="hashtags" class="block text-sm font-medium text-gray-700">Existing Hashtags</label>
                    <select name="hashtags[]" id="hashtags" class="mt-1 block w-full" multiple>
                        @foreach($hashtags as $hashtag)
                            <option value="{{ $hashtag->id }}">{{ $hashtag->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="new_hashtags" class="block text-sm font-medium text-gray-700">New Hashtags (comma separated)</label>
                    <input type="text" name="new_hashtags" id="new_hashtags" class="mt-1 block w-full">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Post</button>
            </form>
        </div>
    </div>
</x-app-layout>