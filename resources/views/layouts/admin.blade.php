<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="app()" x-init="init()" class="scroll-smooth"
    :class="{'dark': darkMode}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin E-Learning MAN Bengkulu Selatan</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-sidebar {
            background: linear-gradient(160deg, rgba(255, 255, 255, 0.92) 0%, rgba(248, 250, 252, 0.92) 100%);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-right: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.04), 20px 0 40px -20px rgba(16, 185, 129, 0.12);
        }

        .dark .glass-sidebar {
            background: linear-gradient(160deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.2), 20px 0 40px -20px rgba(16, 185, 129, 0.1);
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.75) 0%, rgba(248, 250, 252, 0.75) 100%);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(16, 185, 129, 0.08), 0 2px 8px rgba(0, 0, 0, 0.02);
        }

        .dark .glass-card {
            background: linear-gradient(135deg, rgba(30, 41, 59, 0.75) 0%, rgba(15, 23, 42, 0.75) 100%);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2), 0 2px 8px rgba(0, 0, 0, 0.1);
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
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.08) 0%, rgba(34, 197, 94, 0.04) 50%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 0;
        }

        .nav-item:hover::after {
            opacity: 1;
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.12) 0%, rgba(34, 197, 94, 0.06) 100%);
        }

        .dark .nav-item.active {
            background: linear-gradient(90deg, rgba(16, 185, 129, 0.2) 0%, rgba(34, 197, 94, 0.1) 100%);
        }

        .nav-indicator {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%) scaleY(0);
            width: 4px;
            height: 40%;
            background: linear-gradient(180deg, #10b981, #34d399);
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
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        .bg-gradient-body {
            background: linear-gradient(135deg, #f8fafc 0%, #ecfdf5 25%, #d1fae5 50%, #ecfdf5 75%, #f8fafc 100%);
        }

        .dark .bg-gradient-body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 25%, #064e3b 50%, #1e293b 75%, #0f172a 100%);
        }

        .gradient-text {
            background: linear-gradient(135deg, #10b981 0%, #059669 50%, #047857 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dark .gradient-text {
            background: linear-gradient(135deg, #34d399 0%, #10b981 50%, #059669 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .scrollbar-thin {
            scrollbar-width: thin;
            scrollbar-color: rgba(16, 185, 129, 0.3) transparent;
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: rgba(16, 185, 129, 0.3);
            border-radius: 20px;
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

        .animate-slide-in {
            animation: slideIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-up {
            animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
    <script>
        function app() {
            return {
                sidebarOpen: false,
                darkMode: false,
                init() {
                    const storedDarkMode = localStorage.getItem('darkMode');
                    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    this.darkMode = storedDarkMode === 'true' || (storedDarkMode === null && systemPrefersDark);
                    document.documentElement.classList.toggle('dark', this.darkMode);
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (!localStorage.getItem('darkMode')) { this.darkMode = e.matches; }
                    });
                },
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('darkMode', this.darkMode);
                    document.documentElement.classList.toggle('dark', this.darkMode);
                },
                toggleSidebar() { this.sidebarOpen = !this.sidebarOpen; }
            }
        }
    </script>
</head>

<body class="bg-gradient-body min-h-screen transition-colors duration-500" x-data="app()">
    <div x-show="sidebarOpen" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-300"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"></div>

    <div class="flex min-h-screen relative overflow-hidden">
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
            class="glass-sidebar fixed top-0 left-0 z-50 w-72 h-screen transform transition-transform duration-500 lg:translate-x-0 flex flex-col">
            <div class="p-5 border-b border-slate-200/40 dark:border-slate-700/40">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="relative">
                            <div
                                class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 p-0.5 shadow-lg shadow-emerald-500/30 group-hover:shadow-emerald-500/50 transition-all duration-300">
                                <div
                                    class="w-full h-full rounded-xl bg-white dark:bg-slate-900 flex items-center justify-center overflow-hidden">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-base font-bold text-slate-900 dark:text-white">MAN Bengkulu Selatan</span>
                            <span class="text-xs font-medium gradient-text">Admin Panel</span>
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

            <nav class="flex-1 p-4 space-y-1 overflow-y-auto scrollbar-thin">
                <div class="px-3 py-2">
                    <span
                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Utama</span>
                </div>
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl relative {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-9 h-9 rounded-lg flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-emerald-500 dark:text-emerald-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-slate-200 text-sm">Dashboard</span>
                </a>

                <div class="px-3 py-2 mt-4">
                    <span
                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengguna</span>
                </div>
                <a href="{{ route('admin.users.index') }}?role=guru"
                    class="nav-item flex items-center px-4 py-3 rounded-xl relative {{ request()->routeIs('admin.users.*') && request('role') === 'guru' ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-9 h-9 rounded-lg flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') && request('role') === 'guru' ? 'text-white' : 'text-teal-500 dark:text-teal-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-slate-200 text-sm">Kelola Guru</span>
                </a>
                <a href="{{ route('admin.users.index') }}?role=siswa"
                    class="nav-item flex items-center px-4 py-3 rounded-xl relative {{ request()->routeIs('admin.users.*') && request('role') === 'siswa' ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-9 h-9 rounded-lg flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.users.*') && request('role') === 'siswa' ? 'text-white' : 'text-cyan-500 dark:text-cyan-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-slate-200 text-sm">Kelola Siswa</span>
                </a>

                <div class="px-3 py-2 mt-4">
                    <span
                        class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengaturan</span>
                </div>
                <a href="{{ route('account.settings') }}"
                    class="nav-item flex items-center px-4 py-3 rounded-xl relative {{ request()->routeIs('account.*') ? 'active' : '' }}">
                    <span class="nav-indicator"></span>
                    <div
                        class="nav-icon w-9 h-9 rounded-lg flex items-center justify-center mr-3 bg-slate-100 dark:bg-slate-800/50">
                        <svg class="w-5 h-5 {{ request()->routeIs('account.*') ? 'text-white' : 'text-slate-500 dark:text-slate-400' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-slate-200 text-sm">Pengaturan Akun</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-6 px-4">
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

        <main class="flex-1 min-w-0 overflow-hidden lg:ml-72">
            <header
                class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-700/50 sticky top-0 z-30">
                <div class="px-4 sm:px-6 py-4 flex items-center justify-between">
                    <button @click="toggleSidebar()"
                        class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        <svg class="w-6 h-6 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center space-x-3 ml-auto">
                        <button @click="toggleDarkMode()"
                            class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-300 hover:scale-105">
                            <svg x-show="!darkMode" class="w-5 h-5 text-emerald-600" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg x-show="darkMode" x-cloak class="w-5 h-5 text-emerald-400" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                            </svg>
                        </button>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center space-x-3 focus:outline-none group">
                                <div class="text-right hidden sm:block">
                                    <p
                                        class="text-sm font-bold text-slate-800 dark:text-white group-hover:text-emerald-500 transition-colors">
                                        {{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 capitalize">
                                        {{ auth()->user()->role }}</p>
                                </div>
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-tr from-emerald-500 to-green-600 p-0.5 shadow-lg group-hover:shadow-emerald-500/50 transition-all duration-300">
                                    <div class="w-full h-full rounded-full bg-white dark:bg-slate-800 overflow-hidden">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=10b981&color=fff"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </button>
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
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">Keluar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto">
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>