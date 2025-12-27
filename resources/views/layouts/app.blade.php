<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WargaConnect') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <!-- Icons -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <script>
            tailwind.config = {
                darkMode: "class",
                theme: {
                    extend: {
                        colors: {
                            "primary": "#137fec",
                        },
                        fontFamily: {
                            "sans": ["Inter", "sans-serif"]
                        }
                    },
                },
            }
        </script>
    </head>
    <body class="font-sans antialiased bg-[#f8fbff] dark:bg-[#111a22]">
        <div class="min-h-screen flex flex-col pb-20 md:pb-0">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-[#1A2633] shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                {{ $slot }}
            </main>

            <!-- Sticky Bottom Navigation (Mobile Only) -->
            <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-[#1A2633] border-t border-[#e7edf3] dark:border-slate-800 pb-safe pt-3 px-6 z-50">
                <div class="flex justify-around items-center h-16 max-w-lg mx-auto">
                    <!-- Home -->
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 group w-16 {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-[#98a2b3] dark:text-slate-500 hover:text-primary' }}">
                        <div class="relative">
                            <span class="material-symbols-outlined text-[26px] transition-transform group-active:scale-90">home</span>
                            @if(request()->routeIs('dashboard'))
                                <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-1 h-1 bg-primary rounded-full"></span>
                            @endif
                        </div>
                        <span class="text-[10px] font-bold">Beranda</span>
                    </a>
                    
                    <!-- History / Bills -->
                    <a href="#" class="flex flex-col items-center gap-1 group w-16 {{ request()->routeIs('resident.bills.*') ? 'text-primary' : 'text-[#98a2b3] dark:text-slate-500 hover:text-primary' }}">
                         <div class="relative">
                            <span class="material-symbols-outlined text-[26px] transition-transform group-active:scale-90">receipt_long</span>
                         </div>
                        <span class="text-[10px] font-medium">Riwayat</span>
                    </a>

                    <!-- Scan QR (Center) -->
                    <div class="flex flex-col items-center -mt-8 cursor-pointer">
                         <button class="h-14 w-14 rounded-full bg-primary text-white flex items-center justify-center shadow-[0_8px_24px_rgba(19,127,236,0.4)] active:scale-95 transition-transform">
                            <span class="material-symbols-outlined text-[28px]">qr_code_scanner</span>
                         </button>
                         <span class="text-[10px] font-medium text-[#4c739a] mt-2">Scan</span>
                    </div>

                    <!-- Notifications -->
                    <a href="#" class="flex flex-col items-center gap-1 group w-16 {{ request()->routeIs('notifications.*') ? 'text-primary' : 'text-[#98a2b3] dark:text-slate-500 hover:text-primary' }}">
                         <div class="relative">
                            <span class="material-symbols-outlined text-[26px] transition-transform group-active:scale-90">notifications</span>
                         </div>
                        <span class="text-[10px] font-medium">Notifikasi</span>
                    </a>
                    
                    <!-- Profile -->
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center gap-1 group w-16 {{ request()->routeIs('profile.edit') ? 'text-primary' : 'text-[#98a2b3] dark:text-slate-500 hover:text-primary' }}">
                         <div class="relative">
                            <span class="material-symbols-outlined text-[26px] transition-transform group-active:scale-90">person</span>
                            @if(request()->routeIs('profile.edit'))
                                <span class="absolute -bottom-2 left-1/2 -translate-x-1/2 w-1 h-1 bg-primary rounded-full"></span>
                            @endif
                         </div>
                        <span class="text-[10px] font-medium">Profil</span>
                    </a>
                </div>
            </nav>
        </div>
        @yield('scripts')
    </body>
</html>
