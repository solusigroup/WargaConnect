<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'WargaConnect') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-900 font-sans">
    <div class="relative min-h-screen flex flex-col justify-center items-center selection:bg-blue-500 selection:text-white bg-gray-50">
        
        <div class="max-w-7xl mx-auto p-6 lg:p-8 w-full">
            <div class="text-center">
                {{-- Logo or Icon --}}
                <div class="flex justify-center mb-8">
                    <div class="bg-blue-700 p-5 rounded-2xl shadow-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>

                <h1 class="text-6xl font-extrabold text-gray-900 mb-6 tracking-tight">WargaConnect</h1>
                <p class="text-2xl text-gray-800 mb-10 max-w-2xl mx-auto leading-relaxed">
                    Sistem Informasi Manajemen Warga & Iuran Lingkungan <span class="text-blue-700 font-bold">RT 35</span>
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-6 mt-8">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-10 py-4 bg-blue-700 text-white text-lg rounded-xl font-bold hover:bg-blue-800 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-3 transform hover:-translate-y-1">
                                <span>Akses Dashboard</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-10 py-4 bg-blue-700 text-white text-lg rounded-xl font-bold hover:bg-blue-800 transition shadow-lg hover:shadow-xl flex items-center justify-center gap-3 transform hover:-translate-y-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011 1v12a1 1 0 11-2 0V4a1 1 0 011-1zm7.707 3.293a1 1 0 010 1.414L9.414 9H17a1 1 0 110 2H9.414l1.293 1.293a1 1 0 01-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Masuk (Login)</span>
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-10 py-4 bg-gray-900 text-white text-lg border border-transparent rounded-xl font-bold hover:bg-black transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                    Daftar Warga Baru
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>

            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div class="text-blue-500 mb-4 flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Manajemen Iuran</h3>
                    <p class="text-gray-500 text-sm">Bayar dan pantau iuran lingkungan dengan mudah dan transparan.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div class="text-green-500 mb-4 flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Info Warga & Pengumuman</h3>
                    <p class="text-gray-500 text-sm">Dapatkan informasi terkini seputar kegiatan dan pengumuman RT.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center">
                    <div class="text-red-500 mb-4 flex justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Layanan Aduan</h3>
                    <p class="text-gray-500 text-sm">Sampaikan aspirasi dan laporan kendala di lingkungan secara langsung.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
