<nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg backdrop-saturate-150 shadow-lg shadow-blue-500/5 border-b border-blue-100/50 dark:border-blue-900/30 sticky top-0 z-50 transition-all duration-300"
    x-data="{ mobileMenuOpen: false }"
    @scroll.window="window.scrollY > 10 ? $el.classList.add('scrolled') : $el.classList.remove('scrolled')"
    :class="window.scrollY > 10 ? 'bg-white/95 dark:bg-slate-900/95 shadow-xl' : ''">

    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16 lg:h-20">

            <!-- Logo dengan efek modern -->
            <div class="flex items-center group">
                <a href="{{ url('/') }}"
                    class="flex items-center space-x-3 transition-transform duration-300 hover:scale-[1.02]">
                    <div class="relative">
                        <div
                            class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:shadow-blue-500/40 transition-all duration-300 overflow-hidden">
                            <picture>
                                <source srcset="{{ asset('images/logo.webp') }}" type="image/webp">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo SMAN 2 KAUR" width="48" height="48"
                                    class="w-full h-full object-contain" loading="eager" fetchpriority="high">
                            </picture>
                        </div>
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-blue-400 to-blue-600 rounded-xl opacity-0 group-hover:opacity-20 blur transition-opacity duration-300">
                        </div>
                    </div>
                    <div>
                        <span
                            class="text-sm xs:text-base lg:text-xl font-bold bg-gradient-to-r from-blue-700 to-blue-900 dark:from-blue-400 dark:to-blue-200 bg-clip-text text-transparent">SMAN
                            2 KAUR</span>
                        <span class="hidden sm:block text-xs text-gray-600 dark:text-gray-300 -mt-1 font-medium">Sistem
                            Informasi
                            Sekolah</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-1">
                <a href="{{ url('/') }}"
                    class="relative px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300 
                    {{ request()->is('/') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    @if(request()->is('/'))
                        <span
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-full"></span>
                    @endif
                    Beranda
                </a>

                <!-- Profil Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="px-5 py-2.5 rounded-lg text-sm font-medium flex items-center space-x-1 transition-all duration-300
                        {{ request()->is('profil*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }}">
                        <span>Profil</span>
                        <svg class="w-4 h-4 transition-transform duration-300" :class="{'rotate-180': open}" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        class="absolute left-0 mt-2 w-56 bg-white/90 dark:bg-slate-800/90 backdrop-blur-xl backdrop-saturate-150 rounded-xl shadow-2xl shadow-blue-500/10 border border-blue-100/30 dark:border-blue-900/30 py-2 z-50">
                        <a href="{{ url('/profil') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 hover:pl-5 transition-all duration-300">
                            Tentang Sekolah
                        </a>
                        <a href="{{ url('/visi-misi') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 hover:pl-5 transition-all duration-300">
                            Visi & Misi
                        </a>
                        <a href="{{ url('/struktur-organisasi') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 hover:pl-5 transition-all duration-300">
                            Struktur Organisasi
                        </a>
                        <a href="{{ url('/guru-staff') }}"
                            class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50/50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 hover:pl-5 transition-all duration-300">
                            Guru & Staff
                        </a>
                    </div>
                </div>

                <a href="{{ url('/berita') }}"
                    class="relative px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300
                    {{ request()->is('berita*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    @if(request()->is('berita*'))
                        <span
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-full"></span>
                    @endif
                    Berita
                </a>

                <a href="{{ url('/galeri') }}"
                    class="relative px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300
                    {{ request()->is('galeri*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    @if(request()->is('galeri*'))
                        <span
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-full"></span>
                    @endif
                    Galeri
                </a>

                <a href="{{ url('/kalender') }}"
                    class="relative px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300
                    {{ request()->is('kalender*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    @if(request()->is('kalender*'))
                        <span
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-full"></span>
                    @endif
                    Kalender
                </a>

                <a href="{{ url('/kontak') }}"
                    class="relative px-5 py-2.5 rounded-lg text-sm font-medium transition-all duration-300
                    {{ request()->is('kontak*') ? 'text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400' }}">
                    @if(request()->is('kontak*'))
                        <span
                            class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-full"></span>
                    @endif
                    Kontak
                </a>
            </div>

            <!-- Right Section: Theme & Auth -->
            <div class="flex items-center space-x-3 lg:space-x-4">
                <!-- Theme Toggle -->
                <div x-data="{
                    isDark: localStorage.getItem('darkMode') === 'true' || (localStorage.getItem('darkMode') === null && window.matchMedia('(prefers-color-scheme: dark)').matches),
                    toggle() {
                        this.isDark = !this.isDark;
                        localStorage.setItem('darkMode', this.isDark ? 'true' : 'false');
                        document.documentElement.classList.toggle('dark', this.isDark);
                    }
                }"
                    x-init="document.documentElement.classList.toggle('dark', isDark); $watch('isDark', val => document.documentElement.classList.toggle('dark', val))">
                    <button @click="toggle()" class="relative p-2.5 rounded-xl bg-gradient-to-br from-blue-50 to-white dark:from-blue-900/20 dark:to-slate-800/50 
                               border border-blue-100/50 dark:border-blue-900/30 shadow-sm hover:shadow-md 
                               transition-all duration-300 group" :title="isDark ? 'Mode Terang' : 'Mode Gelap'">
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-blue-400/0 to-blue-600/0 group-hover:from-blue-400/10 group-hover:to-blue-600/10 rounded-xl transition-all duration-300">
                        </div>
                        <svg x-show="!isDark" class="w-5 h-5 text-blue-600 dark:text-blue-400 relative z-10"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                clip-rule="evenodd" />
                        </svg>
                        <svg x-show="isDark" class="w-5 h-5 text-blue-600 dark:text-blue-400 relative z-10"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>
                </div>

                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="hidden lg:inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 
                                                                      text-white font-medium rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 
                                                                      transition-all duration-300 transform hover:-translate-y-0.5">
                        Dashboard
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @else
                    <div class="hidden lg:flex items-center space-x-3">
                        <a href="{{ route('login') }}"
                            class="px-5 py-2.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 
                                                                           transition-all duration-300 hover:-translate-y-0.5">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 
                                                                          text-white font-medium rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 
                                                                          transition-all duration-300 transform hover:-translate-y-0.5">
                            Daftar
                        </a>
                    </div>
                @endauth

                <!-- Mobile menu button -->
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="lg:hidden p-2.5 rounded-xl bg-gradient-to-br from-blue-50 to-white dark:from-blue-900/20 dark:to-slate-800/50 
                           border border-blue-100/50 dark:border-blue-900/30 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="relative w-6 h-6">
                        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4 h-0.5 
                                     bg-blue-600 dark:bg-blue-400 rounded-full transition-all duration-300"
                            :class="mobileMenuOpen ? 'rotate-45 translate-y-0' : '-translate-y-1.5'"></span>
                        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4 h-0.5 
                                     bg-blue-600 dark:bg-blue-400 rounded-full transition-all duration-300"
                            :class="mobileMenuOpen ? 'opacity-0' : 'opacity-100'"></span>
                        <span class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4 h-0.5 
                                     bg-blue-600 dark:bg-blue-400 rounded-full transition-all duration-300"
                            :class="mobileMenuOpen ? '-rotate-45 translate-y-0' : 'translate-y-1.5'"></span>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="lg:hidden bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl border-t border-blue-100/30 dark:border-blue-900/30 max-h-[85vh] overflow-y-auto">
        <div class="px-3 sm:px-4 py-4 sm:py-6 space-y-0.5 sm:space-y-1">
            <a href="{{ url('/') }}"
                class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                {{ request()->is('/') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                    </path>
                </svg>
                Beranda
            </a>

            <div class="space-y-0.5">
                <div
                    class="px-3 sm:px-4 py-1 sm:py-2 text-[10px] sm:text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                    Profil</div>
                <a href="{{ url('/profil') }}"
                    class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                    {{ request()->is('profil*') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                    <span class="w-0.5 sm:w-1 h-3 sm:h-4 bg-blue-400 rounded-full mr-2 sm:mr-3"></span>
                    Tentang Sekolah
                </a>
                <a href="{{ url('/visi-misi') }}"
                    class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                    {{ request()->is('visi-misi*') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                    <span class="w-0.5 sm:w-1 h-3 sm:h-4 bg-blue-400 rounded-full mr-2 sm:mr-3"></span>
                    Visi & Misi
                </a>
                <a href="{{ url('/struktur-organisasi') }}"
                    class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                    {{ request()->is('struktur-organisasi*') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                    <span class="w-0.5 sm:w-1 h-3 sm:h-4 bg-blue-400 rounded-full mr-2 sm:mr-3"></span>
                    Struktur Organisasi
                </a>
                <a href="{{ url('/guru-staff') }}"
                    class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                    {{ request()->is('guru-staff*') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                    <span class="w-0.5 sm:w-1 h-3 sm:h-4 bg-blue-400 rounded-full mr-2 sm:mr-3"></span>
                    Guru & Staff
                </a>
            </div>

            <a href="{{ url('/berita') }}"
                class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                {{ request()->is('berita*') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z">
                    </path>
                </svg>
                Berita
            </a>

            <a href="{{ url('/galeri') }}"
                class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                {{ request()->is('galeri*') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Galeri
            </a>

            <a href="{{ url('/kalender') }}"
                class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                {{ request()->is('kalender*') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Kalender
            </a>

            <a href="{{ url('/kontak') }}"
                class="flex items-center px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all
                {{ request()->is('kontak*') ? 'bg-blue-50/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300' : 'text-gray-700 dark:text-gray-300' }}">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                Kontak
            </a>

            <div class="pt-4 sm:pt-6 border-t border-blue-100/30 dark:border-blue-900/30 space-y-2 sm:space-y-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium text-sm sm:text-base rounded-lg sm:rounded-xl shadow-lg shadow-blue-500/30 transition-all">
                        Dashboard
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 text-blue-600 dark:text-blue-400 font-medium text-sm sm:text-base rounded-lg sm:rounded-xl border-2 border-blue-200 dark:border-blue-800 transition-all">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                            </path>
                        </svg>
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium text-sm sm:text-base rounded-lg sm:rounded-xl shadow-lg shadow-blue-500/30 transition-all">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<style>
    .scrolled {
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    .group:hover .float-animation {
        animation: float 2s ease-in-out infinite;
    }
</style>