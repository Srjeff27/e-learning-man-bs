<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="app()" x-init="init()" class="scroll-smooth"
    :class="{'dark': darkMode}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Panel SMAN 2 KAUR</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

        :root {
            --primary-gradient: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            --glass-light: rgba(255, 255, 255, 0.85);
            --glass-dark: rgba(15, 23, 42, 0.85);
            --glow-shadow: 0 20px 40px rgba(37, 99, 235, 0.15);
        }

        body {
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
        }

        .glass-sidebar {
            background: linear-gradient(160deg,
                    rgba(255, 255, 255, 0.92) 0%,
                    rgba(248, 250, 252, 0.92) 100%);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-right: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow:
                0 4px 24px rgba(0, 0, 0, 0.04),
                20px 0 40px -20px rgba(37, 99, 235, 0.12);
        }

        .dark .glass-sidebar {
            background: linear-gradient(160deg,
                    rgba(15, 23, 42, 0.95) 0%,
                    rgba(30, 41, 59, 0.95) 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow:
                0 4px 24px rgba(0, 0, 0, 0.2),
                20px 0 40px -20px rgba(37, 99, 235, 0.1);
        }

        .glass-card {
            background: linear-gradient(135deg,
                    rgba(255, 255, 255, 0.75) 0%,
                    rgba(248, 250, 252, 0.75) 100%);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow:
                0 8px 32px rgba(37, 99, 235, 0.08),
                0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .dark .glass-card {
            background: linear-gradient(135deg,
                    rgba(30, 41, 59, 0.75) 0%,
                    rgba(15, 23, 42, 0.75) 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.2),
                0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-item {
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg,
                    rgba(37, 99, 235, 0.08) 0%,
                    rgba(59, 130, 246, 0.04) 50%,
                    transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
        }

        .nav-item:hover::after {
            opacity: 1;
        }

        .nav-item.active {
            background: linear-gradient(90deg,
                    rgba(37, 99, 235, 0.12) 0%,
                    rgba(59, 130, 246, 0.06) 100%);
        }

        .dark .nav-item.active {
            background: linear-gradient(90deg,
                    rgba(37, 99, 235, 0.2) 0%,
                    rgba(59, 130, 246, 0.1) 100%);
        }

        .nav-indicator {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 4px;
            height: 40%;
            background: linear-gradient(180deg, #3b82f6, #60a5fa);
            border-radius: 0 2px 2px 0;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .nav-item.active .nav-indicator {
            transform: translateY(-50%) scaleY(1);
        }

        .nav-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            z-index: 1;
        }

        .nav-item.active .nav-icon {
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }

        .user-avatar {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            box-shadow:
                0 8px 32px rgba(37, 99, 235, 0.25),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .bg-gradient-body {
            background: linear-gradient(135deg,
                    #f8fafc 0%,
                    #f0f9ff 25%,
                    #e0f2fe 50%,
                    #f0f9ff 75%,
                    #f8fafc 100%);
        }

        .dark .bg-gradient-body {
            background: linear-gradient(135deg,
                    #0f172a 0%,
                    #1e293b 25%,
                    #1e3a8a 50%,
                    #1e293b 75%,
                    #0f172a 100%);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }

            50% {
                box-shadow: 0 0 40px rgba(59, 130, 246, 0.6);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-up {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        .hamburger-line {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }

        .sidebar-open .hamburger-line:nth-child(1) {
            transform: rotate(45deg) translate(6px, 6px);
        }

        .sidebar-open .hamburger-line:nth-child(2) {
            opacity: 0;
            transform: translateX(-20px);
        }

        .sidebar-open .hamburger-line:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
        }

        .dark-mode-toggle {
            background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark .dark-mode-toggle {
            background: linear-gradient(135deg, #475569 0%, #334155 100%);
        }

        .dark-mode-toggle::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background: white;
            border-radius: 50%;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .dark .dark-mode-toggle::after {
            transform: translateX(24px);
            background: #f8fafc;
        }

        .notification-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 8px;
            height: 8px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.9);
        }

        .dark .notification-badge {
            box-shadow: 0 0 0 2px rgba(15, 23, 42, 0.9);
        }

        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: rgba(59, 130, 246, 0.3) transparent;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgba(59, 130, 246, 0.3);
            border-radius: 20px;
        }

        .logo-shine {
            position: relative;
            overflow: hidden;
        }

        .logo-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg,
                    transparent 30%,
                    rgba(255, 255, 255, 0.4) 50%,
                    transparent 70%);
            transform: rotate(30deg);
            animation: shine 3s infinite linear;
        }

        @keyframes shine {
            0% {
                transform: translateX(-100%) rotate(30deg);
            }

            100% {
                transform: translateX(100%) rotate(30deg);
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 50%, #1d4ed8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dark .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 50%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>

    <script>
        function app() {
            return {
                sidebarOpen: false,
                darkMode: false,
                notifications: 3,

                init() {
                    const storedDarkMode = localStorage.getItem('darkMode');
                    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    this.darkMode = storedDarkMode === 'true' || (storedDarkMode === null && systemPrefersDark);
                    document.documentElement.classList.toggle('dark', this.darkMode);

                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (!localStorage.getItem('darkMode')) {
                            this.darkMode = e.matches;
                        }
                    });
                },

                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('darkMode', this.darkMode);
                    document.documentElement.classList.toggle('dark', this.darkMode);
                },

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                }
            }
        }
    </script>
</head>

<body class="bg-gradient-body min-h-screen transition-colors duration-500" x-data="app()">
    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"></div>

    <div class="flex min-h-screen relative overflow-hidden">
        <!-- Sidebar -->
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            class="glass-sidebar fixed top-0 left-0 z-50 w-80 h-screen transform transition-transform duration-500 lg:translate-x-0 flex flex-col">

            <!-- Logo & Brand -->
            <div class="p-6 border-b border-slate-200/40 dark:border-slate-700/40">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-4 group">
                        <div class="relative logo-shine">
                            <div
                                class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-800 flex items-center justify-center overflow-hidden shadow-xl">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                            </div>
                            <div
                                class="absolute -inset-2 bg-blue-500/10 rounded-2xl blur-xl group-hover:blur-2xl transition-all duration-500">
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-slate-900 dark:text-white">SMAN 2 KAUR</span>
                            <span class="text-sm font-medium gradient-text">Admin Panel</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false"
                        class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-thin">
                <!-- Main Section -->
                <div class="px-3 py-3">
                    <span
                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Utama</span>
                </div>

                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-500 dark:text-blue-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Dashboard</span>
                </a>

                <!-- Users Section -->
                <div class="px-3 py-3 mt-6">
                    <span
                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengguna</span>
                </div>

                <a href="{{ route('admin.users.index') }}?role=guru"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('admin.users.*') && request('role') === 'guru' ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') && request('role') === 'guru' ? 'text-white' : 'text-emerald-500 dark:text-emerald-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Kelola Guru</span>
                </a>

                <a href="{{ route('admin.users.index') }}?role=siswa"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('admin.users.*') && request('role') === 'siswa' ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') && request('role') === 'siswa' ? 'text-white' : 'text-cyan-500 dark:text-cyan-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Kelola Siswa</span>
                </a>

                <!-- Content Section -->
                <div class="px-3 py-3 mt-6">
                    <span
                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Konten</span>
                </div>

                <a href="{{ route('admin.news.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.news.*') ? 'text-white' : 'text-green-500 dark:text-green-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Berita & Artikel</span>
                </a>

                <a href="{{ route('admin.banners.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.banners.*') ? 'text-white' : 'text-amber-500 dark:text-amber-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Kelola Pengumuman</span>
                </a>

                <a href="{{ route('admin.gallery.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.galleries.*') ? 'text-white' : 'text-violet-500 dark:text-violet-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Galeri Sekolah</span>
                </a>

                <a href="{{ route('admin.calendar.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('admin.calendar.*') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.calendar.*') ? 'text-white' : 'text-teal-500 dark:text-teal-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Kalender</span>
                </a>

                <!-- Settings Section -->
                <div class="px-3 py-3 mt-6">
                    <span
                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengaturan</span>
                </div>

                <a href="{{ route('admin.profile.index') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.profile.*') ? 'text-white' : 'text-indigo-500 dark:text-indigo-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Profil Sekolah</span>
                </a>

                <a href="{{ route('account.settings') }}"
                    class="nav-item flex items-center px-4 py-3.5 rounded-xl relative {{ request()->routeIs('account.*') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-10 h-10 rounded-xl flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('account.*') ? 'text-white' : 'text-slate-500 dark:text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold text-slate-700 dark:text-slate-200 text-sm">Pengaturan Akun</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-8 mb-4 px-4">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-3 rounded-xl bg-red-500/10 hover:bg-red-500 text-red-600 hover:text-white transition-all duration-300 group">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="font-semibold text-sm">Keluar</span>
                    </button>
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0 overflow-hidden lg:ml-80">
            <!-- Top Header -->
            <header
                class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-700/50 sticky top-0 z-30">
                <div class="px-6 py-4 flex items-center justify-between">
                    <button @click="toggleSidebar()"
                        class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-6 h-6 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="flex items-center space-x-4 ml-auto">
                        <!-- Dark Mode Toggle -->
                        <button @click="toggleDarkMode()"
                            class="dark-mode-toggle w-12 h-6 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-300 hover:scale-105 active:scale-95">
                        </button>

                        <!-- Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center space-x-3 focus:outline-none group">
                                <div class="text-right hidden md:block">
                                    <p class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-blue-500">
                                        {{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 capitalize">{{ auth()->user()->role }}
                                    </p>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-600 p-0.5 shadow-lg group-hover:shadow-blue-500/50 transition-all duration-300">
                                    <div class="w-full h-full rounded-full bg-white dark:bg-slate-800 overflow-hidden">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=random"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 translate-y-0"
                                x-transition:leave-end="opacity-0 translate-y-2" style="display: none;"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-slate-100 dark:border-slate-700 py-1 z-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6 lg:p-8 max-w-7xl mx-auto">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>
