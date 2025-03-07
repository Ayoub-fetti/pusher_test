<x-app-layout>
    <div class="mt-10 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">Add Certification</h3>
            <form action="{{ route('certifications.store') }}" method="POST">
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
                    <label for="certification_date" class="block text-sm font-medium text-gray-700">Certification date</label>
                    <input type="date" name="certification_date" id="certification_date" class="mt-1 block w-full">
                </div>
                <div class="mb-4">
                    <label for="certification_link" class="block text-sm font-medium text-gray-700">Certification Link</label>
                    <input type="url" name="certification_link" id="certification_link" class="mt-1 block w-full">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Certification</button>
            </form>
        </div>
    </div>
</x-app-layout>