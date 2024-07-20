<x-guest-layout>
        <form method="POST" action="{{ route('register.postStep3') }}" enctype="multipart/form-data">
        @csrf

        <div>
        <x-input-label for="driving_school_id" :value="__('Driving School ID')" />
        <input id="driving_school_id" name="driving_school_id" type="text" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ $driving_school_id }}" readonly>
        <x-input-error :messages="$errors->get('driving_school_id')" class="mt-2" />
        </div>

        <x-text-input id="user_id" type="hidden" name="user_id" :value="auth()->user()->id"/>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="phone_number" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
