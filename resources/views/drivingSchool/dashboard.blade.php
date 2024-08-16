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

        @if (session('error'))
        <div id="errorMessage" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ session('error') }}
        </div>
            <script>
                setTimeout(function(){
                    var errorMessage = document.getElementById('errorMessage');
                    if (errorMessage) {
                        errorMessage.style.display = 'none';
                    }
                }, 5000); // Hide the error message after 5 seconds (5000 milliseconds)
            </script>
        @endif

        <!-- Pill Tabs -->
        <div class="mb-6">
        <nav class="flex space-x-10">
                <button @click="activeTab = 'bookings'" :class="{'bg-blue-500 text-white': activeTab === 'bookings', 'bg-gray-200 text-gray-700': activeTab !== 'bookings'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-blue-500 text-white">
                    Bookings
                </button>
                <button @click="activeTab = 'vehicles'" :class="{'bg-blue-500 text-white': activeTab === 'vehicles', 'bg-gray-200 text-gray-700': activeTab !== 'vehicles'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-gray-200 text-gray-700">
                    Vehicles
                </button>
                <button @click="activeTab = 'instructors'" :class="{'bg-blue-500 text-white': activeTab === 'instructors', 'bg-gray-200 text-gray-700': activeTab !== 'instructors'}" class="px-4 py-2 rounded-full focus:outline-none w-full bg-gray-200 text-gray-700">
                    Instructors
                </button>
            </nav>
        </div>

      <!-- Tab Content -->
    <div>
        <div x-show="activeTab === 'bookings'" class="bg-white p-8 rounded shadow w-full">
            <h2 class="text-xl font-semibold mb-2">Bookings</h2>
            <p>Total Students: 50</p>
            <!-- Add more student related details here -->
        </div>

        <div x-show="activeTab === 'vehicles'" class="bg-white p-8 rounded shadow w-full">
            <ul class="space-y-4">
                @foreach($driving_school->vehicles as $vehicle)
                    <li class="p-4 bg-gray-50 rounded-lg shadow-sm flex justify-between items-center hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <a href="javascript:void(0);" onclick="openModal('editVehicleModal', {{ $vehicle->id }})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Edit') }}
                            </a>

                            <x-dropdown-link :href="route('drivingSchool.edit', $vehicle)">
                                {{ __('Delete') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    </div>
                    <span class="text-gray-700 font-medium">Car Registration Number : {{  $vehicle->registration_number }}</span>
                    <span class="text-gray-700"> Lisence Code : {{ $vehicle->code}}</span>
                    <span class="text-gray-700"> Vin Number : {{ $vehicle->vin_number}}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        

        <div x-show="activeTab === 'instructors'" class="bg-white p-8 rounded-lg shadow-md w-full">
            <ul class="space-y-4">
                @foreach($driving_school->instructors as $instructor)
                    <li class="p-4 bg-gray-50 rounded-lg shadow-sm flex justify-between items-center hover:bg-gray-100 transition">
                    <div class="flex justify-between items-center">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('drivingSchool.edit', $instructor)">
                                {{ __('Edit') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('drivingSchool.edit', $instructor)">
                                {{ __('Delete') }}
                            </x-dropdown-link>
                        </x-slot>
                    </x-dropdown>
                    </div>
                        <span class="text-gray-700 font-medium"> Name : {{ $instructor->name }}</span>
                        <span class="text-gray-700"> Phone Number : {{ $instructor->phone_number }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>

    </div>
</x-app-layout>
