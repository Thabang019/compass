<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'registrations' }">
        <h1 class="text-2xl text-center font-bold mb-4">Compass Root Admin</h1>

        @if(session('status'))
            <div id="statusMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('status') }}
            </div>
            <script>
                setTimeout(function(){
                    var statusMessage = document.getElementById('statusMessage');
                    statusMessage.style.display = 'none';
                }, 5000); // Hide the status message after 5 seconds (5000 milliseconds)
            </script>
        @endif

        <!-- Pill Tabs -->
        <div class="mb-6">
        <nav class="flex space-x-10">
                <button @click="activeTab = 'registrations'" :class="{'bg-blue-500 text-white': activeTab === 'registrations', 'bg-gray-200 text-gray-700': activeTab !== 'registrations'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-blue-500 text-white">
                    New Registrations
                </button>
                <button @click="activeTab = 'schools'" :class="{'bg-blue-500 text-white': activeTab === 'schools', 'bg-gray-200 text-gray-700': activeTab !== 'schools'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-gray-200 text-gray-700">
                    Driving Schools
                </button>
                <button @click="activeTab = 'bookings'" :class="{'bg-blue-500 text-white': activeTab === 'bookings', 'bg-gray-200 text-gray-700': activeTab !== 'bookings'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-gray-200 text-gray-700">
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
                    <h5 class="text-lg font-semibold text-gray-800">{{ $drivingSchool->school_name }}</h5>
                    <p class="text-gray-600">{{ $drivingSchool->location }}</p>
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
                    <h5 class="text-lg font-semibold text-gray-800">{{ $drivingSchool->school_name }}</h5>
                    <p class="text-gray-600">{{ $drivingSchool->location }}</p>
                    <p class="text-gray-600">{{ $drivingSchool->phone_number }}</p>
                    <p class="text-gray-500">Registered by: {{ $drivingSchool->user->name }}</p>
                    <p class="text-gray-500">Status : {{ $drivingSchool->status }}</p>
                    <a href="{{ route('profile.displayDrivingSchoolProfile', $drivingSchool->id) }}" class="mt-2 inline-block bg-blue-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">View Details</a>
                </div>
            </div>
        @endforeach
    </div>   
    


        <div x-show="activeTab === 'bookings'" class="bg-white p-8 rounded-lg shadow-lg w-full">
            <h2 class="text-2xl font-bold mb-6 border-b-2 pb-4 text-gray-700">All Upcoming Bookings</h2>
            @if($futureLessons)
                @foreach($futureLessons as $futureLesson)
                    <div class="mb-8 p-6 bg-green-50 rounded-lg shadow-sm">
                        <!-- Booking Information -->
                        <h3 class="text-lg font-semibold text-gray-600">Booking ID: {{ $futureLesson['booking']->id }}</h3>
                        <h3 class="text-md font-medium text-gray-700 mt-1">Driving School: {{ $futureLesson['booking']->driving_school_name }}</h3>
                        <p class="mt-2 text-gray-600">
                            <span class="font-medium text-gray-700">Learner Name:</span> {{ $futureLesson['user']->name }}<br>
                            <span class="font-medium text-gray-700">Phone Number:</span> {{ $futureLesson['user']->phone_number }}<br>
                            <span class="font-medium text-gray-700">Email:</span> {{ $futureLesson['user']->email }}
                        </p>

                        <ul class="mt-4 space-y-4">
                            @foreach($futureLesson['lessons'] as $lesson)
                                <li class="bg-white p-4 rounded-md shadow">
                                    <p class="text-gray-600">
                                        <span class="font-medium text-gray-700">Date:</span> {{ $lesson->date }}<br>
                                        <span class="font-medium text-gray-700">Time:</span> {{ $lesson->start_time }} - {{ $lesson->end_time }}<br>
                                        <span class="font-medium text-gray-700">Lesson Type:</span> Code {{ $lesson->lesson_type }}<br>
                                        <span class="font-medium text-gray-700">Lesson Price:</span> R{{ number_format($lesson->lesson_price, 2) }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500 mt-4">No future lessons available.</p>
            @endif
        </div>


    </div>

    </div>
</x-app-layout>