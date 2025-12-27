<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Aduan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Evidence Image -->
                        @if($complaint->image)
                        <div class="w-full md:w-1/3">
                            <div class="rounded-lg overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
                                <img src="{{ asset('storage/' . $complaint->image) }}" alt="Bukti Foto" class="w-full h-auto object-cover">
                            </div>
                        </div>
                        @endif

                        <!-- Details -->
                        <div class="flex-1 space-y-6">
                            <div>
                                <h3 class="text-2xl font-bold mb-2">{{ $complaint->title }}</h3>
                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <span class="material-symbols-outlined text-sm mr-1">person</span>
                                        {{ $complaint->user->name }}
                                    </span>
                                    <span class="flex items-center">
                                        <span class="material-symbols-outlined text-sm mr-1">calendar_today</span>
                                        {{ $complaint->created_at->translatedFormat('d F Y H:i') }}
                                    </span>
                                </div>
                            </div>

                            <div class="bg-gray-50 dark:bg-gray-700/50 p-4 rounded-xl border border-gray-100 dark:border-gray-700">
                                <h4 class="font-semibold mb-2">Deskripsi:</h4>
                                <p class="whitespace-pre-wrap">{{ $complaint->description }}</p>
                            </div>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <span class="text-sm text-gray-500 block">Status Saat Ini:</span>
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processed' => 'bg-blue-100 text-blue-800',
                                            'resolved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="mt-1 inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$complaint->status] }}">
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                </div>

                                @if(Auth::user()->role === 'admin')
                                <form action="{{ route('complaints.update', $complaint) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="text-sm rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processed" {{ $complaint->status == 'processed' ? 'selected' : '' }}>Diproses</option>
                                        <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Selesai</option>
                                        <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                    <button type="submit" class="px-3 py-2 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 rounded-lg text-sm font-semibold hover:bg-gray-700 dark:hover:bg-white transition">
                                        Update
                                    </button>
                                </form>
                                @endif
                            </div>
                            
                            <div class="pt-4">
                                <a href="{{ route('complaints.index') }}" class="text-primary hover:underline">&larr; Kembali ke Daftar Aduan</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
