<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite('resources/css/app.css')
        
        <style>
            /* Global responsive styles */
            html {
                scroll-behavior: smooth;
            }
            
            /* Tablet Styles */
            @media (max-width: 1024px) {
                .max-w-7xl {
                    max-width: 100%;
                }
            }
            
            /* Mobile Styles */
            @media (max-width: 768px) {
                body {
                    font-size: 14px;
                }
                
                h1 {
                    font-size: 1.5rem !important;
                }
                
                h2 {
                    font-size: 1.25rem !important;
                }
                
                h3 {
                    font-size: 1.1rem !important;
                }
                
                /* Better touch targets */
                button, a, input, select, textarea {
                    min-height: 44px;
                }
                
                /* Prevent iOS zoom on input focus */
                input, select, textarea {
                    font-size: 16px !important;
                }
            }
            
            /* Extra Small Mobile */
            @media (max-width: 480px) {
                body {
                    font-size: 13px;
                }
                
                h1 {
                    font-size: 1.3rem !important;
                }
                
                h2 {
                    font-size: 1.15rem !important;
                }
                
                h3 {
                    font-size: 1rem !important;
                }
            }
            
            /* Header responsive */
            @media (max-width: 768px) {
                header {
                    padding-top: 1rem !important;
                    padding-bottom: 1rem !important;
                }
                
                header .max-w-7xl {
                    padding-left: 1rem !important;
                    padding-right: 1rem !important;
                }
            }
            
            @media (max-width: 480px) {
                header {
                    padding-top: 0.75rem !important;
                    padding-bottom: 0.75rem !important;
                }
                
                header .max-w-7xl {
                    padding-left: 0.75rem !important;
                    padding-right: 0.75rem !important;
                }
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-white">

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-4 sm:py-6 px-3 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="pb-8 sm:pb-12">
                @yield('content')
            </main>
        </div>
    </body>
</html>
