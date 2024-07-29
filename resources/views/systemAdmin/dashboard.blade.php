<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'registrations' }">
        <h1 class="text-2xl text-center font-bold mb-4">Compass Root Admin</h1>

        <!-- Pill Tabs -->
        <div class="mb-6">
        <nav class="flex space-x-10">
                <button @click="activeTab = 'registrations'" :class="{'bg-blue-500 text-white': activeTab === 'registrations', 'bg-gray-200 text-gray-700': activeTab !== 'registrations'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-blue-500 text-white">
                    New Registrations
                </button>
                <button @click="activeTab = 'schools'" :class="{'bg-blue-500 text-white': activeTab === 'schools', 'bg-gray-200 text-gray-700': activeTab !== 'schools'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-gray-200 text-gray-700">
                    Driving Schools
                </button>
                <button @click="activeTab = 'instructors'" :class="{'bg-blue-500 text-white': activeTab === 'instructors', 'bg-gray-200 text-gray-700': activeTab !== 'instructors'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-gray-200 text-gray-700">
                    Bookings
                </button>
            </nav>
        </div>

      <!-- Tab Content -->
    <div>
    
    <div x-show="activeTab === 'registrations'" class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-700">Registrations</h2>
        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('status') }}
            </div>
        @endif

        @foreach ($drivingSchools as $drivingSchool)
            <div class="bg-white border border-gray-200 rounded-lg shadow-md mb-4">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800">{{ $drivingSchool->location }}</h5>
                    <p class="text-gray-600">{{ $drivingSchool->phone_number }}</p>
                    <p class="text-gray-500">Registered by: {{ $drivingSchool->user->name }}</p>
                    <a href="{{ route('drivingSchools.show', $drivingSchool) }}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">View Details</a>
                </div>
            </div>
        @endforeach
    </div>



    <div x-show="activeTab === 'schools'" class="bg-white p-8 rounded shadow w-full">
        <h2 class="text-xl font-semibold mb-2">Driving Schools</h2>

        @foreach ($allDrivingSchools as $drivingSchool)
        <div class="bg-white border border-gray-200 rounded-lg shadow-md mb-4">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800">{{ $drivingSchool->location }}</h5>
                    <p class="text-gray-600">{{ $drivingSchool->phone_number }}</p>
                    <p class="text-gray-500">Registered by: {{ $drivingSchool->user->name }}</p>
                    <a href="{{ route('drivingSchools.show', $drivingSchool) }}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">View Details</a>
                </div>
            </div>
        @endforeach
    </div>   
    


        <div x-show="activeTab === 'instructors'" class="bg-white p-8 rounded shadow w-full">
            <h2 class="text-xl font-semibold mb-2">Instructors</h2>
            <p>Total Instructors: 10</p>
            <!-- Add more instructor related details here -->
        </div>


    </div>

    </div>
</x-app-layout>
