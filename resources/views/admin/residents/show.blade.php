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
                            <p class="font-medium">{{ $resident->warga?->nik ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Nomor KK</p>
                            <p class="font-medium">{{ $resident->warga?->no_kk ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-medium">{{ $resident->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                            <p class="font-medium">{{ $resident->warga?->tempat_lahir ?? '-' }}, {{ $resident->warga?->tanggal_lahir?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status Pernikahan</p>
                            <p class="font-medium">{{ $resident->warga?->status_pernikahan ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-medium">{{ $resident->warga?->alamat_rumah ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Password Reset Card -->
                <div class="space-y-6">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Statistik</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Anggota Keluarga</span>
                                <span class="font-bold bg-blue-100 text-blue-800 px-2 py-1 rounded">
                                    {{ $resident->warga?->anggotaKeluarga?->count() ?? 0 }} Orang
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500">Tagihan Belum Lunas</span>
                                <span class="font-bold bg-red-100 text-red-800 px-2 py-1 rounded">{{ $resident->bills->whereIn('status', ['unpaid', 'arrears'])->count() }} Bulan</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Reset Password</h3>
                        @if(session('success'))
                            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('admin.residents.update-password', $resident) }}" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            <div>
                                <x-input-label for="password" :value="__('Password Baru')" />
                                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                                <x-text-input id="password_confirmation" class="block w-full mt-1" type="password" name="password_confirmation" required />
                            </div>

                            <x-primary-button class="w-full justify-center">
                                {{ __('Reset Password') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Family Members Section -->
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Anggota Keluarga</h3>
                @if($resident->warga?->anggotaKeluarga?->isNotEmpty())
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
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->tanggal_lahir?->format('d M Y') ?? '-' }}</td>
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
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $bill->kategoriIuran?->nama_iuran ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">Rp {{ number_format($bill->amount, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 flex items-center gap-2">
                                    @if($bill->status == 'paid')
                                        <div class="flex flex-col">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lunas</span>
                                            @if($bill->payments->where('is_override', true)->isNotEmpty())
                                                <span class="text-[10px] text-gray-500 mt-1 italic">via Override Admin</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $bill->status == 'unpaid' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $bill->status == 'unpaid' ? 'Belum Bayar' : 'Tunggakan' }}
                                        </span>
                                        
                                        <!-- Override Lunas Button -->
                                        <button onclick="openOverrideModal('{{ $bill->id }}')" class="ml-2 text-blue-600 hover:text-blue-900 text-xs font-bold underline">
                                            Override Lunas
                                        </button>
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

    <!-- Override Modal -->
    <div id="overrideModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeOverrideModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="overrideForm" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Override Lunas Tagihan</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Tindakan ini akan <b>langsung melunasi tagihan</b> dengan metode Tunai (Manual Override).
                                    </p>
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700">Catatan Override (Wajib)</label>
                                        <textarea name="catatan" rows="3" class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required placeholder="Contoh: Bayar Tunai saat Rapat RT / Dispensasi Khusus"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Konfirmasi Lunas
                        </button>
                        <button type="button" onclick="closeOverrideModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openOverrideModal(id) {
            const form = document.getElementById('overrideForm');
            form.action = `/admin/bills/${id}/override-lunas`;
            document.getElementById('overrideModal').classList.remove('hidden');
        }

        function closeOverrideModal() {
            document.getElementById('overrideModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
