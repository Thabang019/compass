<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Driving Schools</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Include Google Maps JavaScript API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDf_v05LInTlJUu7jJXa5Mkoq6sSFSXRRc"></script>
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Search Driving Schools</h1>
    <form action="/search" method="POST" class="mb-8">
        @csrf
        <div class="mb-4">
            <label for="code" class="block text-gray-700">Code:</label>
            <input type="number" id="code" name="code" min="8" max="14" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>
        <div class="mb-4">
            <label for="address" class="block text-gray-700">Address:</label>
            <input type="text" id="address" name="address" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Search</button>
    </form>

    @if(isset($driving_schools) && $driving_schools->isNotEmpty())
    <div class="flex">
        <div class="w-1/2">
            <h2 class="text-2xl font-bold mb-4">Driving Schools</h2>
            <ul>
                @foreach($driving_schools as $driving_school)
                <li class="mb-2">
                    <strong>{{ $driving_school->name }}</strong><br>
                    {{ $driving_school->location }}
                </li>
                @endforeach
            </ul>
        </div>
        <div class="w-1/2">
            <h2 class="text-2xl font-bold mb-4">Map</h2>
            <div id="map" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
    @else
    <p class="text-red-500">No registered driving schools found in the specified location.</p>
    @endif
</div>

@if(isset($driving_schools) && $driving_schools->isNotEmpty())
<script>
function initMap() {
    var center = { lat: {{ $coordinates['latitude'] }}, lng: {{ $coordinates['longitude'] }} };
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: center
    });

    @foreach($driving_schools as $driving_school)
    new google.maps.Marker({
        position: { lat: {{ $driving_school->latitude }}, lng: {{ $driving_school->longitude }} },
        map: map,
        title: "{{ $driving_school->name }}"
    });
    @endforeach
}

google.maps.event.addDomListener(window, 'load', initMap);
</script>
@endif

</body>
</html>
