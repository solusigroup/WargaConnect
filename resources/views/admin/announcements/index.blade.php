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
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg relative">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $announcement->title }}</h3>
                                <span class="text-xs text-gray-500 dark:text-gray-400">{{ $announcement->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
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
