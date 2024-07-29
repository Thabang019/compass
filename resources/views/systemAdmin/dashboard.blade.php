<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8" x-data="{ activeTab: 'students' }">
        <h1 class="text-2xl text-center font-bold mb-4">Welcome to Compass</h1>

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
    
    <div x-show="activeTab === 'registrations'" class="bg-white p-8 rounded shadow w-full">
        <h2 class="text-xl font-semibold mb-2">Registrations</h2>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @foreach ($drivingSchools as $drivingSchool)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $drivingSchool->location }}</h5>
                    <p class="card-text">{{ $drivingSchool->phone_number }}</p>
                    <p class="card-text">Registered by: {{ $drivingSchool->user->name }}</p>
                    <a href="{{ route('drivingSchools.show', $drivingSchool) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        @endforeach
    </div>



    <div x-show="activeTab === 'schools'" class="bg-white p-8 rounded shadow w-full">
        <h2 class="text-xl font-semibold mb-2">Driving Schools</h2>
        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @foreach ($drivingSchools as $drivingSchool)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $drivingSchool->location }}</h5>
                    <p class="card-text">{{ $drivingSchool->phone_number }}</p>
                    <p class="card-text">Registered by: {{ $drivingSchool->user->name }}</p>
                    <a href="{{ route('drivingSchools.show', $drivingSchool) }}" class="btn btn-primary">View Details</a>
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
