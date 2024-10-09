<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Compass') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,600">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

     <!-- Scripts -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
     <script src="//unpkg.com/alpinejs" defer></script>

</head>
<body class= "fonts-sans antialiased">
    <dive class= "min-h-scree bg-gray-100">
        @include('layouts.navigation')
    

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Modals -->
                    <!-- Modal for Adding Instructor -->
                    <div id="addInstructorModal" class="fixed inset-0 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div>
                                        <div>
                                            <h3 class="text-lg leading-6 text-center font-semibold text-gray-900" id="modal-title">Add Instructor</h3>
                                            <div class="mt-2">

                                            <form id="addInstructorForm" action="{{ route('instructors.store') }}" enctype="multipart/form-data" method="POST">
                                            @csrf
                                            <input id="driving_school_id" name="driving_school_id" type="hidden" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $driving_school_id }}" readonly>

                                            <x-text-input id="user_id" type="hidden" name="user_id" :value="auth()->user()->id"/>
                                            <div class="mt-4">
                                                <x-input-label for="name" :value="__('Full Name')" />
                                                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                            </div>
                                            <div class="mt-4">
                                                <x-input-label for="phone_number" :value="__('Phone Number')" />
                                                <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="phone_number" />
                                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                             </div>
                                            <div class="mt-4">
                                                <x-primary-button>{{ __('Add Instructor') }}</x-primary-button>
                                            </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-250 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('addInstructorModal')">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal for Adding Vehicle -->
                    <div id="addVehicleModal" class="fixed inset-0 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div>
                                        <div >
                                            <h3 class="text-lg leading-6 text-center font-semibold text-gray-900" id="modal-title">Add Vehicle</h3>
                                            <div class="mt-2">
                                                <form id="addVehicleForm" action="{{ route('vehicles.store') }}" enctype="multipart/form-data" method="POST">
                                                 @csrf
                                                    <input id="driving_school_id" name="driving_school_id" type="hidden" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $driving_school_id }}" readonly>
                                                    <x-text-input id="user_id" type="hidden" name="user_id" :value="auth()->user()->id"/>

                                                    <div>
                                                        <x-input-label for="registration_number" :value="__('Registration Number')" />
                                                        <x-text-input id="registration_number" class="block mt-1 w-full" type="text" name="registration_number" :value="old('registration_number')" required autofocus autocomplete="registration_number" />
                                                        <x-input-error :messages="$errors->get('registration_number')" class="mt-2" />
                                                    </div>

                                                    <div class="mt-4">
                                                        <x-input-label for="code" :value="__('Code')" />
                                                        <select id="code" name="code" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                                                            <option value="8"> 8 </option>    
                                                            <option value="10"> 10 </option>
                                                            <option value="14"> 14 </option>
                                                        </select>
                                                        <x-input-error :messages="$errors->get('code')" class="mt-2" />
                                                    </div>

                                                    <div class="mt-4">
                                                        <x-input-label for="vin_number" :value="__('VIN Number')" />
                                                        <x-text-input id="vin_number" class="block mt-1 w-full" type="text" name="vin_number" :value="old('vin_number')" required autocomplete="vin_number" />
                                                        <x-input-error :messages="$errors->get('vin_number')" class="mt-2" />
                                                    </div>

                                                    <div class="mt-4">
                                                        <x-primary-button>{{ __('Add Vehicle') }}</x-primary-button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-250 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-green text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('addVehicleModal')">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- Modal for Creating Schedule -->
                    <div id="createScheduleModal" class="fixed inset-0 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div>
                                        <div class="space-y-4">
                                            <h3 class="text-lg leading-6 text-center font-semibold text-gray-900" id="modal-title">Edit Working Hours for Company</h3>
                                            <div class="mt-2">

                                                <input id="driving_school_id" name="driving_school_id" type="hidden" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $driving_school_id }}" readonly>

                                                <x-text-input id="user_id" type="hidden" name="user_id" :value="auth()->user()->id"/>

                                                <form action="{{ route('working_hours.store') }}" enctype="multipart/form-data" method="POST">
                                                    @csrf
                                                
                                                    @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                                        <div class="flex items-center space-x-4">
                                                            <label class="w-24 font-semibold text-gray-700">{{ $day }}:</label>
                                                            <input type="hidden" name="working_hours[{{ $day }}][day_of_week]" value="{{ $day }}">

                                                            <input type="time" name="working_hours[{{ $day }}][opening_time]" 
                                                                placeholder="Opening Time" 
                                                                class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-500">

                                                            <input type="time" name="working_hours[{{ $day }}][closing_time]" 
                                                                placeholder="Closing Time" 
                                                                class="px-3 py-2 border rounded-md focus:outline-none focus:ring focus:ring-indigo-500">
                                                        </div>
                                                    @endforeach

                                                    <div class="mt-4">
                                                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                                                    </div>
                                                </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="bg-gray-250 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="closeModal('createScheduleModal')">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                                
        <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        </script>

    </body>


</html>



