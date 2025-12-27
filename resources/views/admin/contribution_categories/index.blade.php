<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Atur Jenis Iuran') }}
            </h2>
            <a href="{{ route('admin.contribution-categories.create') }}" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl shadow-md text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Tambah Iuran
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Iuran</th>
                                    <th scope="col" class="px-6 py-3">Nominal</th>
                                    <th scope="col" class="px-6 py-3">Wajib?</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $category->nama_iuran }}
                                    </td>
                                    <td class="px-6 py-4">
                                        Rp {{ number_format($category->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($category->is_mandatory)
                                            <span class="bg-red-100 text-red-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Wajib</span>
                                        @else
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Opsional</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($category->is_active)
                                            <span class="flex items-center gap-1 text-green-600 dark:text-green-400">
                                                <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                                Aktif
                                            </span>
                                        @else
                                            <span class="flex items-center gap-1 text-gray-400">
                                                <span class="material-symbols-outlined text-[18px]">cancel</span>
                                                Non-Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.contribution-categories.edit', $category->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                            <form action="{{ route('admin.contribution-categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($categories->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Belum ada kategori iuran dibuat.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
