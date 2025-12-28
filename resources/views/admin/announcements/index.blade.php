<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengumuman Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Create Announcement Form -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Buat Pengumuman Baru') }}
                    </h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Bagikan informasi penting kepada seluruh warga.') }}
                    </p>
                </header>

                <form method="post" action="{{ route('admin.announcements.store') }}" class="mt-6 space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="title" :value="__('Judul')" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus autocomplete="title" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="content" :value="__('Isi Pengumuman')" />
                        <textarea id="content" name="content" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" rows="4" required>{{ old('content') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('content')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Terbitkan') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- List of Announcements -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Daftar Pengumuman</h3>
                @foreach($announcements as $announcement)
                    @php
                        // Format pesan WhatsApp
                        $pesanWA = "*PENGUMUMAN RT 35 - WargaConnect*" . chr(10) . chr(10);
                        $pesanWA .= "📢 *" . $announcement->title . "*" . chr(10);
                        $pesanWA .= "-----------------------------------" . chr(10);
                        $pesanWA .= Str::limit($announcement->content, 150) . chr(10) . chr(10);
                        $pesanWA .= "Selengkapnya silakan login ke:" . chr(10);
                        $pesanWA .= "https://rt35.simpleakunting.my.id/login";
                        
                        $encodedPesan = urlencode($pesanWA);
                    @endphp
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg relative">
                        <div class="flex justify-between items-start">
                            <div class="flex-grow">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $announcement->title }}</h3>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $announcement->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <!-- Share WA Button -->
                                <a href="https://wa.me/?text={{ $encodedPesan }}" 
                                   target="_blank" 
                                   class="inline-flex items-center px-3 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.27 9.27 0 01-4.487-1.164l-.325-.193-3.328.873.888-3.246-.211-.336a9.263 9.263 0 01-1.422-4.903c0-5.113 4.158-9.27 9.274-9.27 2.477 0 4.806.964 6.556 2.716a9.215 9.215 0 012.713 6.557c0 5.116-4.158 9.274-9.274 9.274m7.983-17.255A10.875 10.875 0 0012.05 1.54C6.012 1.54 1.108 6.445 1.105 12.484a10.835 10.835 0 001.465 5.437L1.05 22.5l4.706-1.233a10.817 10.817 0 005.291 1.385h.005c6.037 0 10.943-4.904 10.946-10.945a10.833 10.833 0 00-3.268-7.74z"></path>
                                    </svg>
                                    Share WA
                                </a>
                                <!-- Delete Button -->
                                <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <span class="material-symbols-outlined">delete</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="mt-4 text-gray-600 dark:text-gray-300 whitespace-pre-line">
                            {{ $announcement->content }}
                        </div>
                    </div>
                @endforeach

                @if($announcements->isEmpty())
                    <div class="p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg text-center text-gray-500">
                        {{ __('Belum ada pengumuman yang diterbitkan.') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
