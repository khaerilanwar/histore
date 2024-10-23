<form class="flex items-center max-w-md mx-auto">
    <label for="simple-search" class="sr-only">Search</label>
    <div class="relative w-full">
        <input type="text" id="simple-search" name="s"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ps-4"
            placeholder="Search by phone number..." value="{{ request('s') }}" autocomplete="off" />
    </div>
    <button type="submit"
        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        Search
        <span class="sr-only">Search</span>
    </button>
</form>
