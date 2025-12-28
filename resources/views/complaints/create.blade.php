<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Buat Aduan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <x-input-label for="title" :value="__('Judul Aduan')" />
                            <x-text-input id="title" class="block mt-1 w-full text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-900 border-gray-300 dark:border-gray-700" type="text" name="title" :value="old('title')" required autofocus placeholder="Contoh: Lampu Jalan Mati di Blok A" />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Masalah')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required placeholder="Jelaskan detail masalahnya...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="image" :value="__('Bukti Foto (Opsional)')" />
                            <input id="image" type="file" name="image" class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 2MB).</p>
                            <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Kirim Aduan') }}</x-primary-button>
                            <a href="{{ route('complaints.index') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">Batal</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
