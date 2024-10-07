<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">{{ $school->school_name }}</h1>
        <div class="bg-white rounded shadow p-6">
            <form id="booking-form" class="space-y-6">
                @csrf
                <div>
                    <label for="school" class="block text-sm font-medium text-gray-700">Driving School Name</label>
                    <input type="text" id="school" name="school" value="{{ $school->school_name }}" readonly class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                <div>
                    <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number</label>
                    <input type="text" id="registration_number" name="registration_number" value="{{ $school->registration_number }}" readonly class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700">Select Date</label>
                    <input type="date" id="date" name="date" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                <div>
                    <label for="time" class="block text-sm font-medium text-gray-700">Select Start Time</label>
                    <input type="time" id="time" name="time" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                <div>
                    <label for="duration" class="block text-sm font-medium text-gray-700">Select Duration</label>
                    <select id="duration" name="duration" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        <option value="1">1 hour</option>
                        <option value="2">2 hours</option>
                        <option value="3">3 hours</option>
                    </select>
                </div>
                <div>
                    <label for="lesson_type" class="block text-sm font-medium text-gray-700">Select Lesson Type</label>
                    <select id="lesson_type" name="lesson_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        <option value="8">Code 8</option>
                        <option value="10">Code 10</option>
                        <option value="14">Code 14</option>
                    </select>
                </div>
                <div>
                    <button type="button" id="add-booking" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Booking
                    </button>
                </div>
            </form>
        </div>

        <!-- Display the list of bookings here -->
        <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Your Bookings</h2>
            <ul id="booking-list" class="space-y-4">
                <!-- Bookings will be appended here -->
            </ul>
            <div class="mt-6">
                <button type="button" id="confirm-bookings" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                    Confirm and Pay
                </button>
            </div>
        </div>
    </div>

    <script>
        let bookings = [];

        document.getElementById('add-booking').addEventListener('click', function() {
            const date = document.getElementById('date').value;
            const time = document.getElementById('time').value;
            const duration = document.getElementById('duration').value;
            const lessonType = document.getElementById('lesson_type').value;

            if (date && time && duration && lessonType) {
                const endTime = calculateEndTime(time, duration);
                const booking = {
                    date,
                    time,
                    endTime,
                    duration,
                    lessonType
                };

                bookings.push(booking);
                updateBookingList();
                document.getElementById('booking-form').reset(); // Clear the form fields
            } else {
                alert('Please fill in all fields.');
            }
        });

        function updateBookingList() {
            const bookingList = document.getElementById('booking-list');
            bookingList.innerHTML = ''; // Clear the current list

            bookings.forEach((booking, index) => {
                const bookingItem = `
                    <li class="p-4 bg-gray-100 rounded shadow">
                        <p>Date: ${booking.date}</p>
                        <p>Time: ${booking.time} - ${booking.endTime}</p>
                        <p>Duration: ${booking.duration} hour(s)</p>
                        <p>Lesson Type: Code ${booking.lessonType}</p>
                        <button onclick="removeBooking(${index})" class="text-red-500 hover:text-red-700">Remove</button>
                    </li>
                `;
                bookingList.insertAdjacentHTML('beforeend', bookingItem);
            });
        }

        // Function to remove a booking from the list
        function removeBooking(index) {
            bookings.splice(index, 1); // Remove the booking at the given index
            updateBookingList(); // Update the display
        }

        document.getElementById('confirm-bookings').addEventListener('click', function() {
            // Implement the logic to handle the confirmation and payment
            alert('Bookings confirmed. Proceed to payment.');
        });

        function calculateEndTime(startTime, duration) {
            const [hours, minutes] = startTime.split(':').map(Number);
            const endHours = (hours + parseInt(duration)) % 24;
            const endTime = `${String(endHours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
            return endTime;
        }
    </script>
</x-app-layout>

