@extends('layouts.app')

@section('title', 'Struktur Organisasi')
@section('meta_description', 'Struktur Organisasi SMAN 2 KAUR')

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
                Organisasi
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Struktur <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Organisasi</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Struktur organisasi dan kepemimpinan SMAN 2 KAUR
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors">
        <div class="container-custom">
            <div class="max-w-5xl mx-auto">
                <div class="glass-card p-8 md:p-12 text-center mb-12">
                    <div
                        class="w-32 h-32 mx-auto bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl flex items-center justify-center mb-6 shadow-xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Kepala Sekolah</h2>
                    <p class="text-lg text-blue-600 dark:text-blue-400 font-semibold mb-4">Dr. H. Ahmad Suryadi, M.Pd.</p>
                    <p class="text-slate-600 dark:text-slate-400">NIP: 196512101990031002</p>
                </div>

                <div class="grid md:grid-cols-2 gap-8 mb-12">
                    <div class="glass-card p-8 text-center">
                        <div
                            class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Wakasek Kurikulum</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-semibold mb-2">Drs. Budi Santoso, M.Pd.</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Bidang Akademik & Pembelajaran</p>
                    </div>

                    <div class="glass-card p-8 text-center">
                        <div
                            class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Wakasek Kesiswaan</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-semibold mb-2">Siti Rahmawati, S.Pd., M.M.</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Bidang Kesiswaan & Ekstrakurikuler</p>
                    </div>

                    <div class="glass-card p-8 text-center">
                        <div
                            class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Wakasek Sarana Prasarana</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-semibold mb-2">Ir. Herman Wijaya, M.T.</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Bidang Sarana & Prasarana</p>
                    </div>

                    <div class="glass-card p-8 text-center">
                        <div
                            class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Wakasek Humas</h3>
                        <p class="text-blue-600 dark:text-blue-400 font-semibold mb-2">Dra. Endang Susilowati</p>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Bidang Hubungan Masyarakat</p>
                    </div>
                </div>

                <div class="glass-card p-8 md:p-10">
                    <h3 class="text-2xl font-bold gradient-text text-center mb-8">Koordinator Bidang</h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="text-center p-4">
                            <div
                                class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Kepala Perpustakaan</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Dewi Lestari, S.Sos.</p>
                        </div>

                        <div class="text-center p-4">
                            <div
                                class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Kepala Lab Komputer</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Andi Prasetyo, S.Kom.</p>
                        </div>

                        <div class="text-center p-4">
                            <div
                                class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Kepala Lab IPA</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Dr. Rina Susanti, M.Si.</p>
                        </div>

                        <div class="text-center p-4">
                            <div
                                class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Kepala Tata Usaha</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Hendra Gunawan, S.E.</p>
                        </div>

                        <div class="text-center p-4">
                            <div
                                class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Koordinator BK</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Yuni Astuti, S.Psi.</p>
                        </div>

                        <div class="text-center p-4">
                            <div
                                class="w-16 h-16 mx-auto bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h4 class="font-bold text-slate-900 dark:text-white">Koordinator Keamanan</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Bagus Purnomo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection