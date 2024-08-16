<x-app-layout>
    
<<div class="container mx-auto px-4 py-8">
    <div class="bg-white p-6 rounded-lg shadow-md flex flex-wrap lg:flex-nowrap">
        @if ($drivingSchool->image)
            <div class="w-full lg:w-1/3 mb-4 lg:mb-0 lg:mr-6">
                <img src="{{ asset($drivingSchool->image) }}" alt="{{ $drivingSchool->school_name }} Image" class="w-full h-auto rounded-lg">
            </div>
        @endif
        <div class="w-full lg:w-2/3">
            <h1 class="text-3xl font-bold mb-4">{{ $drivingSchool->school_name }}</h1>
            <p class="text-lg mb-2"><span class="font-semibold">Registration Number:</span> {{ $drivingSchool->registration_number }}</p>
            <p class="text-lg mb-2"><span class="font-semibold">Phone Number:</span> {{ $drivingSchool->phone_number }}</p>
            <p class="text-lg mb-2"><span class="font-semibold">Location:</span> {{ $drivingSchool->location }}</p>
            <p class="text-lg mb-2"><span class="font-semibold">Latitude:</span> {{ $drivingSchool->latitude }}</p>
            <p class="text-lg mb-2"><span class="font-semibold">Longitude:</span> {{ $drivingSchool->longitude }}</p>
            <p class="text-lg mb-2"><span class="font-semibold">Certificate:</span> {{ $drivingSchool->certificate }}</p>
            <p class="text-lg mb-2"><span class="font-semibold">Status:</span> {{ ucfirst($drivingSchool->status) }}</p>
            <iframe src="{{ asset('storage/8fIBfIpocbiYgh7RCZZYAoKsFQMJaTnaqOBFJQjz.pdf') }}" class="w-full h-screen"></iframe>
        </div>
    </div>
</div>

</div>


</x-app-layout>
