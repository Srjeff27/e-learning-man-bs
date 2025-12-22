<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function () {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'true' || (darkMode === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <style>
        .glass-sidebar {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }

        .dark .glass-sidebar {
            background: linear-gradient(135deg, rgba(2, 6, 23, 0.98) 0%, rgba(15, 23, 42, 0.98) 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark .glass-card {
            background: rgba(30, 41, 59, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-item {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 0;
            background: linear-gradient(180deg, #3b82f6, #06b6d4);
            border-radius: 0 4px 4px 0;
            transition: height 0.3s ease;
        }

        .nav-item.active::before,
        .nav-item:hover::before {
            height: 60%;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.15) 0%, transparent 100%);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.4s ease forwards;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-slate-100 via-blue-50 to-slate-100 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 min-h-screen transition-colors duration-300"
    x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <aside
            class="glass-sidebar fixed inset-y-0 left-0 z-50 w-72 transform transition-all duration-300 ease-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl shadow-blue-900/20"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div class="flex items-center justify-between h-20 px-6 border-b border-white/10">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                    <div class="relative">
                        <div
                            class="w-11 h-11 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:shadow-blue-500/40 transition-all duration-300 overflow-hidden bg-white">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                class="w-full h-full object-contain p-1">
                        </div>
                    </div>
                    <div>
                        <span class="text-white font-bold text-lg">Admin Panel</span>
                        <p class="text-xs text-blue-300/70">SMAN 2 KAUR</p>
                    </div>
                </a>
                <button @click="sidebarOpen = false"
                    class="lg:hidden p-2 rounded-lg text-slate-400 hover:text-white hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="px-4 py-6 space-y-2 overflow-y-auto" style="max-height: calc(100vh - 200px);">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-blue-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="font-medium">Dashboard</span>
                </a>

                <div class="pt-6 pb-2">
                    <span class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Pengguna</span>
                </div>

                <a href="{{ route('admin.teachers.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.teachers.*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-emerald-500/20 to-teal-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.teachers.*') ? 'text-emerald-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="font-medium">Kelola Guru & Staff</span>
                </a>

                <a href="{{ route('admin.users.index') }}?role=siswa"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') && request('role') === 'siswa' ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-cyan-500/20 to-sky-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') && request('role') === 'siswa' ? 'text-cyan-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">Kelola Siswa</span>
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.users.*') && !request('role') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500/20 to-violet-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') && !request('role') ? 'text-indigo-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="font-medium">Semua Pengguna</span>
                </a>

                <div class="pt-6 pb-2">
                    <span class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Konten</span>
                </div>

                <a href="{{ route('admin.profile.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.profile.*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-blue-500/20 to-indigo-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.profile.*') ? 'text-blue-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="font-medium">Profil Sekolah</span>
                </a>

                <a href="{{ route('admin.banners.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.banners.*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-amber-500/20 to-orange-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.banners.*') ? 'text-amber-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-medium">Kelola Banner</span>
                </a>

                <a href="{{ route('admin.news.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.news.*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-green-500/20 to-emerald-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.news.*') ? 'text-green-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <span class="font-medium">Kelola Berita</span>
                </a>

                <a href="{{ route('admin.galleries.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.galleries.*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-violet-500/20 to-purple-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.galleries.*') ? 'text-violet-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-medium">Kelola Galeri</span>
                </a>

                <a href="{{ route('admin.calendar.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.calendar.*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-cyan-500/20 to-teal-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.calendar.*') ? 'text-cyan-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-medium">Kelola Kalender</span>
                </a>

                <a href="{{ route('admin.contacts.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl transition-all duration-300 {{ request()->routeIs('admin.contacts.*') ? 'active text-white' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                    <div
                        class="w-9 h-9 rounded-lg bg-gradient-to-br from-rose-500/20 to-pink-500/20 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.contacts.*') ? 'text-rose-400' : 'text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-medium">Kelola Pesan</span>
                </a>
            </nav>


            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10 bg-slate-900/50">
                <div class="flex items-center space-x-3 mb-3">
                    <div
                        class="w-11 h-11 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/30">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-medium text-slate-400 hover:text-white hover:bg-white/10 rounded-xl transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header
                class="glass-card h-20 flex items-center justify-between px-6 border-b border-slate-200/50 dark:border-slate-700/50 shadow-sm">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = true"
                        class="lg:hidden p-2.5 rounded-xl text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold text-slate-900 dark:text-white">@yield('page-title', 'Dashboard')
                        </h1>
                        <p class="text-sm text-slate-500 dark:text-slate-400 hidden sm:block">
                            @yield('page-subtitle', 'Selamat datang di panel admin')</p>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div x-data="{
                        isDark: localStorage.getItem('darkMode') === 'true' || (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches),
                        toggle() {
                            this.isDark = !this.isDark;
                            localStorage.setItem('darkMode', this.isDark ? 'true' : 'false');
                            document.documentElement.classList.toggle('dark', this.isDark);
                        }
                    }" x-init="document.documentElement.classList.toggle('dark', isDark)">
                        <button @click="toggle()"
                            class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-300"
                            :title="isDark ? 'Mode Terang' : 'Mode Gelap'">
                            <svg x-show="!isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                            <svg x-show="isDark" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                    </div>

                    <a href="{{ route('home') }}" target="_blank"
                        class="hidden sm:inline-flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition-all duration-300">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        Lihat Website
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                @if (session('success'))
                    <div
                        class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-xl flex items-center animate-fade-in">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-6 p-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-xl flex items-center animate-fade-in">
                        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <div class="animate-fade-in">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"></div>
</body>

</html>