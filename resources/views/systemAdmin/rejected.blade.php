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

      <!-- Tab Content -->
    <div>
    
    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-gray-700">Rejected Registrations</h2>
        @if(session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('status') }}
            </div>
        @endif

        @foreach ($rejectedDrivingSchools as $drivingSchool)
            <div class="bg-white border border-gray-200 rounded-lg shadow-md mb-4">
                <div class="p-4">
                    <h5 class="text-lg font-semibold text-gray-800">{{ $drivingSchool->school_name }}</h5>
                    <p class="text-gray-600">{{ $drivingSchool->location }}</p>
                    <p class="text-gray-600">{{ $drivingSchool->phone_number }}</p>
                    <p class="text-gray-500">Registered by: {{ $drivingSchool->user->name }}</p>
                    <a href="{{ route('drivingSchools.show', $drivingSchool) }}" class="mt-2 inline-block bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">View Details</a>
                    <a href="{{ route('profile.displayDrivingSchoolProfile', $drivingSchool->id) }}" class="mt-2 inline-block bg-blue-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded">Delete</a>
                
                </div>
            </div>
        @endforeach
    </div>

</div>

</x-app-layout>
