<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'LMS') - SMAN 2 KAUR</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: #cbd5e1; border-radius: 9999px; }
        .dark ::-webkit-scrollbar-thumb { background-color: #334155; }

        /* Animasi Shimmer untuk tombol aktif */
        @keyframes shimmer {
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: shimmer 2.5s infinite;
        }
    </style>
</head>

<body class="font-['Plus_Jakarta_Sans'] bg-slate-50 dark:bg-slate-950 text-slate-600 dark:text-slate-400 antialiased selection:bg-blue-500 selection:text-white relative overflow-hidden"
    x-data="{ sidebarOpen: false, darkMode: localStorage.theme === 'dark' }">

    {{-- 
        ========================================================
        DEFINISI CLASS STYLING (Agar kode HTML tetap bersih)
        ========================================================
    --}}
    @php
        // Style Dasar Tombol
        $navBase = "relative flex items-center gap-3 px-4 py-3.5 rounded-2xl font-medium text-sm transition-all duration-300 overflow-hidden group mx-3 mb-1";
        
        // Style Saat Tidak Aktif (Hover Effect)
        $navInactive = "text-slate-500 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-slate-800/60 hover:text-blue-600 dark:hover:text-blue-400 hover:translate-x-1";
        
        // Style Saat Aktif (GLOSSY BLUE EFFECT)
        // Menggunakan before: untuk efek pantulan kaca di setengah bagian atas
        $navActive = "bg-gradient-to-br from-blue-600 to-indigo-600 text-white shadow-lg shadow-blue-500/30 ring-1 ring-white/20 
                      before:absolute before:inset-x-0 before:top-0 before:h-1/2 before:bg-gradient-to-b before:from-white/20 before:to-transparent";
    @endphp

    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden">
        <div class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-blue-500/10 rounded-full blur-[100px] opacity-70"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-indigo-500/10 rounded-full blur-[100px] opacity-70"></div>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <aside class="fixed inset-y-0 left-0 z-50 w-72 transform transition-all duration-500 cubic-bezier(0.4, 0, 0.2, 1) lg:static lg:translate-x-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-r border-white/20 dark:border-slate-700/50 shadow-2xl"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
            
            <div class="h-full flex flex-col">
                <div class="h-24 flex items-center justify-center px-6 relative border-b border-slate-100/50 dark:border-slate-800/50">
                    <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 w-full group">
                        <div class="relative w-10 h-10 flex-shrink-0 transition-transform duration-500 group-hover:rotate-12">
                            <div class="absolute inset-0 bg-blue-500 rounded-xl blur opacity-40 group-hover:opacity-60 transition-opacity"></div>
                            <img src="{{ asset('images/logo-sman2.png') }}" alt="Logo" class="relative w-full h-full object-contain drop-shadow-sm">
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-bold text-slate-800 dark:text-white tracking-tight leading-none">SMAN 2 KAUR</span>
                            <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-widest mt-1">Student Portal</span>
                        </div>
                    </a>
                </div>

                <nav class="flex-1 px-2 space-y-2 overflow-y-auto py-6">
                    <div class="px-5 mb-2">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Main Menu</p>
                    </div>

                    {{-- Link: Dashboard --}}
                    <a href="{{ route('student.dashboard') }}" 
                       class="{{ $navBase }} {{ request()->routeIs('student.dashboard') ? $navActive : $navInactive }}">
                        {{-- Icon --}}
                        <svg class="w-5 h-5 flex-shrink-0 relative z-10 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        
                        <span class="relative z-10">Dashboard</span>
                        
                        {{-- Shimmer Effect (Hanya muncul jika aktif) --}}
                        @if(request()->routeIs('student.dashboard'))
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer"></div>
                        @endif
                    </a>

                    {{-- Link: Kelas Saya --}}
                    <a href="{{ route('student.classrooms.index') }}" 
                       class="{{ $navBase }} {{ request()->routeIs('student.classrooms.*') ? $navActive : $navInactive }}">
                        <svg class="w-5 h-5 flex-shrink-0 relative z-10 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        
                        <span class="relative z-10">Kelas Saya</span>
                        
                         @if(request()->routeIs('student.classrooms.*'))
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer"></div>
                        @endif
                    </a>

                    {{-- Link: Tugas --}}
                    <a href="{{ route('student.assignments.index') }}" 
                       class="{{ $navBase }} {{ request()->routeIs('student.assignments.index') ? $navActive : $navInactive }}">
                        <svg class="w-5 h-5 flex-shrink-0 relative z-10 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        
                        <span class="relative z-10">Tugas</span>
                        
                         @if(request()->routeIs('student.assignments.index'))
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full animate-shimmer"></div>
                        @endif
                    </a>
                </nav>

                <div class="p-4 border-t border-slate-100 dark:border-slate-800/50">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-3 w-full p-3 rounded-2xl transition-all duration-300 hover:bg-slate-50 dark:hover:bg-slate-800/50 border border-transparent hover:border-slate-200 dark:hover:border-slate-700">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-500/20">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 text-left min-w-0">
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-200 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Siswa</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak
                            class="absolute bottom-full left-0 w-full mb-2 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 p-2 transform origin-bottom transition-all duration-200"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 translate-y-2">
                            
                            <a href="{{ route('account.settings') }}" class="flex items-center gap-3 px-3 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Pengaturan
                            </a>
                            <div class="h-px bg-slate-100 dark:bg-slate-700 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak 
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden transition-opacity"
            x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        </div>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            
            <header class="h-20 px-6 lg:px-10 flex items-center justify-between z-30 transition-all duration-300 bg-white/50 dark:bg-slate-900/50 backdrop-blur-md sticky top-0">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-500 hover:text-blue-600 rounded-xl transition-colors hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    </button>
                    <div>
                        <h1 class="text-xl lg:text-2xl font-bold text-slate-800 dark:text-white tracking-tight">
                            @yield('page-title', 'Overview')
                        </h1>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium hidden md:block">
                            {{ now()->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'; if (darkMode) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark')"
                        class="p-2.5 rounded-xl bg-white dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 border border-slate-200 dark:border-slate-700 shadow-sm transition-transform active:scale-95">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </button>

                    <button class="relative p-2.5 rounded-xl bg-white dark:bg-slate-800 text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 border border-slate-200 dark:border-slate-700 shadow-sm transition-transform active:scale-95">
                        <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-slate-800 animate-pulse"></span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-8 scroll-smooth">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl flex items-center gap-3 backdrop-blur-sm">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>