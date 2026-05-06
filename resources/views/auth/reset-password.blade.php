<x-guest-layout>
    <style>
        /* Responsive styles for reset password page */
        @media (max-width: 640px) {
            .reset-password-actions {
                justify-content: stretch !important;
            }
            
            .reset-password-actions button {
                width: 100%;
                justify-content: center;
            }
        }
        
        @media (max-width: 480px) {
            .reset-form-group {
                margin-top: 0.875rem !important;
            }
        }
    </style>
    
    <div class="mb-4 text-sm sm:text-base text-gray-600 dark:text-gray-400">
        {{ __('Enter your new password below.') }}
    </div>
    
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm sm:text-base" />
            <x-text-input id="email" class="block mt-1 w-full text-base" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs sm:text-sm" />
        </div>

        <!-- Password -->
        <div class="reset-form-group mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-sm sm:text-base" />
            <x-text-input id="password" class="block mt-1 w-full text-base" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs sm:text-sm" />
        </div>

        <!-- Confirm Password -->
        <div class="reset-form-group mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm sm:text-base" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full text-base"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs sm:text-sm" />
        </div>

        <div class="reset-password-actions flex items-center justify-end mt-6">
            <x-primary-button class="w-full sm:w-auto justify-center">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
