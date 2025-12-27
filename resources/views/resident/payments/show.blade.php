<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Selesaikan Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl relative">
                <div class="p-6 text-center">
                    
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Total Pembayaran</p>
                        <h3 class="text-3xl font-bold text-primary">Rp {{ number_format($payment->amount, 0, ',', '.') }}</h3>
                        <p class="text-xs text-gray-400 mt-2">ID Transaksi: {{ $payment->transaction_id }}</p>
                    </div>

                    <div class="border-t border-b border-gray-100 dark:border-gray-700 py-6 mb-6">
                        @if($payment->method === 'qris')
                            <div class="flex flex-col items-center">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Scan QRIS</h4>
                                <!-- Dummy QR Code -->
                                <div class="bg-white p-4 rounded-xl shadow-inner border border-gray-100 mb-4">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=WargaConnect-{{ $payment->transaction_id }}" alt="QRIS Code" class="w-48 h-48">
                                </div>
                                <p class="text-sm text-gray-500">Scan menggunakan GoPay, OVO, Dana, atau Mobile Banking.</p>
                            </div>
                        @elseif($payment->method === 'transfer')
                            <div class="text-left">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-4 text-center">Transfer Bank</h4>
                                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-xl mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Bank BCA</span>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg" alt="BCA" class="h-4">
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-mono text-lg font-bold text-gray-900 dark:text-white tracking-wider">123 456 7890</span>
                                        <button onclick="navigator.clipboard.writeText('1234567890')" class="text-primary text-xs font-semibold hover:underline">SALIN</button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">a.n. Bendahara RT 35</p>
                                </div>
                                <div class="bg-blue-50 dark:bg-gray-700 p-4 rounded-xl">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-300">Bank Mandiri</span>
                                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg" alt="Mandiri" class="h-4">
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-mono text-lg font-bold text-gray-900 dark:text-white tracking-wider">000 123 456 789</span>
                                        <button onclick="navigator.clipboard.writeText('000123456789')" class="text-primary text-xs font-semibold hover:underline">SALIN</button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">a.n. WargaConnect RT 35</p>
                                </div>
                            </div>
                        @elseif($payment->method === 'cash')
                            <div class="text-center">
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Pembayaran Tunai</h4>
                                <div class="bg-yellow-50 dark:bg-gray-700 p-6 rounded-xl">
                                    <svg class="w-16 h-16 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">Silakan kunjungi rumah Bapak RT untuk melakukan pembayaran.</p>
                                    <p class="font-bold text-gray-900 dark:text-white">Bapak Budiman (Ketua RT 35)</p>
                                    <p class="text-sm text-gray-500">Jl. Warga No. 1</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Sudah melakukan pembayaran?
                        </label>
                        <a href="{{ route('dashboard') }}" class="block w-full text-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                            Konfirmasi Pembayaran (Upload Bukti)
                        </a>
                        <p class="text-xs text-gray-400 mt-2">*Fitur upload bukti akan segera tersedia</p>
                    </div>

                    <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900 dark:hover:text-white">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
