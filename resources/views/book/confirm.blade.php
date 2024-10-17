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
            <div class="mt-6">
                <h2 class="text-2xl font-bold mb-4">Your Bookings</h2>
                    <ul id="checkout-booking-list" class="space-y-4">
                        <!-- Bookings will be appended here -->
                    </ul>

                <div id="total-price" class="mt-4 font-bold">Total Price: R 0.00</div> <!-- Corrected ID -->
                <!-- Confirm and Pay Button -->
            </div>
            
            <!-- Payment Form Section -->
            <form action="/session" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="amount" class="block font-medium text-gray-700">Enter Amount to Pay:</label>
                    <input type="number" id="total-price" name="amount" id="amount" class="border p-2 rounded w-full" min="1" required>
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

    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const bookings = JSON.parse(localStorage.getItem('bookings'));

            if (bookings && bookings.length > 0) {
                const bookingList = document.getElementById('checkout-booking-list');
                const drivingSchoolDetails = document.getElementById('driving-school-details');
                const firstBooking = bookings[0]; // Assume all bookings are from the same driving school
                const drivingSchool = firstBooking.school;

                bookings.forEach((booking) => {
                    const bookingItem = `
                        <li class="p-4 bg-gray-100 rounded shadow">
                            <p><strong>Date:</strong> ${booking.date}</p>
                            <p><strong>Time:</strong> ${booking.time} - ${booking.endTime}</p>
                            <p><strong>Duration:</strong> ${booking.duration} hour(s)</p>
                            <p><strong>Lesson Type:</strong> Code ${booking.lessonType}</p>
                            <p><strong>Vehicle:</strong> ${booking.vehicle.registration_number}</p>
                            <p><strong>Instructor:</strong> ${booking.instructor.name}</p>
                            <p><strong>Lesson Price:</strong> R ${booking.totalPrice}</p>
                        </li>
                    `;
                    bookingList.insertAdjacentHTML('beforeend', bookingItem);
                });

                // Display the driving school details (assume all bookings are from the same school)
                const schoolDetails = `
                    <p><strong>School Name:</strong> ${drivingSchool.school_name}</p>
                    <p><strong>Location:</strong> ${drivingSchool.location}</p>
                    <p><strong>Contact:</strong> ${drivingSchool.phone_number}</p>
                `;
                drivingSchoolDetails.innerHTML = schoolDetails;

                // Display the total price
                const totalPrice = bookings.reduce((total, booking) => total + booking.totalPrice, 0);
                document.getElementById('total-price').textContent = `Total Price: R ${totalPrice.toFixed(2)}`;
            } else {
                alert('No bookings found for checkout.');
            }
        });

    </script>
</x-app-layout>
