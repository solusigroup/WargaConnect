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
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-50 dark:bg-gray-900">
            <div class="mb-6">
                <a href="/" class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-xl bg-primary flex items-center justify-center text-white font-bold text-2xl shadow-lg">W</div>
                    <span class="font-bold text-xl tracking-tight text-gray-800 dark:text-white">WargaConnect</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} WargaConnect RT 35
            </div>
        </div>
    </body>
</html>
