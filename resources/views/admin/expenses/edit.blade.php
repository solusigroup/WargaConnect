<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Pengeluaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <form method="POST" action="{{ route('admin.expenses.update', $expense->id) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Judul -->
                        <div>
                            <x-input-label for="judul" :value="__('Judul Pengeluaran')" />
                            <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul" :value="old('judul', $expense->judul)" required autofocus />
                            <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <x-input-label for="deskripsi" :value="__('Deskripsi (Opsional)')" />
                            <textarea id="deskripsi" name="deskripsi" rows="3" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('deskripsi', $expense->deskripsi) }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                        </div>

                        <!-- Nominal & Tanggal Row -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Nominal -->
                            <div>
                                <x-input-label for="nominal" :value="__('Nominal (Rp)')" />
                                <x-text-input id="nominal" class="block mt-1 w-full" type="number" name="nominal" :value="old('nominal', $expense->nominal)" required min="0" />
                                <x-input-error :messages="$errors->get('nominal')" class="mt-2" />
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <x-input-label for="tanggal_pengeluaran" :value="__('Tanggal')" />
                                <x-text-input id="tanggal_pengeluaran" class="block mt-1 w-full" type="date" name="tanggal_pengeluaran" :value="old('tanggal_pengeluaran', $expense->tanggal_pengeluaran->format('Y-m-d'))" required />
                                <x-input-error :messages="$errors->get('tanggal_pengeluaran')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Bukti Foto -->
                        <div>
                            <x-input-label for="bukti_foto" :value="__('Ubah Bukti Foto (Opsional)')" />
                            @if($expense->bukti_foto)
                                <div class="mb-2">
                                    <p class="text-xs text-gray-500 mb-1">Foto Saat Ini:</p>
                                    <img src="{{ asset('storage/' . $expense->bukti_foto) }}" alt="Bukti" class="h-20 w-auto rounded object-cover border border-gray-300">
                                </div>
                            @endif
                            <input id="bukti_foto" type="file" name="bukti_foto" accept="image/*" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:text-gray-400 dark:file:bg-gray-700 dark:file:text-gray-300">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengubah foto.</p>
                            <x-input-error :messages="$errors->get('bukti_foto')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-4">
                            <a href="{{ route('admin.expenses.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                            <x-primary-button>
                                {{ __('Perbarui') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
