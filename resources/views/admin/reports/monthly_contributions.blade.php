<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Iuran Bulanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Filters -->
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form action="{{ route('admin.reports.monthly') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700">Bulan</label>
                        <select name="month" id="month" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @for($m=1; $m<=12; $m++)
                                <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                        <select name="year" id="year" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @for($y=2023; $y<=date('Y')+1; $y++)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Kategori Iuran</label>
                        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_iuran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-blue-600 border border-transparent rounded-md py-2 px-4 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Tampilkan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white p-6 shadow rounded-lg border-l-4 border-blue-500">
                    <p class="text-sm font-medium text-gray-500">Total Tagihan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_bills']) }}</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg border-l-4 border-green-500">
                    <p class="text-sm font-medium text-gray-500">Sudah Lunas</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($stats['paid_bills']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($stats['collected_amount'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg border-l-4 border-red-500">
                    <p class="text-sm font-medium text-gray-500">Belum Bayar</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($stats['unpaid_bills']) }}</p>
                    <p class="text-xs text-gray-500 mt-1">Rp {{ number_format($stats['pending_amount'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-white p-6 shadow rounded-lg border-l-4 border-gray-500">
                    <p class="text-sm font-medium text-gray-500">Persentase Lunas</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $stats['total_bills'] > 0 ? round(($stats['paid_bills'] / $stats['total_bills']) * 100, 1) : 0 }}%
                    </p>
                </div>
            </div>

            <!-- Detailed Table -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Rincian Data</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Warga</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nominal</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bills as $bill)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $bill->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $bill->user->warga->alamat_rumah ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $bill->kategoriIuran->nama_iuran }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($bill->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($bill->status == 'paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    @elseif($bill->status == 'unpaid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Belum Bayar
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Tunggakan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($bill->due_date)->format('d M Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data untuk periode ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $bills->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
