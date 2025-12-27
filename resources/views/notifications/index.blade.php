<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Notifikasi') }}
            </h2>
            @if(Auth::user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.markAllRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium hover:underline">
                        Tandai semua dibaca
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <div class="space-y-4">
                        @forelse($notifications as $notification)
                            <div class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg {{ $notification->read_at ? 'opacity-75' : 'border-l-4 border-primary' }}">
                                <div class="flex-shrink-0 text-primary mt-1">
                                    <span class="material-symbols-outlined">{{ $notification->data['icon'] ?? 'notifications' }}</span>
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between items-start">
                                        <h4 class="text-sm font-bold text-gray-900 dark:text-gray-100">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</h4>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                        {{ $notification->data['message'] ?? 'Anda memiliki notifikasi baru.' }}
                                    </p>
                                    @if(isset($notification->data['action_url']))
                                        <a href="{{ $notification->data['action_url'] }}" class="inline-block mt-2 text-xs font-semibold text-primary hover:text-blue-700">
                                            Lihat Detail &rarr;
                                        </a>
                                    @endif
                                </div>
                                @if(!$notification->read_at)
                                    <div class="ml-4 flex-shrink-0">
                                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-gray-400 hover:text-primary" title="Tandai dibaca">
                                                <span class="material-symbols-outlined text-sm">check_circle</span>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 mb-4">notifications_off</span>
                                <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada notifikasi saat ini.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-6">
                        {{ $notifications->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
