<x-guest-layout>
    <style>
        /* Responsive styles for confirm password page */
        @media (max-width: 640px) {
            .confirm-password-actions {
                justify-content: stretch !important;
            }
            
            .confirm-password-actions button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    
    <div class="mb-4 text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm sm:text-base" />
            <x-text-input id="password" class="block mt-1 w-full text-base"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs sm:text-sm" />
        </div>

        <div class="confirm-password-actions flex justify-end mt-6">
            <x-primary-button class="w-full sm:w-auto justify-center">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
