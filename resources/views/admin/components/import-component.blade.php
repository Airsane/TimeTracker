<div class="flex flex-col items-center justify-center p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Import Tasks</h2>

    <form action="/admin/import-tasks" method="POST" enctype="multipart/form-data" class="w-full max-w-md">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="file">
                Select JSON File
            </label>
            <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                id="file"
                type="file"
                name="file"
                accept=".json"
                required
            >
        </div>

        <div class="flex items-center justify-center">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit"
            >
                Import Tasks
            </button>
        </div>
    </form>

    <p class="mt-4 text-sm text-gray-600">
        Please upload a JSON file in the correct format
    </p>
</div>
