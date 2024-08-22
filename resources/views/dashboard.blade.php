<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Driving Schools</h1>
        
        <form action="{{ route('driving_schools.search') }}" method="GET" class="mb-6" id="search-form">
    <input type="text" name="location" id="location-search" placeholder="Search by address" class="border p-2 rounded w-full">
    <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-2">Search</button>
    <ul id="suggestions" class="border p-2 rounded w-full bg-white shadow-lg"></ul>
</form>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($driving_schools as $school)
                <a href="{{ route('book.create', $school->id) }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $school->image) }}" alt="{{ $school->location }}" class="w-full h-40 object-cover rounded-lg">
                    </div>
                    <h2 class="text-xl font-semibold mb-2">{{ $school->school_name }}</h2>
                    <p class="text-gray-700 mb-2">Registration Number: {{ $school->registration_number }}</p>
                    <p class="text-gray-700 mb-2">Phone Number: {{ $school->phone_number }}</p>
                    <p class="text-gray-700 mb-4">User ID: {{ $school->user_id }}</p>
                </a>
            @empty
                <p class="text-red-500">No registered driving schools found in this location.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>


