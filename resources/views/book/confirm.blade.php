<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Confirm and Pay</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-md">
            <!-- Personal Details Section -->
            <h2 class="text-xl font-semibold mb-4">Personal Details</h2>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone Number:</strong> {{ $user->phone_number ?? 'N/A' }}</p> 
            
            <!-- Booking Details Section -->
            <h2 class="text-xl font-semibold mt-6 mb-4">Booking Details</h2>
            <ul>
                @if($bookings->isEmpty())
                    <li>No bookings available.</li>
                @else
                    @foreach($bookings as $booking)
                        <li>
                            <strong>Booking #{{ $booking->id }}:</strong> 
                            {{ $booking->hours }} hour(s) @ R200 per hour
                            <p><strong>Lesson:</strong> {{ $booking->lesson->title ?? 'N/A' }}</p>
                            <p><strong>Date:</strong> {{ $booking->date }}</p>
                            <p><strong>Time:</strong> {{ $booking->time }}</p>
                            <p><strong>Instructor:</strong> {{ $booking->instructor->name ?? 'N/A' }}</p>
                            <p><strong>Hours Booked:</strong> {{ $booking->hours }}</p>
                        </li>
                        <hr class="my-2">
                    @endforeach
                @endif
            </ul>
            
            <!-- Total Cost Section -->
            <h2 class="text-xl font-semibold mt-6 mb-4">Total Cost: R{{ $totalCost }}</h2>
            
            <!-- Payment Form Section -->
            <form action="{{ route('book.pay') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="amount" class="block font-medium text-gray-700">Enter Amount to Pay:</label>
                    <input type="number" name="amount" id="amount" class="border p-2 rounded w-full" min="1" required>
                </div>
                
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Pay Now</button>
            </form>

            <!-- Error Display Section -->
            @if($errors->any())
                <div class="text-red-500 mt-4">
                    <strong>{{ $errors->first() }}</strong>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

