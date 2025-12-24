@extends(auth()->user()->isAdmin() ? 'layouts.admin' : (auth()->user()->isSiswa() ? 'layouts.student' : 'layouts.teacher'))

@section('title', 'Notifikasi')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Notifikasi</h1>
            @if($notifications->isNotEmpty())
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-green-600 hover:underline">
                        Tandai semua sudah dibaca
                    </button>
                </form>
            @endif
        </div>

        @if($notifications->isEmpty())
            <div class="bg-white rounded-xl shadow-sm border p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-900 mb-2">Tidak ada notifikasi</h3>
                <p class="text-gray-500">Anda akan menerima notifikasi ketika ada aktivitas baru</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border divide-y">
                @foreach($notifications as $notification)
                    <div class="p-4 flex items-start gap-4 {{ $notification->is_read ? 'bg-white' : 'bg-blue-50' }}">
                        <div
                            class="w-10 h-10 rounded-full bg-{{ $notification->type === 'assignment' ? 'blue' : ($notification->type === 'grade' ? 'green' : 'gray') }}-100 flex items-center justify-center flex-shrink-0">
                            <span>{{ $notification->icon }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-medium text-slate-900">{{ $notification->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                                </div>
                                <div class="flex items-center space-x-2 ml-4">
                                    @if(!$notification->is_read)
                                        <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-xs text-blue-600 hover:underline">Tandai dibaca</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div class="flex items-center mt-2 text-xs text-gray-400">
                                <span>{{ $notification->created_at->diffForHumans() }}</span>
                                @if($notification->action_url)
                                    <span class="mx-2">•</span>
                                    <a href="{{ $notification->action_url }}" class="text-green-600 hover:underline">Lihat detail</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection