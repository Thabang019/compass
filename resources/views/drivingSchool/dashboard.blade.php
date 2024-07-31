<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'students' }">
        <h1 class="text-2xl text-center font-bold mb-4">Admin Dashboard</h1>

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
                <button @click="activeTab = 'students'" :class="{'bg-blue-500 text-white': activeTab === 'students', 'bg-gray-200 text-gray-700': activeTab !== 'students'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-blue-500 text-white">
                    Bookings
                </button>
                <button @click="activeTab = 'schedules'" :class="{'bg-blue-500 text-white': activeTab === 'schedules', 'bg-gray-200 text-gray-700': activeTab !== 'schedules'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-gray-200 text-gray-700">
                    Instructors
                </button>
                <button @click="activeTab = 'instructors'" :class="{'bg-blue-500 text-white': activeTab === 'instructors', 'bg-gray-200 text-gray-700': activeTab !== 'instructors'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-gray-200 text-gray-700">
                    Vehicle
                </button>
            </nav>
        </div>

      <!-- Tab Content -->
    <div>
        <div x-show="activeTab === 'students'" class="bg-white p-8 rounded shadow w-full">
            <h2 class="text-xl font-semibold mb-2">Students</h2>
            <p>Total Students: 50</p>
            <!-- Add more student related details here -->
        </div>
        <div x-show="activeTab === 'schedules'" class="bg-white p-8 rounded shadow w-full">
            <h2 class="text-xl font-semibold mb-2">Schedules</h2>
            <p>Upcoming Classes: 5</p>
            <!-- Add more schedule related details here -->
        </div>
        <div x-show="activeTab === 'instructors'" class="bg-white p-8 rounded shadow w-full">
            <h2 class="text-xl font-semibold mb-2">Instructors</h2>
            <p>Total Instructors: 10</p>
            <!-- Add more instructor related details here -->
        </div>
    </div>

    </div>
</x-app-layout>
