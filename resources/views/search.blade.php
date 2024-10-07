<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Driving Schools</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-4">Search Driving Schools</h1>
    <form action="/search" method="POST" class="mb-8">
        @csrf
        <div class="mb-4">
            <label for="address" class="block text-gray-700">Address or Name:</label>
            <input type="text" id="address" name="address" class="mt-1 block w-full border-gray-300 rounded-md" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Search</button>
    </form>

    @if(isset($driving_schools) && $driving_schools->isNotEmpty())
    <h2 class="text-2xl font-bold mb-4">Driving Schools</h2>
    <ul>
        @foreach($driving_schools as $driving_school)
        <li class="mb-2">
            <strong>{{ $driving_school->name }}</strong><br>
            {{ $driving_school->location }}
        </li>
        @endforeach
    </ul>
    @else
    <p class="text-red-500">{{ $message }}</p>
    @endif
</div>
</body>
</html>
