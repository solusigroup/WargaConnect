<x-app-layout>
    <!-- Header / Profile Section -->
    <div class="bg-white dark:bg-[#1A2633] px-5 pt-8 pb-6 rounded-b-[32px] shadow-[0_4px_24px_rgba(207,219,231,0.4)] dark:shadow-none sticky top-0 z-20">
        <div class="flex justify-between items-center">
            <div class="flex flex-col">
                <p class="text-[#4c739a] dark:text-slate-400 text-sm font-medium">Selamat Pagi,</p>
                <h1 class="text-[#0d141b] dark:text-white text-2xl font-bold tracking-tight">{{ Auth::user()->name }}</h1>
                <span class="inline-flex items-center gap-1 mt-1">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span class="text-xs text-[#4c739a] dark:text-slate-400 font-medium">Warga RT 35 / RW 08</span>
                </span>
            </div>
            <div class="relative">
                <div class="h-12 w-12 rounded-full bg-[#e7edf3] dark:bg-slate-700 flex items-center justify-center overflow-hidden ring-2 ring-white dark:ring-slate-800 shadow-md">
                    <span class="material-symbols-outlined text-[#4c739a] text-2xl">person</span>
                </div>
            </div>
        </div>
    </div>

    <div class="px-5 mt-6 space-y-8 pb-8">
        <!-- Total Tunggakan Card -->
        @if($totalArrears > 0)
        <div class="relative w-full rounded-[24px] overflow-hidden shadow-[0_8px_32px_rgba(247,56,89,0.25)] group transition-all duration-300 hover:scale-[1.02]">
            <!-- Background Gradient (Red/Warning) -->
            <div class="absolute inset-0 bg-gradient-to-br from-[#ff6b6b] to-[#ee5253]"></div>
            <!-- Pattern Overlay -->
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white via-transparent to-transparent"></div>
            
            <div class="relative p-6 text-white flex flex-col justify-between min-h-[160px]">
                <div class="flex justify-between items-start">
                    <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full border border-white/10">
                        <span class="material-symbols-outlined text-[18px]">warning</span>
                        <span class="text-xs font-bold tracking-wide">Tunggakan Iuran</span>
                    </div>
                    <span class="text-xs font-medium opacity-80 bg-black/10 px-2 py-0.5 rounded text-white/90">{{ $unpaidBill->month_name }} {{ $unpaidBill->year }}</span>
                </div>
                
                <div class="mt-2">
                    <p class="text-white/80 text-sm font-medium mb-1">Total yang harus dibayar</p>
                    <h2 class="text-4xl font-extrabold tracking-tight">Rp {{ number_format($totalArrears, 0, ',', '.') }}</h2>
                </div>

                <div class="mt-4">
                    <a href="{{ route('bill.show', $unpaidBill->id) }}" class="inline-flex w-full items-center justify-center gap-2 bg-white text-[#ee5253] py-3.5 px-4 rounded-xl font-bold text-sm shadow-lg hover:bg-gray-50 transition-colors uppercase tracking-wider">
                        <span>Bayar Tagihan Terlama</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
        @else
        <!-- All Paid Card (Green) -->
        <div class="relative w-full rounded-[24px] overflow-hidden shadow-[0_8px_32px_rgba(32,191,107,0.25)] group">
            <div class="absolute inset-0 bg-gradient-to-br from-[#20bf6b] to-[#0fb9b1]"></div>
            <div class="relative p-6 text-white flex flex-col items-center justify-center text-center min-h-[160px] gap-3">
                <div class="h-12 w-12 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white mb-1">
                    <span class="material-symbols-outlined text-3xl">check_circle</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Iuran Aman!</h2>
                    <p class="text-white/80 text-sm mt-1">Terima kasih sudah tertib membayar iuran.</p>
                </div>
            </div>
        </div>
        @endif





        <!-- Quick Menu -->
        <div>
            <div class="flex justify-between items-end mb-4">
                <h3 class="text-[#0d141b] dark:text-white text-lg font-bold">Menu Warga</h3>
            </div>
            <div class="grid grid-cols-4 gap-4">
                <!-- Menu Item 1: Iuran -->
                <a href="#" class="flex flex-col items-center gap-2 group">
                    <div class="h-16 w-16 rounded-[20px] bg-white dark:bg-[#1A2633] flex items-center justify-center shadow-[0_2px_12px_rgba(207,219,231,0.4)] dark:shadow-none group-hover:-translate-y-1 transition-transform border border-[#e7edf3] dark:border-slate-700">
                        <span class="material-symbols-outlined text-primary text-[28px]">payments</span>
                    </div>
                    <span class="text-xs font-semibold text-[#0d141b] dark:text-slate-300">Iuran</span>
                </a>
                <!-- Menu Item 2: Laporan -->
                <a href="{{ route('finance.index') }}" class="flex flex-col items-center gap-2 group">
                    <div class="h-16 w-16 rounded-[20px] bg-white dark:bg-[#1A2633] flex items-center justify-center shadow-[0_2px_12px_rgba(207,219,231,0.4)] dark:shadow-none group-hover:-translate-y-1 transition-transform border border-[#e7edf3] dark:border-slate-700">
                        <span class="material-symbols-outlined text-[#f7b731] text-[28px]">history_edu</span>
                    </div>
                    <span class="text-xs font-semibold text-[#0d141b] dark:text-slate-300">Laporan</span>
                </a>
                <!-- Menu Item 3: Aduan -->
                <a href="{{ route('complaints.index') }}" class="flex flex-col items-center gap-2 group">
                    <div class="h-16 w-16 rounded-[20px] bg-white dark:bg-[#1A2633] flex items-center justify-center shadow-[0_2px_12px_rgba(207,219,231,0.4)] dark:shadow-none group-hover:-translate-y-1 transition-transform border border-[#e7edf3] dark:border-slate-700">
                        <span class="material-symbols-outlined text-[#eb3b5a] text-[28px]">campaign</span>
                    </div>
                    <span class="text-xs font-semibold text-[#0d141b] dark:text-slate-300">Aduan</span>
                </a>
                <!-- Menu Item 4: Info Warga -->
                <a href="#" class="flex flex-col items-center gap-2 group">
                    <div class="h-16 w-16 rounded-[20px] bg-white dark:bg-[#1A2633] flex items-center justify-center shadow-[0_2px_12px_rgba(207,219,231,0.4)] dark:shadow-none group-hover:-translate-y-1 transition-transform border border-[#e7edf3] dark:border-slate-700">
                        <span class="material-symbols-outlined text-[#2d98da] text-[28px]">info</span>
                    </div>
                    <span class="text-xs font-semibold text-[#0d141b] dark:text-slate-300 text-center leading-tight">Info Warga</span>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-[#0d141b] dark:text-white text-lg font-bold">Aktivitas Terkini</h3>
                <a href="#" class="text-sm font-semibold text-primary">Lihat Semua</a>
            </div>
            <div class="flex flex-col gap-3">
                @forelse($recentPayments ?? [] as $payment)
                    <div class="flex items-center gap-4 bg-white dark:bg-[#1A2633] p-4 rounded-2xl shadow-sm border border-[#e7edf3] dark:border-slate-700">
                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-500 text-[20px]">check</span>
                        </div>
                        <div class="flex-grow">
                            <h4 class="text-[#0d141b] dark:text-white font-bold text-sm">Pembayaran Iuran</h4>
                            <p class="text-[#4c739a] dark:text-slate-400 text-xs">{{ $payment->bill->month_name ?? 'Bulan' }} {{ $payment->bill->year ?? '' }}</p>
                        </div>
                        <div class="text-right">
                            <span class="block text-[#0d141b] dark:text-white font-bold text-sm">- Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
                            <span class="block text-[#4c739a] dark:text-slate-400 text-xs">{{ $payment->created_at->format('d M') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center bg-white dark:bg-[#1A2633] rounded-2xl border border-dashed border-[#cfdbe7] dark:border-slate-700">
                        <p class="text-sm text-[#4c739a] dark:text-slate-400">Belum ada aktivitas transaksi.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
