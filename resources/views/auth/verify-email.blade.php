<x-guest-layout>
    <style>
        /* Responsive styles for verify email page */
        @media (max-width: 640px) {
            .verify-actions {
                flex-direction: column-reverse !important;
                gap: 1rem !important;
                align-items: stretch !important;
            }
            
            .verify-actions form {
                width: 100%;
            }
            
            .verify-actions form > div,
            .verify-actions form > button {
                width: 100%;
            }
            
            .verify-actions button {
                width: 100%;
                text-align: center;
                justify-content: center;
                padding: 0.75rem 1rem !important;
            }
        }
        
        @media (max-width: 480px) {
            .verify-message {
                font-size: 0.875rem !important;
                line-height: 1.5 !important;
            }
            
            .verify-success {
                font-size: 0.875rem !important;
            }
        }
    </style>
    
    <div class="verify-message mb-4 text-sm sm:text-base text-gray-600 dark:text-gray-400 leading-relaxed">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="verify-success mb-4 font-medium text-sm sm:text-base text-green-600 dark:text-green-400 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="verify-actions mt-6 flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
            @csrf

            <div>
                <x-primary-button class="w-full sm:w-auto justify-center">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
            @csrf

            <button type="submit" class="w-full sm:w-auto underline text-sm sm:text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 px-4 py-2">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
