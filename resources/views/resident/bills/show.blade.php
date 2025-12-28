<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Tagihan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <!-- Alerts -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
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
                            <!-- Manual Transfer Cards -->
                            @php
                                $bankSetting = \App\Models\BankSetting::first();
                            @endphp

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-6">
                                <!-- Bank Transfer Card -->
                                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="bg-blue-100 p-2 rounded-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Transfer Bank</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $bankSetting?->bank_name ?? 'Bank BCA' }}</h3>
                                        <div class="flex items-center mt-1">
                                            <span class="text-2xl font-mono tracking-wider text-blue-700 font-bold" id="no_rek">{{ $bankSetting?->account_number ?? '8720991234' }}</span>
                                            <button onclick="copyToClipboard('{{ $bankSetting?->account_number ?? '8720991234' }}')" type="button" class="ml-3 text-gray-400 hover:text-blue-600 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1 uppercase font-medium">a.n {{ $bankSetting?->account_holder ?? 'Bendahara RT 35' }}</p>
                                    </div>
                                </div>

                                <!-- E-Wallet Card -->
                                <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="bg-blue-500 p-2 rounded-lg">
                                            <span class="text-white font-bold text-xs">DANA</span>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">E-Wallet</span>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">DANA</h3>
                                        <div class="flex items-center mt-1">
                                            <span class="text-2xl font-mono tracking-wider text-blue-500 font-bold" id="no_dana">{{ $bankSetting?->dana_number ?? '081234567890' }}</span>
                                            <button onclick="copyToClipboard('{{ $bankSetting?->dana_number ?? '081234567890' }}')" type="button" class="ml-3 text-gray-400 hover:text-blue-500 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <p class="text-sm text-gray-500 mt-1 uppercase font-medium">a.n Kas RT 35 (Dana RT)</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Form -->
                            <div class="mt-8 bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden" x-data="{ photoPreview: null }">
                                <div class="p-6">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-green-100 p-2 rounded-full mr-3">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-800">Konfirmasi Pembayaran</h3>
                                    </div>

                                    <form action="{{ route('pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="tagihan_id" value="{{ $bill->id }}">
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Foto Bukti Transfer / Struk</label>
                                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-blue-400 transition-colors">
                                                    <div class="space-y-1 text-center">
                                                        <template x-if="photoPreview">
                                                            <div class="mb-4">
                                                                <img :src="photoPreview" class="mx-auto h-48 w-auto rounded-lg shadow-md">
                                                            </div>
                                                        </template>
                                                        
                                                        <template x-if="!photoPreview">
                                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </template>

                                                        <div class="flex text-sm text-gray-600">
                                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500">
                                                                <span>Klik untuk unggah</span>
                                                                <input id="file-upload" name="bukti_pembayaran" type="file" class="sr-only" accept="image/*" 
                                                                    @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                                                            </label>
                                                            <p class="pl-1">atau tarik dan lepas</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition-all transform active:scale-95">
                                                Kirim Konfirmasi Pembayaran
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="bg-gray-50 px-6 py-3 border-t border-gray-100">
                                    <p class="text-xs text-gray-500 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Bendahara akan memverifikasi laporan Anda dalam waktu maksimal 1x24 jam.
                                    </p>
                                </div>
                            </div>

                            <script>
                                function copyToClipboard(text) {
                                    navigator.clipboard.writeText(text);
                                    alert('Nomor rekening/HP berhasil disalin!');
                                }
                            </script>
                        </div>


                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
