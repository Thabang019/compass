<!-- resources/views/bookings/confirm.blade.php -->

<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6">Confirm Your Bookings</h1>

        <div class="bg-white rounded shadow p-6">
            <ul class="space-y-4">
                @foreach ($bookings as $booking)
                    <li class="p-4 bg-gray-100 rounded shadow">
                        <p>Date: {{ $booking['date'] }}</p>
                        <p>Time: {{ $booking['time'] }} - {{ $booking['endTime'] }}</p>
                        <p>Duration: {{ $booking['duration'] }} hour(s)</p>
                        <p>Lesson Type: Code {{ $booking['lessonType'] }}</p>
                    </li>
                @endforeach
            </ul>

            <div class="mt-6">
                <button type="button" id="pay-button" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Pay Now
                </button>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        alert('Proceeding to payment...');
        // You can implement the payment logic here
    });
</script>
