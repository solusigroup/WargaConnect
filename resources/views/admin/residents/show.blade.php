<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Warga: ') . $resident->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Cards Section -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="bg-white shadow sm:rounded-lg p-6 md:col-span-2">
                    <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Informasi Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-medium">{{ $resident->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="font-medium">{{ $resident->warga->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor KK</p>
                            <p class="font-medium">{{ $resident->warga->no_kk ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $resident->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                            <p class="font-medium">{{ $resident->warga->tempat_lahir ?? '-' }}, {{ $resident->warga->tanggal_lahir ? $resident->warga->tanggal_lahir->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status Pernikahan</p>
                            <p class="font-medium">{{ $resident->warga->status_pernikahan ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-medium">{{ $resident->warga->alamat_rumah ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Family & Stats Card -->
                <div class="space-y-6">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Statistik</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Anggota Keluarga</span>
                                <span class="font-bold bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $resident->warga->anggotaKeluarga->count() }} Orang</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Tagihan Belum Lunas</span>
                                <span class="font-bold bg-red-100 text-red-800 px-2 py-1 rounded">{{ $resident->bills->whereIn('status', ['unpaid', 'arrears'])->count() }} Bulan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Family Members Section -->
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Anggota Keluarga</h3>
                @if($resident->warga->anggotaKeluarga->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIK</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Hubungan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tgl Lahir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($resident->warga->anggotaKeluarga as $member)
                            <tr>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $member->nama_lengkap }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->nik }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->hubungan_keluarga }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->tanggal_lahir->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-500 text-sm">Tidak ada data anggota keluarga.</p>
                @endif
            </div>

            <!-- Billing History Section -->
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Riwayat Tagihan (Terbaru)</h3>
                @php
                    $latestBills = $resident->bills()->latest()->take(5)->get();
                @endphp
                
                @if($latestBills->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bulan/Tahun</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($latestBills as $bill)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $bill->month_name }} {{ $bill->year }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $bill->kategoriIuran->nama_iuran ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if($bill->status == 'paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lunas</span>
                                    @elseif($bill->status == 'unpaid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Belum Bayar</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Tunggakan</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-500 text-sm">Belum ada riwayat tagihan.</p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
