@extends('layouts.app')

@section('title', 'Profil Sekolah')
@section('meta_description', 'Profil lengkap SMAN 2 KAUR - Sejarah, fasilitas, dan informasi umum sekolah')

@section('content')
    <section class="relative hero-gradient py-24 lg:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 right-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-float"></div>
            <div
                class="absolute bottom-10 left-10 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl animate-float animate-delay-300">
            </div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <span
                class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-blue-200 text-sm font-medium mb-6 animate-fade-in">
                <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Tentang Kami
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Profil <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Sekolah</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Mengenal lebih dekat SMAN 2 KAUR dan perjalanan kami dalam dunia pendidikan
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors">
        <div class="container-custom">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <span
                        class="inline-block px-4 py-2 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-sm font-semibold mb-4">
                        Sejarah Kami
                    </span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 dark:text-white mb-6">
                        Perjalanan <span class="gradient-text">SMAN 2 KAUR</span>
                    </h2>
                    <div class="space-y-4 text-slate-600 dark:text-slate-400">
                        <p>
                            SMAN 2 KAUR didirikan pada tahun 1990 dengan visi menjadi lembaga pendidikan unggulan yang
                            menghasilkan generasi berkualitas dan berakhlak mulia.
                        </p>
                        <p>
                            Selama lebih dari tiga dekade, kami telah berkontribusi dalam mencetak ribuan alumni yang sukses
                            di berbagai bidang, mulai dari akademisi, profesional, hingga pemimpin masyarakat.
                        </p>
                        <p>
                            Dengan akreditasi A, kami terus berkomitmen untuk memberikan pendidikan terbaik melalui
                            kurikulum yang selalu disesuaikan dengan perkembangan zaman.
                        </p>
                    </div>
                </div>

                <div class="order-1 lg:order-2">
                    <div class="relative">
                        <div
                            class="aspect-square bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl shadow-2xl overflow-hidden">
                            <div class="absolute inset-0 bg-white/10 backdrop-blur-sm flex items-center justify-center">
                                <svg class="w-32 h-32 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                        d="M12 14l9-5-9-5-9 5 9 5zm0 7l-9-5 9-5 9 5-9 5z" />
                                </svg>
                            </div>
                        </div>
                        <div class="absolute -bottom-6 -right-6 glass-card p-6 animate-float">
                            <div class="text-4xl font-bold gradient-text">30+</div>
                            <div class="text-slate-600 dark:text-slate-400 text-sm">Tahun Berdiri</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-slate-50 dark:bg-slate-800 transition-colors">
        <div class="container-custom">
            <div class="section-header">
                <h2 class="section-title">Fasilitas Unggulan</h2>
                <p class="section-subtitle">Sarana dan prasarana modern untuk mendukung kegiatan belajar mengajar</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-card p-6 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">36 Ruang Kelas</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Dilengkapi AC dan proyektor</p>
                </div>

                <div class="glass-card p-6 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Lab Komputer</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">120 unit komputer modern</p>
                </div>

                <div class="glass-card p-6 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Lab IPA</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Fisika, Kimia & Biologi</p>
                </div>

                <div class="glass-card p-6 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Perpustakaan</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">15.000+ koleksi buku</p>
                </div>

                <div class="glass-card p-6 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Lab Bahasa</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Sistem audio modern</p>
                </div>

                <div class="glass-card p-6 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Lapangan Olahraga</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Basket, Voli & Futsal</p>
                </div>

                <div class="glass-card p-6 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">Aula Serbaguna</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Kapasitas 500 orang</p>
                </div>

                <div class="glass-card p-6 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-2">WiFi Kampus</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">High-speed internet</p>
                </div>
            </div>
        </div>
    </section>
@endsection