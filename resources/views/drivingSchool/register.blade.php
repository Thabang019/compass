<x-guest-layout>
    <form method="POST" action="{{ route('register.postStep1') }}" enctype="multipart/form-data">
        @csrf

        <!-- Registration Number -->
        <div>
            <x-input-label for="registration_number" :value="__('Registration Number *')" />
            <x-text-input id="registration_number" class="block mt-1 w-full" type="text" name="registration_number" :value="old('registration_number')" required autofocus autocomplete="registration_number" />
            <x-input-error :messages="$errors->get('registration_number')" class="mt-2" />
        </div>

        <x-text-input id="user_id" type="hidden" name="user_id" :value="auth()->user()->id"/>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number *')" />
            <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required autocomplete="phone_number" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Image -->
        <div class="mt-4">
            <x-input-label for="image" :value="__('Image')" />
            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" autocomplete="image" />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <!-- Location -->
        <div class="mt-4">
            <x-input-label for="location" :value="__('Location *')" />
            <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location')" required autocomplete="location" />
            <x-input-error :messages="$errors->get('location')" class="mt-2" />
        </div>

        <!-- Latitude -->
        <div class="mt-4">
            <x-input-label for="latitude" :value="__('Latitude *')" />
            <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude" :value="old('latitude')" required autocomplete="latitude" />
            <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
        </div>

        <!-- Longitude -->
        <div class="mt-4">
            <x-input-label for="longitude" :value="__('Longitude *')" />
            <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude" :value="old('longitude')" required autocomplete="longitude" />
            <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
        </div>

        <!-- Certificate -->
        <div class="mt-4">
            <x-input-label for="certificate" :value="__('Certificate *')" />
            <x-text-input id="certificate" class="block mt-1 w-full" type="file" name="certificate" required autocomplete="certificate" />
            <x-input-error :messages="$errors->get('certificate')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
