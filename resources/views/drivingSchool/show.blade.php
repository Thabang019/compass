<x-app-layout>
    
<div class="container">
    <h1>{{ $drivingSchool->name }}</h1>
    <p>Registration Number: {{ $drivingSchool->registration_number }}</p>
    <p>Phone Number: {{ $drivingSchool->phone_number }}</p>
    <p>Location: {{ $drivingSchool->location }}</p>
    <p>Latitude: {{ $drivingSchool->latitude }}</p>
    <p>Longitude: {{ $drivingSchool->longitude }}</p>
    <p>Certificate: {{ $drivingSchool->certificate }}</p>
    <p>Status: {{ ucfirst($drivingSchool->status) }}</p>

    @if ($drivingSchoolData->image)
        <img src="{{$drivingSchoolData->image}}" alt="{{ asset($drivingSchoolData->image) }}" style="max-width: 100%;">
    @endif

    <form action="{{ route('drivingSchools.updateStatus', $drivingSchool) }}" method="POST" class="mt-3">
        @csrf
        <button type="submit" name="status" value="approved" class="btn btn-success">Approve</button>
        <button type="submit" name="status" value="rejected" class="btn btn-danger">Reject</button>
        <button type="submit" name="status" value="pending" class="btn btn-secondary">Cancel</button>
    </form>

    @if(session('status'))
        <div class="alert alert-success mt-3">
            {{ session('status') }}
        </div>
    @endif
</div>

</x-app-layout>
