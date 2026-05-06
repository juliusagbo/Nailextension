<x-guest-layout>
    <style>
        /* Responsive styles for forgot password page */
        @media (max-width: 640px) {
            .forgot-password-actions {
                justify-content: stretch !important;
            }
            
            .forgot-password-actions button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    
    <div class="mb-4 text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-sm sm:text-base" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm sm:text-base" />
            <x-text-input id="email" class="block mt-1 w-full text-base" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs sm:text-sm" />
        </div>

        <div class="forgot-password-actions flex items-center justify-end mt-6">
            <x-primary-button class="w-full sm:w-auto justify-center">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
