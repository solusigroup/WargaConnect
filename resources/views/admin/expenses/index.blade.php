<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Data Pengeluaran') }}
            </h2>
            <a href="{{ route('admin.expenses.create') }}" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-xl shadow-md text-sm flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span>
                Input Pengeluaran
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
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Judul Pengeluaran</th>
                                    <th scope="col" class="px-6 py-3">Nominal</th>
                                    <th scope="col" class="px-6 py-3">Bukti</th>
                                    <th scope="col" class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        {{ $expense->tanggal_pengeluaran->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        <div class="text-base font-semibold">{{ $expense->judul }}</div>
                                        <div class="font-normal text-gray-500">{{ Str::limit($expense->deskripsi, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        Rp {{ number_format($expense->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($expense->bukti_foto)
                                            <a href="{{ asset('storage/' . $expense->bukti_foto) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Lihat Foto</a>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.expenses.edit', $expense->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                <span class="material-symbols-outlined">edit</span>
                                            </a>
                                            <form action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
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

                    <div class="mt-4">
                        {{ $expenses->links() }}
                    </div>

                    @if($expenses->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Belum ada data pengeluaran.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
