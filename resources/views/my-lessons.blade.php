<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Main Heading -->
        <h2 class="text-4xl font-bold mb-8 text-center text-blue-600">{{ __('My Lessons') }}</h2>

        @if($bookings->isEmpty())
            <div class="alert alert-info bg-gray-100 text-gray-700 p-4 rounded-lg">
                <p>{{ __('You have no lessons booked.') }}</p>
            </div>
        @else
            @foreach($bookings as $booking)
                <!-- Card Structure -->
                <div class="card mb-6 shadow-lg rounded-lg overflow-hidden">
                    <div class="card-header bg-blue-600 text-white p-4">
                        <h4 class="mb-0">{{ __('Driving School:') }} {{ $booking->driving_school_name }}</h4>
                    </div>
                    <div class="card-body bg-gray-50 p-6">
                        <!-- Booking ID -->
                        <div class="mb-4">
                            <h5 class="font-semibold text-gray-800">{{ __('Booking ID:') }}  {{ $booking->id }}</h5> 
                        </div>
                        <!-- Lesson Type -->
                        <div class="mb-4">
                            <h5 class="font-semibold text-gray-800">{{ __('Lesson Type(Code):') }} {{ $booking->lessons->first()->lesson_type ?? 'N/A' }}</h5>  
                        </div>
                        <!-- Lessons List -->
                        <div class="mb-4">
                            <h5 class="font-semibold text-gray-800">{{ __('Scheduled Lesson:') }}</h5>
                            @if($booking->lessons->isEmpty())
                                <p>{{ __('No lessons scheduled for this booking.') }}</p>
                            @else
                                <ul class="list-group list-disc pl-5">
                                    @foreach($booking->lessons as $lesson)
                                        <li class="list-group-item bg-white p-4 mb-2 rounded-lg shadow-sm">
                                            <strong class="text-gray-700">{{ __('Lesson Date:') }}</strong> {{ $lesson->date }}<br>
                                            <strong class="text-gray-700">{{ __('Start Time:') }}</strong> {{ $lesson->start_time }}<br>
                                            <strong class="text-gray-700">{{ __('End Time:') }}</strong> {{ $lesson->end_time }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
