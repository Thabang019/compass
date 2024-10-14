<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'bookings' }">
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
            <p>Zero Bookings</p>
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
                            <x-dropdown-link href="#" @click.prevent="$dispatch('open-vehicle-modal', {{ $vehicle->id }})">
                                {{ __('Edit') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('drivingSchool.delete', $vehicle)">
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

        
         <!-- Edit Vehicle Modal -->
        @if(isset($vehicle))
        <<div x-data="{ show: false }" @open-vehicle-modal.window="show = ($event.detail == {{ $vehicle->id }})" x-show="show" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                <h2 class="text-xl font-semibold mb-4">Edit Vehicle</h2>
                <form method="POST" action="{{ route('drivingSchool.update', $vehicle) }}">
                    @csrf
                    @method('PUT')

                    <!-- Hidden Driving School ID -->
                    <input id="driving_school_id" name="driving_school_id" type="hidden" value="{{ $driving_school_id }}" readonly>

                    <!-- Hidden User ID -->
                    <x-text-input id="user_id" type="hidden" name="user_id" :value="auth()->user()->id" />

                    <!-- Registration Number -->
                    <div>
                        <x-input-label for="registration_number" :value="__('Registration Number')" />
                        <x-text-input id="registration_number" class="block mt-1 w-full" type="text" name="registration_number" 
                                    :value="old('registration_number', $vehicle->registration_number)" required autofocus />
                        <x-input-error :messages="$errors->get('registration_number')" class="mt-2" />
                    </div>

                    <!-- Vehicle Code -->
                    <div class="mt-4">
                        <x-input-label for="code" :value="__('Code')" />
                        <select id="code" name="code" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                            <option value="8" {{ $vehicle->code == 8 ? 'selected' : '' }}>8</option>
                            <option value="10" {{ $vehicle->code == 10 ? 'selected' : '' }}>10</option>
                            <option value="14" {{ $vehicle->code == 14 ? 'selected' : '' }}>14</option>
                        </select>
                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                    </div>

                    <!-- VIN Number -->
                    <div class="mt-4">
                        <x-input-label for="vin_number" :value="__('VIN Number')" />
                        <x-text-input id="vin_number" class="block mt-1 w-full" type="text" name="vin_number" 
                                    :value="old('vin_number', $vehicle->vin_number)" required />
                        <x-input-error :messages="$errors->get('vin_number')" class="mt-2" />
                    </div>

                    <div class="flex justify-end px-4 py-2 mt-2">
                        <button type="button" @click="show = false" class="mt-3 mr-2 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('editVehicleModal')">
                            Cancel
                        </button>
                        <x-primary-button>{{ __('Update Vehicle') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
        @endif


        <!--Instructor Pill-->
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
                                <x-dropdown-link href="#" @click.prevent="$dispatch('open-instructor-modal', {{ $instructor->id }})">
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('drivingSchool.delete-in', $instructor)">
                                    {{ __('Delete') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <span class="text-gray-700 font-medium"> Name: {{ $instructor->name }}</span>
                    <span class="text-gray-700"> Phone Number: {{ $instructor->phone_number }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- Edit Instructor Modal -->
         @if(isset($instructor))
        <div x-data="{ show: false }" @open-instructor-modal.window="show = ($event.detail == {{ $instructor->id }})" x-show="show" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                <h2 class="text-xl font-semibold mb-4">Edit Instructor</h2>
                <form method="POST" action="{{ route('drivingSchool.update-in', $instructor) }}">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $instructor->name) }}" class="mt-1 p-2 w-full border rounded-md">
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $instructor->phone_number) }}" class="mt-1 p-2 w-full border rounded-md">
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end">
                        <button type="button" @click="show = false" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <!-- Edit Price Modal -->
        <div x-data="{ show: false }" @open-price-modal.window="show = true" x-show="show" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-50">
            <div class="bg-white p-8 rounded-lg shadow-lg w-1/3 max-w-md">
                <h2 class="text-2xl font-semibold mb-6 text-center text-gray-800">Update Lesson Price</h2>
                <form action="{{ route('drivingSchool.updatePrice', $driving_school) }}" method="POST" class="mt-6 flex flex-col space-y-4">
                    @csrf
                    <!-- price_per_lesson -->
                    <div>
                        <x-input-label for="price_per_lesson" :value="__('Price Per Lesson *')" class="text-gray-700" />
                        <x-text-input id="price_per_lesson" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500" type="number" step="0.01" name="price_per_lesson" :value="old('price_per_lesson', $driving_school->price_per_lesson)" required autocomplete="off" />
                        <x-input-error :messages="$errors->get('price_per_lesson')" />
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="show = false" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition duration-200">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-200">Save</button>
                    </div>
                </form>
            </div>
        </div>


    </div>

    </div>
</x-app-layout>
