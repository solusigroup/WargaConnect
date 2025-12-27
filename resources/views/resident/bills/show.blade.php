<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <!-- Bill Summary Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl mb-6 relative">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">Periode</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ \Carbon\Carbon::createFromDate($bill->year, $bill->month, 1)->translatedFormat('F Y') }}
                            </h3>
                        </div>
                        <div class="px-3 py-1 rounded-full text-sm font-semibold 
                            {{ $bill->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ ucfirst($bill->status) }}
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Jenis Iuran</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $bill->kategoriIuran->nama_iuran }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">Jumlah</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">Total Bayar</span>
                            <span class="text-2xl font-bold text-primary">Rp {{ number_format($bill->amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Ticket Notch Effect -->
                <div class="absolute -left-3 top-2/3 w-6 h-6 bg-gray-100 dark:bg-gray-900 rounded-full"></div>
                <div class="absolute -right-3 top-2/3 w-6 h-6 bg-gray-100 dark:bg-gray-900 rounded-full"></div>
            </div>

            @if($bill->status == 'unpaid' || $bill->status == 'arrears')
            <!-- Payment Method Selection -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl">
                <div class="p-6">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Pilih Metode Pembayaran</h4>
                    
                    <form action="{{ route('bill.pay', $bill) }}" method="POST">
                        @csrf
                        <div class="space-y-3">
                            <!-- QRIS -->
                            <label class="relative flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary hover:bg-blue-50 dark:hover:bg-gray-700 transition group">
                                <input type="radio" name="payment_method" value="qris" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary" checked>
                                <div class="ml-3 flex-1">
                                    <span class="block text-sm font-medium text-gray-900 dark:text-white">QRIS (GoPay, OVO, Dana)</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Verifikasi Otomatis</span>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                            </label>

                            <!-- Bank Transfer -->
                            <label class="relative flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary hover:bg-blue-50 dark:hover:bg-gray-700 transition group">
                                <input type="radio" name="payment_method" value="bank_transfer" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                <div class="ml-3 flex-1">
                                    <span class="block text-sm font-medium text-gray-900 dark:text-white">Transfer Bank (BCA, Mandiri)</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Pengecekan Manual 1x24 Jam</span>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            </label>

                            <!-- Cash -->
                            <label class="relative flex items-center p-4 rounded-xl border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary hover:bg-blue-50 dark:hover:bg-gray-700 transition group">
                                <input type="radio" name="payment_method" value="cash" class="h-4 w-4 text-primary border-gray-300 focus:ring-primary">
                                <div class="ml-3 flex-1">
                                    <span class="block text-sm font-medium text-gray-900 dark:text-white">Tunai (Bayar ke Pak RT)</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400">Hubungi Pak RT untuk pembayaran</span>
                                </div>
                                <svg class="w-6 h-6 text-gray-400 group-hover:text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </label>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition duration-200">
                                Lanjut Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
