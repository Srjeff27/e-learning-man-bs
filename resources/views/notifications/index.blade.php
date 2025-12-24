@extends(auth()->user()->isAdmin() ? 'layouts.admin' : (auth()->user()->isSiswa() ? 'layouts.student' : 'layouts.teacher'))

@section('title', 'Notifikasi')

@section('content')
<div class="min-h-screen relative py-8 px-4 sm:px-6 lg:px-8 overflow-hidden transition-colors duration-500">
    
    {{-- Background Decorative Blobs (Adaptive Dark/Light) --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-300 dark:bg-blue-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-20 dark:opacity-10 animate-pulse"></div>
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-indigo-300 dark:bg-indigo-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-20 dark:opacity-10 animate-pulse" style="animation-delay: 2s"></div>
    <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-sky-200 dark:bg-sky-600 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-3xl opacity-20 dark:opacity-10 animate-pulse" style="animation-delay: 4s"></div>

    <div class="relative max-w-4xl mx-auto">
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">Notifikasi</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Pantau semua aktivitas akademik Anda di sini.</p>
            </div>
            
            @if($notifications->isNotEmpty())
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/80 dark:bg-slate-800/80 border border-white/50 dark:border-slate-600/50 shadow-sm hover:shadow-md hover:bg-blue-50 dark:hover:bg-slate-700 transition-all duration-300 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">Tandai semua dibaca</span>
                    </button>
                </form>
            @endif
        </div>

        {{-- Notifications Container with Dark Glassmorphism --}}
        <div class="bg-white/60 dark:bg-slate-900/60 backdrop-blur-xl rounded-3xl border border-white/40 dark:border-white/10 shadow-2xl shadow-blue-900/5 dark:shadow-black/20 overflow-hidden transition-colors duration-300">
            @if($notifications->isEmpty())
                {{-- Empty State --}}
                <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                    <div class="w-24 h-24 bg-gradient-to-tr from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-700 rounded-full flex items-center justify-center mb-6 shadow-inner ring-4 ring-white dark:ring-slate-800 transition-colors duration-300">
                        <svg class="w-10 h-10 text-blue-300 dark:text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Semua Bersih!</h3>
                    <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto leading-relaxed">Belum ada notifikasi baru saat ini. Nikmati waktu belajar Anda.</p>
                </div>
            @else
                {{-- List --}}
                <div class="divide-y divide-slate-100/50 dark:divide-slate-700/50">
                    @foreach($notifications as $notification)
                        <div class="group relative p-6 transition-all duration-300 hover:bg-white/60 dark:hover:bg-slate-800/50 {{ !$notification->is_read ? 'bg-blue-50/40 dark:bg-blue-900/10' : '' }}">
                            
                            {{-- Unread Indicator --}}
                            @if(!$notification->is_read)
                                <div class="absolute left-0 top-6 w-1 h-12 bg-blue-500 dark:bg-blue-400 rounded-r-full shadow-lg shadow-blue-500/30"></div>
                            @endif

                            <div class="flex gap-5">
                                {{-- Icon Wrapper --}}
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow-sm ring-1 ring-slate-900/5 dark:ring-white/10
                                        {{ $notification->type === 'grade' ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400' : 
                                          ($notification->type === 'assignment' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300') }}">
                                        <span class="transform group-hover:scale-110 transition-transform duration-300">
                                            {!! $notification->icon ?? '<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>' !!}
                                        </span>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 min-w-0 pt-1">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2 mb-1">
                                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 {{ !$notification->is_read ? 'text-blue-900 dark:text-blue-100' : '' }}">
                                            {{ $notification->title }}
                                        </h3>
                                        <span class="text-xs font-medium text-slate-400 dark:text-slate-500 bg-slate-100/50 dark:bg-slate-800/50 px-2 py-1 rounded-md border border-slate-200/50 dark:border-slate-700/50 whitespace-nowrap">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed text-sm mb-4 max-w-2xl">
                                        {{ $notification->message }}
                                    </p>

                                    {{-- Actions Toolbar --}}
                                    <div class="flex flex-wrap items-center gap-3 pt-2">
                                        @if($notification->action_url)
                                            <a href="{{ $notification->action_url }}" class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-lg bg-blue-600 dark:bg-blue-500 text-white text-xs font-bold shadow-md shadow-blue-500/20 hover:bg-blue-700 dark:hover:bg-blue-400 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                                                Lihat Detail
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                            </a>
                                        @endif

                                        <div class="flex items-center gap-1 sm:ml-auto">
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.read', $notification) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors" title="Tandai sudah dibaca">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                        <span class="hidden sm:inline">Baca</span>
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Hapus notifikasi">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                    <span class="hidden sm:inline">Hapus</span>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination Footer --}}
                @if($notifications->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700 bg-slate-50/30 dark:bg-slate-800/30 backdrop-blur-sm rounded-b-3xl">
                        {{ $notifications->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection