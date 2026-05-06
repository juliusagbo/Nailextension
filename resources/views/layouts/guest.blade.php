<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            /* Additional responsive styles */
            @media (max-width: 640px) {
                .auth-container {
                    padding: 1rem !important;
                    margin: 0.75rem !important;
                    border-radius: 12px !important;
                }
                
                .auth-logo {
                    width: 60px !important;
                    height: 60px !important;
                }
            }
            
            @media (max-width: 480px) {
                .auth-container {
                    padding: 1rem !important;
                    margin: 0.5rem !important;
                    border-radius: 8px !important;
                }
                
                .auth-logo {
                    width: 50px !important;
                    height: 50px !important;
                }
                
                body {
                    font-size: 14px;
                }
            }
            
            /* Improve form input touch targets on mobile */
            @media (max-width: 768px) {
                input, button, select, textarea {
                    font-size: 16px !important; /* Prevents zoom on iOS */
                    min-height: 44px; /* Better touch targets */
                }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4 sm:px-6 bg-gray-100 dark:bg-gray-900">
            <div class="mb-4 sm:mb-6">
                <a href="/">
                    <x-application-logo class="auth-logo w-16 h-16 sm:w-20 sm:h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="auth-container w-full sm:max-w-md md:max-w-lg mt-2 sm:mt-6 px-4 sm:px-6 py-6 sm:py-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden rounded-lg sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
