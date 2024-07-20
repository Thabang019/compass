<x-guest-layout>


<form method="POST" action="{{ route('register.postStep2') }}" enctype="multipart/form-data">
@csrf

        <!-- Registration Number -->
        <div>
            <x-input-label for="registration_number" :value="__('Registration Number')" />
            <x-text-input id="registration_number" class="block mt-1 w-full" type="text" name="registration_number" :value="old('registration_number')" required autofocus autocomplete="registration_number" />
            <x-input-error :messages="$errors->get('registration_number')" class="mt-2" />
        </div>

        <!-- Code -->
        <div class="mt-4">
            <x-input-label for="code" :value="__('Code')" />
            <select id="code" name="code" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
                <option value="8">8</option>    
                <option value="10">10</option>
                <option value="14">14</option>
            </select>
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <!-- VIN Number -->
        <div class="mt-4">
            <x-input-label for="vin_number" :value="__('VIN Number')" />
            <x-text-input id="vin_number" class="block mt-1 w-full" type="text" name="vin_number" :value="old('vin_number')" required autocomplete="vin_number" />
            <x-input-error :messages="$errors->get('vin_number')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
