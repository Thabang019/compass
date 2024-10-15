<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8" x-data="{ activeTab: 'registrations' }">
        <h1 class="text-2xl text-center font-bold mb-4">Admin</h1>

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

        <div class="bg-white p-8 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-gray-700">Driving School Working Hours</h2>

            @foreach ($driving_school->workingHours as $index => $day)
                <div class="flex items-center space-x-4 mb-4">
                    <label class="w-24 font-semibold text-gray-700">{{ $day->day_of_week }}:</label>

                    <input type="time" id="opening_time_{{ $index }}" 
                        name="workingHours[{{ $index }}][opening_time]" 
                        value="{{ old('workingHours.'.$index.'.opening_time', $day->opening_time) }}" 
                        class="mt-1 p-2 w-full border rounded-md">

                    <input type="time" id="closing_time_{{ $index }}" 
                        name="workingHours[{{ $index }}][closing_time]" 
                        value="{{ old('workingHours.'.$index.'.closing_time', $day->closing_time) }}" 
                        class="mt-1 p-2 w-full border rounded-md">

                    <button @click.prevent="$dispatch('open-schedule-modal', {{ $day->id }}); console.log('Event Dispatched')"
                        class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">
                        Edit
                    </button>
                </div>
            @endforeach
        </div>

            @foreach ($driving_school->workingHours as $index => $day)
                <div x-data="{ show: false }" 
                    @open-schedule-modal.window="show = ($event.detail == {{ $day->id }})"
                    x-show="show"
                    class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
                    style="display: none;">
                    
                    <div class="bg-white p-6 rounded-lg shadow-lg w-1/2">
                        <h2 class="text-xl font-semibold mb-4">Edit Schedule for {{ $day->day_of_week }}</h2>

                        <input id="driving_school_id" name="driving_school_id" type="hidden" value="{{ $driving_school->id }}" readonly>

                        <x-text-input id="user_id" type="hidden" name="user_id" :value="auth()->user()->id"/>

                        <form method="POST" action="{{  route('working_hours.update', $day->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Opening Time Input -->
                            <label class="block text-gray-700 font-semibold mb-2">Opening Time:</label>
                            <input type="time" name="workingHours[{{ $day->id }}][opening_time]" 
                                value="{{ old('workingHours.'.$day->id.'.opening_time', $day->opening_time) }}" 
                                class="mt-1 p-2 w-full border rounded-md">

                            <!-- Closing Time Input -->
                            <label class="block text-gray-700 font-semibold mt-4 mb-2">Closing Time:</label>
                            <input type="time" name="workingHours[{{ $day->id }}][closing_time]" 
                                value="{{ old('workingHours.'.$day->id.'.closing_time', $day->closing_time) }}" 
                                class="mt-1 p-2 w-full border rounded-md">

                            <!-- Action Buttons -->
                            <div class="flex justify-end mt-6">
                                <button type="button" @click="show = false" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach


    </div>
</x-app-layout>
