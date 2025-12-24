@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', 'SMAN 2 KAUR - Sekolah Unggulan dengan Program Akademik Berkualitas dan Fasilitas Modern')

@push('preload')
    @if(isset($latestNews) && $latestNews->first() && $latestNews->first()->featured_image)
        <link rel="preload" href="{{ asset('storage/' . $latestNews->first()->featured_image) }}" as="image" fetchpriority="high">
    @endif
@endpush

@section('content')
    {{-- Announcement Banner --}}
    @if($banner)
        <div x-data="{ showBanner: true }" x-show="showBanner" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="relative bg-gradient-to-r from-blue-600 to-cyan-500 text-white overflow-hidden">

            <div class="container mx-auto px-3 py-2 relative z-10">
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2 flex-1 min-w-0">
                        <span class="flex-shrink-0 flex items-center justify-center w-6 h-6 bg-white/20 rounded-full">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </span>
                        <p class="text-xs sm:text-sm font-medium truncate">
                            <span class="font-bold">{{ $banner->title }}:</span>
                            <span class="ml-1 opacity-90">{{ Str::limit($banner->content, 60) }}</span>
                        </p>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        @if($banner->link)
                            <a href="{{ $banner->link }}"
                                class="hidden sm:inline-flex items-center px-3 py-1 bg-white/20 hover:bg-white/30 rounded text-xs font-semibold transition-colors">
                                {{ $banner->link_text ?? 'Lihat' }}
                                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        @endif
                        <button type="button" @click="showBanner = false"
                            class="p-1 hover:bg-white/20 rounded transition-colors focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Hero Slider --}}
    @if($latestNews->count() > 0)
        <div x-data="{
                                                                    currentSlide: 0,
                                                                    totalSlides: {{ $latestNews->count() }},
                                                                    autoSlideInterval: null,
                                                                    init() { this.startAutoSlide(); },
                                                                    startAutoSlide() { this.autoSlideInterval = setInterval(() => { this.nextSlide(); }, 5000); },
                                                                    stopAutoSlide() { if(this.autoSlideInterval) clearInterval(this.autoSlideInterval); },
                                                                    nextSlide() { this.currentSlide = (this.currentSlide + 1) % this.totalSlides; },
                                                                    prevSlide() { this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides; },
                                                                    goToSlide(index) { this.currentSlide = index; this.stopAutoSlide(); this.startAutoSlide(); }
                                                                }"
            class="relative h-[350px] xs:h-[400px] md:h-[550px] lg:h-[650px] overflow-hidden" @mouseenter="stopAutoSlide()"
            @mouseleave="startAutoSlide()">

            {{-- Background Slides --}}
            <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900">
                @foreach($latestNews as $index => $news)
                    <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 scale-110" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95" class="absolute inset-0">
                        @if($news->featured_image)
                            <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" width="1920"
                                height="1080"
                                class="absolute inset-0 w-full h-full object-cover transform transition-transform duration-[10000ms] hover:scale-105"
                                @if($index === 0) loading="eager" fetchpriority="high" @else loading="lazy" @endif>
                        @endif

                        {{-- Gradient Overlays --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-slate-900/30"></div>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/50 via-transparent to-transparent"></div>

                        {{-- Animated Floating Orbs --}}
                        <div class="absolute inset-0 overflow-hidden pointer-events-none">
                            <div
                                class="absolute -top-20 -left-20 w-80 h-80 bg-blue-500/20 rounded-full blur-3xl animate-float-slow">
                            </div>
                            <div class="absolute -bottom-20 -right-20 w-96 h-96 bg-cyan-500/15 rounded-full blur-3xl animate-float-slow"
                                style="animation-delay: 2s;"></div>
                            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl animate-float-slow"
                                style="animation-delay: 4s;"></div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Slide Content --}}
            <div class="relative h-full container mx-auto px-4 md:px-6 lg:px-8 flex items-end pb-16 md:pb-24 lg:pb-32">
                @foreach($latestNews as $index => $news)
                    <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-700 delay-200"
                        x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0 -translate-y-4" class="text-white max-w-3xl">

                        <div class="inline-flex items-center gap-3 mb-4 animate-slide-up" style="animation-delay: 0.3s;">
                            <span
                                class="px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold tracking-wider uppercase shadow-lg">
                                {{ $news->category ?? 'Berita' }}
                            </span>
                            <span class="text-sm text-white/70 font-medium">{{ $news->created_at->format('d M Y') }}</span>
                        </div>

                        <h2 class="text-2xl xs:text-3xl md:text-5xl lg:text-6xl font-extrabold mb-4 md:mb-5 leading-tight animate-slide-up"
                            style="animation-delay: 0.4s;">
                            {{ $news->title }}
                        </h2>

                        <p class="text-sm xs:text-base md:text-lg text-white/80 mb-6 md:mb-8 max-w-2xl leading-relaxed animate-slide-up hidden xs:block"
                            style="animation-delay: 0.5s;">
                            {{ Str::limit($news->excerpt ?? $news->content, 180) }}
                        </p>

                        <a href="{{ url('/berita') }}"
                            class="inline-flex items-center px-5 py-3 md:px-8 md:py-4 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl font-bold text-sm md:text-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-white/20 group animate-slide-up"
                            style="animation-delay: 0.6s;">
                            Baca Selengkapnya
                            <svg class="w-5 h-5 ml-3 group-hover:translate-x-2 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Slide Indicators (swipe to navigate) --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-3 z-20">
                @for($i = 0; $i < $latestNews->count(); $i++)
                    <button type="button" @click="goToSlide({{ $i }})"
                        :class="currentSlide === {{ $i }} ? 'w-10 bg-white shadow-lg shadow-white/30' : 'w-3 bg-white/40 hover:bg-white/60'"
                        class="h-3 rounded-full transition-all duration-500 focus:outline-none"></button>
                @endfor
            </div>
        </div>
    @endif

    {{-- Stats Section --}}
    <section
        class="py-12 sm:py-16 md:py-28 relative overflow-hidden bg-gradient-to-b from-white via-blue-50/30 to-white dark:from-slate-900 dark:via-blue-950/30 dark:to-slate-900">
        {{-- Floating Orbs Background --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="floating-orb floating-orb-1 -top-40 -left-40"></div>
            <div class="floating-orb floating-orb-2 top-1/3 -right-60"></div>
            <div class="floating-orb floating-orb-3 -bottom-40 left-1/4"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-8 sm:mb-12 md:mb-20">
                <span
                    class="inline-block px-3 sm:px-5 py-1.5 sm:py-2 bg-blue-100/80 dark:bg-blue-900/50 backdrop-blur-sm text-blue-600 dark:text-blue-400 rounded-full text-xs sm:text-sm font-bold tracking-wide mb-3 sm:mb-5 animate-bounce-subtle shadow-lg shadow-blue-100/50 dark:shadow-blue-900/30">
                    Prestasi & Pencapaian
                </span>
                <h2
                    class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 dark:text-white mb-3 sm:mb-5">
                    Menjadi yang <span class="gradient-text">Terbaik</span>
                </h2>
                <p
                    class="text-sm sm:text-base md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed px-4">
                    Komitmen kami dalam memberikan pendidikan berkualitas
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-6 md:gap-8">
                {{-- Stat Card 1 --}}
                <div class="glass-card glossy rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.1s;">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto mb-3 sm:mb-5 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/30 glossy">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197" />
                        </svg>
                    </div>
                    <div class="text-xl sm:text-3xl md:text-5xl font-black text-slate-800 dark:text-white mb-1">1,200+</div>
                    <div class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 font-semibold">Siswa
                        Aktif</div>
                </div>

                {{-- Stat Card 2 --}}
                <div class="glass-card glossy rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.2s;">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto mb-3 sm:mb-5 bg-gradient-to-br from-cyan-500 to-blue-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl shadow-cyan-500/30 glossy">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div class="text-xl sm:text-3xl md:text-5xl font-black text-slate-800 dark:text-white mb-1">75+</div>
                    <div class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 font-semibold">Guru &
                        Staff</div>
                </div>

                {{-- Stat Card 3 --}}
                <div class="glass-card glossy rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.3s;">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto mb-3 sm:mb-5 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl shadow-indigo-500/30 glossy">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                    <div class="text-xl sm:text-3xl md:text-5xl font-black text-slate-800 dark:text-white mb-1">50+</div>
                    <div class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 font-semibold">Prestasi
                    </div>
                </div>

                {{-- Stat Card 4 --}}
                <div class="glass-card glossy rounded-2xl sm:rounded-3xl p-4 sm:p-6 md:p-8 text-center card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.4s;">
                    <div
                        class="w-12 h-12 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto mb-3 sm:mb-5 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl shadow-blue-600/30 glossy">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-xl sm:text-3xl md:text-5xl font-black text-slate-800 dark:text-white mb-1">30+</div>
                    <div class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 font-semibold">Tahun
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section
        class="py-12 sm:py-16 md:py-28 relative overflow-hidden bg-gradient-to-b from-white via-slate-50/50 to-white dark:from-slate-900 dark:via-slate-800/50 dark:to-slate-900">
        {{-- Floating Orbs --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="floating-orb floating-orb-2 -top-20 -right-40"></div>
            <div class="floating-orb floating-orb-1 bottom-0 -left-40"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-8 sm:mb-12 md:mb-20">
                <span
                    class="inline-block px-3 sm:px-5 py-1.5 sm:py-2 bg-blue-100/80 dark:bg-blue-900/50 backdrop-blur-sm text-blue-600 dark:text-blue-400 rounded-full text-xs sm:text-sm font-bold tracking-wide mb-3 sm:mb-5 animate-bounce-subtle shadow-lg shadow-blue-100/50 dark:shadow-blue-900/30">
                    Keunggulan Kami
                </span>
                <h2
                    class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 dark:text-white mb-3 sm:mb-5">
                    Pendidikan <span class="gradient-text">Berkualitas</span>
                </h2>
                <p
                    class="text-sm sm:text-base md:text-xl text-slate-600 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed px-4">
                    Sistem pembelajaran terintegrasi untuk mengembangkan potensi maksimal
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                {{-- Feature Card 1 --}}
                <div class="group glass-card glossy rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.1s;">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 shadow-xl shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300 glossy">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 sm:mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        Kurikulum Merdeka
                    </h3>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                        Pembelajaran berbasis proyek dan kebutuhan siswa
                    </p>
                </div>

                {{-- Feature Card 2 --}}
                <div class="group glass-card glossy rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.2s;">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 shadow-xl shadow-cyan-500/30 group-hover:scale-110 transition-transform glossy">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 sm:mb-3 group-hover:text-cyan-600 dark:group-hover:text-cyan-400 transition-colors">
                        Teknologi Digital
                    </h3>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                        Platform e-learning terintegrasi
                    </p>
                </div>

                {{-- Feature Card 3 --}}
                <div class="group glass-card glossy rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.3s;">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 shadow-xl shadow-indigo-500/30 group-hover:scale-110 transition-transform glossy">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 sm:mb-3 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                        Guru Berkompeten
                    </h3>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                        Didukung guru profesional bersertifikasi
                    </p>
                </div>

                {{-- Feature Card 4 --}}
                <div class="group glass-card glossy rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.4s;">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 shadow-xl shadow-purple-500/30 group-hover:scale-110 transition-transform glossy">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 sm:mb-3 group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                        Lab Modern
                    </h3>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                        Fasilitas lab lengkap dan terkini
                    </p>
                </div>

                {{-- Feature Card 5 --}}
                <div class="group glass-card glossy rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.5s;">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-pink-500 to-rose-500 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 shadow-xl shadow-pink-500/30 group-hover:scale-110 transition-transform glossy">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 sm:mb-3 group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors">
                        Ekstrakurikuler
                    </h3>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                        Beragam program untuk bakat siswa
                    </p>
                </div>

                {{-- Feature Card 6 --}}
                <div class="group glass-card glossy rounded-2xl sm:rounded-3xl p-5 sm:p-6 md:p-8 card-lift hover-glow animate-fade-up"
                    style="animation-delay: 0.6s;">
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 shadow-xl shadow-emerald-500/30 group-hover:scale-110 transition-transform glossy">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-8 md:h-8 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3
                        class="text-base sm:text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 sm:mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                        Lingkungan Aman
                    </h3>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400 leading-relaxed">
                        Sekolah nyaman dan kondusif
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-12 sm:py-16 md:py-32 relative overflow-hidden">
        {{-- Animated Gradient Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-cyan-600 animate-gradient"></div>

        {{-- Floating Orbs --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-1/4 left-1/4 w-40 sm:w-80 h-40 sm:h-80 bg-white/10 rounded-full blur-3xl animate-pulse">
            </div>
            <div class="absolute bottom-1/4 right-1/4 w-48 sm:w-96 h-48 sm:h-96 bg-cyan-400/10 rounded-full blur-3xl animate-pulse"
                style="animation-delay: 1s;"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2
                    class="text-2xl sm:text-3xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 sm:mb-8 leading-tight animate-fade-up">
                    Bergabunglah dengan Komunitas Pendidikan Berkualitas
                </h2>
                <p class="text-sm sm:text-base md:text-xl text-blue-100/90 mb-6 sm:mb-12 max-w-2xl mx-auto leading-relaxed animate-fade-up px-4"
                    style="animation-delay: 0.2s;">
                    Mari bersama-sama membangun masa depan yang cerah
                </p>
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-5 justify-center items-center animate-fade-up px-4"
                    style="animation-delay: 0.4s;">
                    <a href="{{ url('/kontak') }}"
                        class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-5 bg-white text-blue-600 hover:bg-blue-50 font-bold text-sm sm:text-lg rounded-xl sm:rounded-2xl shadow-2xl shadow-blue-900/40 transition-all duration-300 hover:scale-105 text-center">
                        Hubungi Kami
                    </a>
                    <a href="{{ route('register') }}"
                        class="w-full sm:w-auto px-6 sm:px-10 py-3 sm:py-5 bg-white/15 backdrop-blur-md text-white hover:bg-white/25 font-bold text-sm sm:text-lg rounded-xl sm:rounded-2xl border-2 border-white/30 shadow-xl transition-all duration-300 hover:scale-105 text-center">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- Latest News --}}
    <section
        class="py-12 sm:py-16 md:py-28 relative overflow-hidden bg-gradient-to-b from-white via-slate-50/30 to-white dark:from-slate-900 dark:via-slate-800/30 dark:to-slate-900">
        {{-- Floating Orbs --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="floating-orb floating-orb-3 -top-40 right-1/4"></div>
            <div class="floating-orb floating-orb-1 bottom-0 left-1/3"></div>
        </div>

        <div class="container mx-auto px-4 md:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 sm:mb-12 md:mb-20">
                <div class="animate-fade-up">
                    <span
                        class="inline-block px-3 sm:px-5 py-1.5 sm:py-2 bg-blue-100/80 dark:bg-blue-900/50 backdrop-blur-sm text-blue-600 dark:text-blue-400 rounded-full text-xs sm:text-sm font-bold tracking-wide mb-3 sm:mb-5 shadow-lg">
                        Update Terbaru
                    </span>
                    <h2 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-slate-800 dark:text-white">
                        Berita & <span class="gradient-text">Kegiatan</span>
                    </h2>
                    <p class="text-sm sm:text-lg text-slate-600 dark:text-slate-400 mt-2 sm:mt-4 max-w-xl">
                        Informasi terkini dari kegiatan sekolah
                    </p>
                </div>
                <a href="{{ url('/berita') }}"
                    class="mt-4 md:mt-0 glass-button inline-flex items-center px-4 sm:px-7 py-2.5 sm:py-4 text-blue-600 dark:text-blue-400 font-bold text-sm sm:text-base rounded-xl transition-all group animate-fade-up"
                    style="animation-delay: 0.2s;">
                    Lihat Semua
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-2 sm:ml-3 group-hover:translate-x-2 transition-transform"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                @foreach($latestNews->take(3) as $index => $news)
                    <article
                        class="group glass-card glossy rounded-2xl sm:rounded-3xl overflow-hidden card-lift hover-glow animate-fade-up"
                        style="animation-delay: {{ 0.1 * ($index + 1) }}s;">
                        <div class="relative aspect-video bg-gradient-to-br from-blue-500 to-cyan-500 overflow-hidden">
                            @if($news->featured_image)
                                <img src="{{ asset('storage/' . $news->featured_image) }}" alt="{{ $news->title }}" width="640"
                                    height="360"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    loading="lazy">
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent">
                            </div>
                            <span
                                class="absolute top-3 left-3 sm:top-4 sm:left-4 px-2.5 sm:px-4 py-1 sm:py-1.5 bg-white/20 backdrop-blur-md text-white text-[10px] sm:text-xs font-bold tracking-wide rounded-full shadow-lg">
                                {{ $news->category ?? 'Berita' }}
                            </span>
                        </div>
                        <div class="p-4 sm:p-6 md:p-7">
                            <div class="flex items-center text-xs sm:text-sm text-slate-500 dark:text-slate-400 mb-2 sm:mb-4">
                                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $news->created_at->format('d M Y') }}
                            </div>
                            <h3
                                class="text-sm sm:text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 sm:mb-4 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                {{ $news->title }}
                            </h3>
                            <p
                                class="text-slate-600 dark:text-slate-400 mb-3 sm:mb-5 line-clamp-2 leading-relaxed text-xs sm:text-sm md:text-base">
                                {{ Str::limit($news->excerpt ?? $news->content, 80) }}
                            </p>
                            <a href="{{ url('/berita') }}"
                                class="inline-flex items-center text-blue-600 dark:text-blue-400 font-bold text-xs sm:text-sm group/link">
                                Baca selengkapnya
                                <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-2 transition-transform duration-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* ==================== KEYFRAME ANIMATIONS ==================== */
        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            25% {
                transform: translateY(-8px) rotate(1deg);
            }

            50% {
                transform: translateY(-15px) rotate(0deg);
            }

            75% {
                transform: translateY(-8px) rotate(-1deg);
            }
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(15px, -20px) scale(1.03);
            }

            66% {
                transform: translate(-15px, -15px) scale(0.97);
            }
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes bounce-subtle {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            }

            50% {
                box-shadow: 0 0 50px rgba(59, 130, 246, 0.6), 0 0 80px rgba(6, 182, 212, 0.3);
            }
        }

        /* ==================== ANIMATION CLASSES ==================== */
        .animate-fade-up {
            animation: fade-up 0.8s ease-out forwards;
            opacity: 0;
        }

        .animate-slide-up {
            animation: slide-up 0.6s ease-out forwards;
            opacity: 0;
        }

        .animate-float {
            animation: float 5s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: float-slow 10s ease-in-out infinite;
        }

        .animate-shimmer {
            animation: shimmer 3s ease-in-out infinite;
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 6s ease infinite;
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2.5s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 3s ease-in-out infinite;
        }

        /* ==================== GLASS MORPHISM ==================== */
        .glass-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.06),
                0 16px 48px rgba(59, 130, 246, 0.08),
                inset 0 2px 0 rgba(255, 255, 255, 0.8);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark .glass-card {
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.4),
                0 16px 48px rgba(59, 130, 246, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        .glass-button {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.1);
        }

        .dark .glass-button {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        /* ==================== GLOSSY EFFECT ==================== */
        .glossy {
            position: relative;
            overflow: hidden;
        }

        .glossy::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 50%;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.2) 0%, transparent 100%);
            pointer-events: none;
            border-radius: inherit;
            z-index: 1;
        }

        .dark .glossy::before {
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
        }

        /* ==================== GRADIENT TEXT ==================== */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6 0%, #06b6d4 50%, #8b5cf6 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradient-shift 5s ease infinite;
        }

        .dark .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #22d3ee 50%, #a78bfa 100%);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* ==================== HOVER EFFECTS ==================== */
        .card-lift {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .card-lift:hover {
            transform: translateY(-12px) scale(1.02);
        }

        .hover-glow:hover {
            box-shadow:
                0 20px 60px rgba(59, 130, 246, 0.25),
                0 0 40px rgba(59, 130, 246, 0.15);
        }

        .dark .hover-glow:hover {
            box-shadow:
                0 20px 60px rgba(59, 130, 246, 0.2),
                0 0 40px rgba(59, 130, 246, 0.1);
        }

        .icon-pulse:hover {
            animation: pulse-glow 1s ease-in-out infinite;
        }

        /* ==================== FLOATING ORBS ==================== */
        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            animation: float-slow 12s ease-in-out infinite;
        }

        .floating-orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.5), transparent 70%);
        }

        .floating-orb-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(6, 182, 212, 0.4), transparent 70%);
            animation-delay: 3s;
        }

        .floating-orb-3 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(139, 92, 246, 0.4), transparent 70%);
            animation-delay: 6s;
        }

        .dark .floating-orb {
            opacity: 0.25;
        }

        /* ==================== SPARKLE ==================== */
        .sparkle {
            position: relative;
        }

        .sparkle::after {
            content: '✦';
            position: absolute;
            top: -8px;
            right: -12px;
            font-size: 14px;
            color: #fbbf24;
            animation: bounce-subtle 1.5s ease-in-out infinite;
        }

        /* ==================== UTILITIES ==================== */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Reduced motion */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endpush