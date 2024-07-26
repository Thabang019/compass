<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Profile Picture Section -->
        <div class="flex items-center gap-4">
            @if ($drivingSchoolData->image)
            <img src="{{ asset('storage/' . $drivingSchoolData->image) }}" alt="Profile Photo"  class="w-24 h-24 rounded-full object-cover">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No Photo</span>
                </div>
            @endif

            <div>
                <x-input-label for="image" :value="__('Profile Photo')" class="text-blue-500"/>
                <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" />
                <x-input-error class="mt-2" :messages="$errors->get('image')" />
            </div>
        </div>

        
        <!-- Registration Number -->
        <div>
            <x-input-label for="registration_number" :value="__('Driving School Registration Number')" class="text-blue-500"/>
            <x-text-input id="registration_number" name="registration_number" type="text" class="mt-1 block w-full" :value="old('registration_number', $drivingSchoolData->registration_number)" required autofocus autocomplete="registration_number" />
            <x-input-error class="mt-2" :messages="$errors->get('registration_number')" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-blue-500"/>
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-blue-500"/>
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Phone Number -->
        <div>
            <x-input-label for="phone_number" :value="__('Phone Number')" class="text-blue-500"/>
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $drivingSchoolData->phone_number)" required autofocus autocomplete="phone_number" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        <!-- Location -->
        <div>
            <x-input-label for="location" :value="__('Location')" class="text-blue-500"/>
            <x-text-input id="location" name="location" type="text" class="mt-1 block w-full" :value="old('location', $drivingSchoolData->location)" required autofocus autocomplete="location" />
            <x-input-error class="mt-2" :messages="$errors->get('location')" />
        </div>

        <!-- Status -->
        <div>
            <x-input-label for="status" :value="__('Status')" class="text-blue-500"/>
            <x-text-input id="status" name="status" type="text" class="mt-1 block w-full" :value="old('status', $drivingSchoolData->status)" autofocus autocomplete="status" />
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
