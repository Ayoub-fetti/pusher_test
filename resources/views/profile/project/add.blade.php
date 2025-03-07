<x-app-layout>
    <div class="mt-10 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">Add Project</h3>
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="mt-1 block w-full"></textarea>
                </div>
                <div class="mb-4">
                    <label for="repo_link" class="block text-sm font-medium text-gray-700">Repository Link</label>
                    <input type="url" name="repo_link" id="repo_link" class="mt-1 block w-full">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Project</button>
            </form>
        </div>
    </div>
</x-app-layout>