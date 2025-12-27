<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Kategori Iuran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('admin.contribution-categories.store') }}" class="space-y-6">
                        @csrf

                        <!-- Nama Iuran -->
                        <div>
                            <x-input-label for="nama_iuran" :value="__('Nama Iuran')" />
                            <x-text-input id="nama_iuran" class="block mt-1 w-full" type="text" name="nama_iuran" :value="old('nama_iuran')" required autofocus placeholder="Contoh: Iuran Kebersihan" />
                            <x-input-error :messages="$errors->get('nama_iuran')" class="mt-2" />
                        </div>

                        <!-- Nominal -->
                        <div>
                            <x-input-label for="nominal" :value="__('Nominal (Rp)')" />
                            <x-text-input id="nominal" class="block mt-1 w-full" type="number" name="nominal" :value="old('nominal')" required placeholder="Contoh: 50000" min="0" />
                            <x-input-error :messages="$errors->get('nominal')" class="mt-2" />
                        </div>

                        <!-- Is Mandatory -->
                        <div class="block mt-4">
                            <label for="is_mandatory" class="inline-flex items-center">
                                <input id="is_mandatory" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="is_mandatory" value="1" {{ old('is_mandatory') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Wajib Dibayar?') }}</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-6">Jika dicentang, semua warga wajib membayar iuran ini setiap bulan.</p>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-4">
                            <a href="{{ route('admin.contribution-categories.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
