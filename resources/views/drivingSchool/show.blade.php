<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="flex flex-wrap -mx-4">
            <div class="w-full lg:w-1/2 px-4 mb-4 lg:mb-0">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    @if ($drivingSchool->image)
                        <img src="{{ asset($drivingSchool->image) }}" alt="{{ $drivingSchool->school_name }} Image" class="w-full h-auto rounded-lg mb-4 shadow-md">
                    @endif
                    <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ $drivingSchool->school_name }}</h1>
                    <p class="text-lg mb-2"><span class="font-semibold">Registration Number:</span> {{ $drivingSchool->registration_number }}</p>
                    <p class="text-lg mb-2"><span class="font-semibold">Email: {{ $drivingSchool->user->email }}</p>
                    <p class="text-lg mb-2"><span class="font-semibold">Phone Number:</span> {{ $drivingSchool->phone_number }}</p>
                    <p class="text-lg mb-2"><span class="font-semibold">Location:</span> {{ $drivingSchool->location }}</p>
                    <p class="text-lg mb-2"><span class="font-semibold">Latitude:</span> {{ $drivingSchool->latitude }}</p>
                    <p class="text-lg mb-2"><span class="font-semibold">Longitude:</span> {{ $drivingSchool->longitude }}</p>
                    <p class="text-lg mb-2"><span class="font-semibold">Status:</span> {{ ucfirst($drivingSchool->status) }}</p>
                    
                    <form action="{{ route('drivingSchools.updateStatus', $drivingSchool) }}" method="POST" class="mt-6 flex space-x-4">
                        @csrf
                        <button type="submit" name="status" value="approved" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Approve</button>
                        <button type="submit" name="status" value="rejected" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Reject</button>
                        <a href="{{ route('systemAdmin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Cancel</a>
                    </form>

                    @if(session('status'))
                        <div class="mt-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="w-full lg:w-1/2 px-4">
                <div class="bg-white  h-full p-6 rounded-lg shadow-md">
                    <iframe src="{{ asset($drivingSchool->certificate) }}" class="w-full h-full rounded-lg shadow-md"></iframe>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
