<x-app-layout>
    <div class="mt-10 mr-20 ml-20 bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-bold mb-4">Add Job Offer</h3>
            <form action="{{ route('Job_offers.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="mt-1 block w-full">
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" class="mt-1 block w-full"></textarea>
                </div>
                <div class="mb-4">
                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                    <textarea name="location" id="location" class="mt-1 block w-full"></textarea>
                </div>
                <div class="mb-4">
                    <label for="contract_type" class="block text-sm font-medium text-gray-700">Contract Type</label>
                    <select name="contract_type" id="contract_type" class="mt-1 block w-full">
                        <option value="">Select a contract type</option>
                        <option value="CDI">CDI</option>
                        <option value="CDD">CDD</option>
                        <option value="Freelance">Freelance</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="offer_link" class="block text-sm font-medium text-gray-700">Offer Link</label>
                    <input type="url" name="offer_link" id="offer_link" class="mt-1 block w-full">
                </div>
                <div class="mb-4">
                    <label for="date_published" class="block text-sm font-medium text-gray-700">creation date</label>
                    <input type="date" name="date_published" id="date_published" class="mt-1 block w-full">
                </div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Add Job</button>
            </form>
        </div>
    </div>
</x-app-layout>