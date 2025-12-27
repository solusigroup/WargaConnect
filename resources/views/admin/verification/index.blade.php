<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Verifikasi Warga') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <span class="block text-2xl font-bold text-primary">{{ \App\Models\User::where('status', 'pending')->count() }}</span>
                    <span class="text-xs text-gray-500">Pending</span>
                </div>
                <div class="bg-white p-4 rounded-lg shadow text-center">
                    <span class="block text-2xl font-bold text-success">{{ \App\Models\User::where('status', 'verified')->count() }}</span>
                    <span class="text-xs text-gray-500">Verified</span>
                </div>
            </div>

            <!-- List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($pendingUsers->isEmpty())
                        <div class="text-center py-10 text-gray-500">
                            Tidak ada warga yang perlu verifikasi saat ini.
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($pendingUsers as $user)
                                <div class="border rounded-lg p-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="flex items-start gap-4">
                                        <div class="h-12 w-12 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                                             @if($user->ktp_photo_path)
                                                <img src="{{ asset('storage/' . $user->ktp_photo_path) }}" class="h-full w-full object-cover">
                                            @else
                                                <svg class="h-full w-full text-gray-400 p-2" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-lg">{{ $user->name }}</h4>
                                            <p class="text-sm text-gray-600">NIK: {{ $user->nik }}</p>
                                            <p class="text-sm text-gray-600">{{ $user->address }}</p>
                                            <p class="text-xs text-gray-400 mt-1">Daftar: {{ $user->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.verification.reject', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 border border-red-500 text-red-500 text-sm rounded hover:bg-red-50">Tolak</button>
                                        </form>
                                        <form action="{{ route('admin.verification.approve', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-success text-white text-sm rounded hover:bg-green-600 shadow-sm">Verifikasi</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-4">
                            {{ $pendingUsers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
