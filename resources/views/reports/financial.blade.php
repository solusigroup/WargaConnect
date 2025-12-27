<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Pemasukan -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-xl text-green-600 dark:text-green-300">
                            <span class="material-symbols-outlined text-3xl">arrow_downward</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Pemasukan</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Pengeluaran -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-xl text-red-600 dark:text-red-300">
                            <span class="material-symbols-outlined text-3xl">arrow_upward</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Total Pengeluaran</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Saldo Kas -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-xl text-blue-600 dark:text-blue-300">
                            <span class="material-symbols-outlined text-3xl">account_balance_wallet</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Saldo Kas Saat Ini</p>
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transaction History -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Transaksi (Mutasi)</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Keterangan</th>
                                    <th scope="col" class="px-6 py-3">Tipe</th>
                                    <th scope="col" class="px-6 py-3 text-right">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($mutations as $mutation)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($mutation['date'])->format('d M Y') }}
                                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($mutation['date'])->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $mutation['title'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $mutation['description'] }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($mutation['type'] == 'income')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Pemasukan</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Pengeluaran</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right font-mono text-base {{ $mutation['type'] == 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $mutation['type'] == 'income' ? '+' : '-' }} Rp {{ number_format($mutation['nominal'], 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach

                                @if($mutations->isEmpty())
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                            Belum ada data transaksi.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
