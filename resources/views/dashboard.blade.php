<x-app-layout>
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Driving Schools</h1>
    
    <form action="{{ route('driving_schools.search') }}" method="GET" class="mb-6">
        <input type="text" name="search" placeholder="Search by address" class="border p-2 rounded w-full">
        <button type="submit" class="bg-blue-500 text-white p-2 rounded mt-2">Search</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($driving_schools as $school)
            <a href="{{ route('book.create', $school->id) }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition duration-200">
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $school->image) }}" alt="{{ $school->location }}" class="w-full h-40 object-cover rounded-lg">
                </div>
                <h2 class="text-xl font-semibold mb-2">{{ $school->location }}</h2>
                <p class="text-gray-700 mb-2">Registration Number: {{ $school->registration_number }}</p>
                <p class="text-gray-700 mb-2">Phone Number: {{ $school->phone_number }}</p>
                <p class="text-gray-700 mb-4">User ID: {{ $school->user_id }}</p>
            </a>
        @endforeach
    </div>
</div>
</x-app-layout>




