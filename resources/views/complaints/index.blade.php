<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Daftar Aduan') }}
            </h2>
            @if(Auth::user()->role !== 'admin')
            <a href="{{ route('complaints.create') }}" class="inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <span class="material-symbols-outlined text-sm mr-2">add</span>
                Buat Aduan
            </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="space-y-4">
                        @forelse($complaints as $complaint)
                            <div class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-100 dark:border-gray-700">
                                <div class="flex-shrink-0 mt-1">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'processed' => 'bg-blue-100 text-blue-800',
                                            'resolved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                        ];
                                        $statusIcon = [
                                            'pending' => 'hourglass_empty',
                                            'processed' => 'sync',
                                            'resolved' => 'check_circle',
                                            'rejected' => 'cancel',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-full {{ $statusColors[$complaint->status] }}">
                                        <span class="material-symbols-outlined">{{ $statusIcon[$complaint->status] }}</span>
                                    </span>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $complaint->title }}</h4>
                                            @if(Auth::user()->role === 'admin')
                                                <p class="text-sm text-gray-500">Oleh: {{ $complaint->user->name }} - {{ $complaint->created_at->format('d M Y H:i') }}</p>
                                            @else
                                                <p class="text-sm text-gray-500">{{ $complaint->created_at->format('d M Y H:i') }}</p>
                                            @endif
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$complaint->status] }}">
                                            {{ ucfirst($complaint->status) }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 mt-2 line-clamp-2">
                                        {{ $complaint->description }}
                                    </p>
                                    <div class="mt-3">
                                        <a href="{{ route('complaints.show', $complaint) }}" class="text-sm font-semibold text-primary hover:underline">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 mb-4">rate_review</span>
                                <p class="text-gray-500 dark:text-gray-400 text-lg">Belum ada aduan yang diajukan.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $complaints->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
