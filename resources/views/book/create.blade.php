@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Book a Driving Lesson at {{ $school->location }}</h1>
    <div class="bg-white rounded shadow p-6">
        <form action="{{ route('book.store', $school->id) }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="school" class="block text-sm font-medium text-gray-700">Driving School</label>
                <input type="text" id="school" name="school" value="{{ $school->location }}" readonly class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
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
                <label for="time" class="block text-sm font-medium text-gray-700">Select Time</label>
                <input type="time" id="time" name="time" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
            </div>
            <div>
                <label for="lesson_type" class="block text-sm font-medium text-gray-700">Select Lesson Type</label>
                <select id="lesson_type" name="lesson_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    <option value="">Select lesson type</option>
                    <option value="8">Code 8</option>
                    <option value="10">Code 10</option>
                    <option value="14">Code 14</option>
                </select>
            </div>
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Select Payment Method</label>
                <select id="payment_method" name="payment_method" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                    <option value="">Select payment method</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>
            <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
    Book Now
</button>
</div>
        </form>
    </div>
</div>
@endsection
