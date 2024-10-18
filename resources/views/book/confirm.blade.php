<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Confirm and Pay</h1>

        <!-- Error Display Section -->
            @if($errors->any())
                <div class="text-red-500 mt-4">
                    <strong>{{ $errors->first() }}</strong>
                </div>
            @endif
            
        <div class="bg-white p-6 rounded-lg shadow-md">
            <!-- Personal Details Section -->
            <h2 class="text-xl font-semibold mb-4">Personal Details</h2>
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Phone Number:</strong> {{ $user->phone_number ?? 'N/A' }}</p> <!-- Updated to phone_number -->


            <h2 class="text-xl font-semibold mt-6 mb-4">Driving School Details</h2>
            <div id="driving-school-details">
                <!-- Driving School info will be displayed here -->
            </div>
            
            <!-- Booking Details Section -->
            
            <div class="mt-6">
                <h2 class="text-xl font-semibold mt-6 mb-4">Your Bookings</h2>
                    <ul id="checkout-booking-list" class="space-y-4">
                        <!-- Bookings will be appended here -->
                    </ul>

                
                <!-- Confirm and Pay Button -->
            </div>
            
            <!-- Payment Form Section -->
            <form action="/session" method="POST">
                @csrf
                <input type="hidden" name="lessons" id="bookings">
                <input type="hidden" name="drivingSchoolName" id="drivingSchoolName">
                <input type="hidden" name="total" id="total-amount" value="0"> <!-- Hidden input for total amount -->

                <div id="total-price" class="mt-4 mb-4 font-bold">Total Price: R 0.00</div> <!-- Corrected ID -->
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
            const lessons = JSON.parse(localStorage.getItem('lessons')); // Change to lessons

            if (lessons && lessons.length > 0) {
                const bookingList = document.getElementById('checkout-booking-list');
                const drivingSchoolDetails = document.getElementById('driving-school-details');
                const firstLesson = lessons[0]; // Assume all lessons are from the same driving school
                const drivingSchool = firstLesson.school;

                lessons.forEach((lesson) => {
                    const lessonItem = `
                        <li class="p-4 bg-gray-100 rounded shadow">
                            <p><strong>Date:</strong> ${lesson.date}</p>
                            <p><strong>Time:</strong> ${lesson.time} - ${lesson.endTime}</p>
                            <p><strong>Duration:</strong> ${lesson.duration} hour(s)</p>
                            <p><strong>Lesson Type:</strong> Code ${lesson.lessonType}</p>
                            <p><strong>Vehicle:</strong> ${lesson.vehicle.registration_number}</p>
                            <p><strong>Instructor:</strong> ${lesson.instructor.name}</p>
                            <p><strong>Lesson Price:</strong> R ${lesson.totalPrice}</p>
                        </li>
                    `;
                    bookingList.insertAdjacentHTML('beforeend', lessonItem);
                });

                // Display the driving school details (assume all lessons are from the same school)
                const schoolDetails = `
                    <p><strong>Driving School Name:</strong> ${drivingSchool.school_name}</p>
                    <p><strong>Location:</strong> ${drivingSchool.location}</p>
                    <p><strong>Suburb:</strong> ${drivingSchool.suburb}</p>
                    <p><strong>Contact:</strong> ${drivingSchool.phone_number}</p>
                `;
                drivingSchoolDetails.innerHTML = schoolDetails;

                // Display the total price
                const totalPrice = lessons.reduce((total, lesson) => total + lesson.totalPrice, 0);
                document.getElementById('total-price').textContent = `Total Price: R ${totalPrice.toFixed(2)}`;
                document.getElementById('drivingSchoolName').value = drivingSchool.school_name;
                document.querySelector('input[name="total"]').value = totalPrice.toFixed(2);
                document.getElementById('bookings').value = JSON.stringify(lessons); // Changed to lessons
                console.log(JSON.stringify(lessons));
            } else {
                alert('No lessons found for checkout.');
            }
        });

    </script>
</x-app-layout>
