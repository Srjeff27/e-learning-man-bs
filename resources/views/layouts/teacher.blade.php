<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LMS Guru') - SMAN 2 KAUR</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 9999px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background-color: #334155;
        }

        /* Animasi Shimmer untuk tombol aktif */
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2.5s infinite;
        }
    </style>

    @stack('styles')
</head>

<body
    class="font-['Plus_Jakarta_Sans'] bg-slate-50 dark:bg-slate-950 text-slate-600 dark:text-slate-400 antialiased selection:bg-blue-500 selection:text-white relative overflow-hidden"
    x-data="{ sidebarOpen: false, darkMode: localStorage.theme === 'dark' }">


    @php
        $navBase = "relative flex items-center gap-3 px-4 py-3.5 rounded-2xl font-medium text-sm transition-all duration-300 overflow-hidden group mx-3 mb-1";

        $navInactive = "text-slate-500 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-800/60 hover:text-blue-600 dark:hover:text-blue-400 hover:translate-x-1";

        $navActive = "bg-gradient-to-br from-emerald-600 to-teal-600 text-white shadow-lg shadow-emerald-500/30 ring-1 ring-white/20 
                                                              before:absolute before:inset-x-0 before:top-0 before:h-1/2 before:bg-gradient-to-b before:from-white/20 before:to-transparent";
    @endphp

    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden">
        <div
            class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-emerald-500/10 rounded-full blur-[100px] opacity-60 mix-blend-multiply dark:mix-blend-screen animate-pulse-slow">
        </div>
        <div
            class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[100px] opacity-60 mix-blend-multiply dark:mix-blend-screen animate-pulse-slow delay-1000">
        </div>
    </div>

    <div class="flex h-screen overflow-hidden">

        <aside
            class="fixed inset-y-0 left-0 z-50 w-72 transform transition-all duration-500 cubic-bezier(0.4, 0, 0.2, 1) lg:static lg:translate-x-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-r border-white/20 dark:border-slate-700/50 shadow-2xl"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="h-full flex flex-col">
                <div
                    class="h-24 flex items-center justify-center px-6 relative border-b border-slate-100/50 dark:border-slate-800/50">
                    <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 w-full group">
                        <div
                            class="relative w-10 h-10 flex-shrink-0 transition-transform duration-500 group-hover:rotate-12">
                            <div
                                class="absolute inset-0 bg-gradient-to-tr from-emerald-500 to-blue-500 rounded-xl blur opacity-40 group-hover:opacity-60 transition-opacity">
                            </div>
                            <img src="{{ asset('images/logo-sman2.png') }}" alt="Logo"
                                class="relative w-full h-full object-contain drop-shadow-sm">
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-lg font-bold text-slate-800 dark:text-white tracking-tight leading-none">SMAN
                                2 KAUR</span>
                            <span
                                class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mt-1">Teacher
                                Portal</span>
                        </div>
                    </a>
                </div>

                <nav class="flex-1 px-2 space-y-2 overflow-y-auto py-6">
                    <div class="px-5 mb-2">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Menu Guru</p>
                    </div>

                    {{-- Link: Dashboard --}}
                    <a href="{{ route('teacher.dashboard') }}"
                        class="{{ $navBase }} {{ request()->routeIs('teacher.dashboard') ? $navActive : $navInactive }}">

                        <span class="relative z-10">Dashboard</span>
                        @if(request()->routeIs('teacher.dashboard'))
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer">
                            </div>
                        @endif
                    </a>

                    {{-- Link: Kelola Kelas --}}
                    <a href="{{ route('teacher.classrooms.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('teacher.classrooms.*') ? $navActive : $navInactive }}">

                        <span class="relative z-10">Kelola Kelas</span>
                        @if(request()->routeIs('teacher.classrooms.*'))
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer">
                            </div>
                        @endif
                    </a>

                    {{-- Link: Kelola Siswa --}}
                    <a href="{{ route('teacher.students.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('teacher.students.*') ? $navActive : $navInactive }}">

                        <span class="relative z-10">Kelola Siswa</span>
                        @if(request()->routeIs('teacher.students.*'))
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer">
                            </div>
                        @endif
                    </a>

                    {{-- Link: Laporan Penilaian --}}
                    <a href="{{ route('teacher.reports.index') }}"
                        class="{{ $navBase }} {{ request()->routeIs('teacher.reports.*') ? $navActive : $navInactive }}">

                        <span class="relative z-10">Laporan Penilaian</span>
                        @if(request()->routeIs('teacher.reports.*'))
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer">
                            </div>
                        @endif
                    </a>

                    {{-- Link: Absensi --}}
                    <a href="{{ route('teacher.attendance.classrooms') }}"
                        class="{{ $navBase }} {{ request()->routeIs('teacher.attendance.*') ? $navActive : $navInactive }}">

                        <span class="relative z-10">Absensi Kelas</span>
                        @if(request()->routeIs('teacher.attendance.*'))
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer">
                            </div>
                        @endif
                    </a>
                </nav>

                <div class="p-4 border-t border-slate-100 dark:border-slate-800/50">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="flex items-center gap-3 w-full p-3 rounded-2xl transition-all duration-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-lg shadow-emerald-500/20">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 text-left min-w-0">
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-200 truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Guru</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                            class="absolute bottom-full left-0 w-full mb-2 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 transform origin-bottom transition-all duration-200"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2">

                            <a href="{{ route('account.settings') }}"
                                class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Pengaturan Akun
                            </a>

                            <a href="{{ route('home') }}"
                                class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-slate-700 hover:text-emerald-600 dark:hover:text-emerald-400 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                                    </path>
                                </svg>
                                Ke Website
                            </a>

                            <div class="h-px bg-slate-100 dark:bg-slate-700 my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden transition-opacity"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            <header
                class="h-20 px-6 lg:px-10 flex items-center justify-between z-30 transition-all duration-300 bg-white/50 dark:bg-slate-900/50 backdrop-blur-md sticky top-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2 text-slate-500 hover:text-blue-600 rounded-xl transition-colors hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                            @yield('page-title', 'Dashboard Guru')
                        </h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium hidden md:block">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button
                        @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'; if (darkMode) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark')"
                        class="p-2.5 rounded-xl bg-white dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 border border-slate-200 dark:border-slate-700 shadow-sm transition-transform active:scale-95">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                            </path>
                        </svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </button>

                    {{-- Notification Dropdown --}}
                    <div x-data="{ 
                        open: false, 
                        notifications: [], 
                        unreadCount: 0,
                        loading: false,
                        async fetchNotifications() {
                            this.loading = true;
                            try {
                                const res = await fetch('/notifications/recent');
                                const data = await res.json();
                                this.notifications = data.notifications;
                                this.unreadCount = data.unread_count;
                            } catch (e) {
                                console.error('Failed to fetch notifications', e);
                            }
                            this.loading = false;
                        },
                        async markAsRead(id) {
                            await fetch(`/notifications/${id}/read`, { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content } });
                            this.notifications = this.notifications.map(n => n.id === id ? {...n, is_read: true} : n);
                            this.unreadCount = Math.max(0, this.unreadCount - 1);
                        }
                    }" @click.away="open = false" class="relative">
                        <button @click="open = !open; if(open) fetchNotifications()"
                            class="relative p-2.5 rounded-xl bg-white dark:bg-slate-800 text-slate-500 hover:text-emerald-600 dark:hover:text-emerald-400 border border-slate-200 dark:border-slate-700 shadow-sm transition-transform active:scale-95">
                            <span x-show="unreadCount > 0" x-cloak
                                class="absolute -top-1 -right-1 min-w-[18px] h-[18px] flex items-center justify-center text-[10px] font-bold bg-red-500 text-white rounded-full px-1">
                                <span x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
                            </span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </button>

                        {{-- Dropdown Panel --}}
                        <div x-show="open" x-cloak x-transition
                            class="absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 z-50 overflow-hidden">
                            <div
                                class="p-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                                <h3 class="font-bold text-slate-800 dark:text-white">Notifikasi</h3>
                                <a href="{{ route('notifications.index') }}"
                                    class="text-xs text-emerald-600 hover:underline">Lihat Semua</a>
                            </div>

                            <div class="max-h-80 overflow-y-auto">
                                <template x-if="loading">
                                    <div class="p-6 text-center text-slate-400">
                                        <svg class="animate-spin h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                        </svg>
                                    </div>
                                </template>

                                <template x-if="!loading && notifications.length === 0">
                                    <div class="p-8 text-center text-slate-400">
                                        <svg class="w-10 h-10 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                            </path>
                                        </svg>
                                        <p class="text-sm">Tidak ada notifikasi</p>
                                    </div>
                                </template>

                                <template x-for="notif in notifications" :key="notif.id">
                                    <a :href="notif.action_url || '#'" @click="markAsRead(notif.id)"
                                        class="block p-4 hover:bg-slate-50 dark:hover:bg-slate-700/50 border-b border-slate-100 dark:border-slate-700 last:border-0 transition-colors"
                                        :class="{ 'bg-emerald-50/50 dark:bg-emerald-900/10': !notif.is_read }">
                                        <div class="flex gap-3">
                                            <span class="text-xl" x-text="notif.icon"></span>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-semibold text-sm text-slate-800 dark:text-white truncate"
                                                    x-text="notif.title"></p>
                                                <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2"
                                                    x-text="notif.message"></p>
                                                <p class="text-[10px] text-slate-400 mt-1" x-text="notif.created_at">
                                                </p>
                                            </div>
                                            <span x-show="!notif.is_read"
                                                class="w-2 h-2 bg-emerald-500 rounded-full flex-shrink-0 mt-1"></span>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-8 scroll-smooth">
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center gap-3 backdrop-blur-sm">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 rounded-xl flex items-center gap-3 backdrop-blur-sm">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>