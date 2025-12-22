@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang di panel admin SMAN 2 KAUR')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass-card rounded-2xl p-6 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Pengguna</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['total_users'] }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="text-slate-500 dark:text-slate-400">Guru: {{ $stats['total_teachers'] }} | Siswa:
                    {{ $stats['total_students'] }}</span>
            </div>
        </div>

        <div
            class="glass-card rounded-2xl p-6 hover:shadow-xl hover:shadow-emerald-500/10 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Berita</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['total_news'] }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="inline-flex items-center text-emerald-600 dark:text-emerald-400">
                    <span class="w-2 h-2 bg-emerald-500 rounded-full mr-2 animate-pulse"></span>
                    {{ $stats['published_news'] }} dipublikasikan
                </span>
            </div>
        </div>

        <div
            class="glass-card rounded-2xl p-6 hover:shadow-xl hover:shadow-violet-500/10 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Galeri</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['total_galleries'] }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-violet-500 to-purple-500 rounded-2xl flex items-center justify-center shadow-lg shadow-violet-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 hover:shadow-xl hover:shadow-rose-500/10 transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Pesan Masuk</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-1">{{ $stats['unread_contacts'] }}</p>
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg shadow-rose-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm">
                <span class="inline-flex items-center text-rose-600 dark:text-rose-400">
                    <span class="w-2 h-2 bg-rose-500 rounded-full mr-2 animate-pulse"></span>
                    Belum dibaca
                </span>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200/50 dark:border-slate-700/50 flex justify-between items-center">
                <h2 class="font-bold text-slate-900 dark:text-white">Pengguna Terbaru</h2>
                <a href="{{ route('admin.users.index') }}"
                    class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                    Lihat Semua →
                </a>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                @forelse($recentUsers as $user)
                        <div
                            class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-11 h-11 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold shadow-md">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $user->name }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1.5 text-xs font-semibold rounded-lg
                                        {{ $user->role === 'admin' ? 'bg-rose-100 dark:bg-rose-900/30 text-rose-700 dark:text-rose-300' :
                    ($user->role === 'guru' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300' :
                        'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <p class="text-slate-500 dark:text-slate-400">Belum ada pengguna</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200/50 dark:border-slate-700/50 flex justify-between items-center">
                <h2 class="font-bold text-slate-900 dark:text-white">Pesan Terbaru</h2>
                <a href="#"
                    class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                    Lihat Semua →
                </a>
            </div>
            <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                @forelse($unreadContacts as $contact)
                    <div class="px-6 py-4 hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $contact->name }}</p>
                            <span
                                class="text-xs text-slate-400 dark:text-slate-500">{{ $contact->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $contact->subject }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1 mt-1">{{ $contact->message }}</p>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <p class="text-slate-500 dark:text-slate-400">Tidak ada pesan baru</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection