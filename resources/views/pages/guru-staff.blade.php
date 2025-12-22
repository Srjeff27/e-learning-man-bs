@extends('layouts.app')

@section('title', 'Guru & Staff')
@section('meta_description', 'Daftar Guru dan Staff SMAN 2 KAUR')

@section('content')
    <section class="relative hero-gradient py-24 lg:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 left-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-float"></div>
            <div
                class="absolute bottom-10 right-10 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl animate-float animate-delay-300">
            </div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <span
                class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-blue-200 text-sm font-medium mb-6 animate-fade-in">
                <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Tim Kami
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Guru & <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Staff</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Para pendidik profesional yang berdedikasi untuk kesuksesan siswa
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors" x-data="{ activeFilter: 'Semua' }">
        <div class="container-custom">
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button @click="activeFilter = 'Semua'"
                    :class="activeFilter === 'Semua' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                    Semua
                </button>
                <button @click="activeFilter = 'Matematika'"
                    :class="activeFilter === 'Matematika' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Matematika
                </button>
                <button @click="activeFilter = 'IPA'"
                    :class="activeFilter === 'IPA' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    IPA
                </button>
                <button @click="activeFilter = 'Bahasa'"
                    :class="activeFilter === 'Bahasa' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Bahasa
                </button>
                <button @click="activeFilter = 'IPS'"
                    :class="activeFilter === 'IPS' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    IPS
                </button>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @php
                    $teachers = [
                        ['name' => 'Dr. H. Ahmad Suryadi, M.Pd.', 'role' => 'Kepala Sekolah', 'subject' => 'Administrasi'],
                        ['name' => 'Drs. Budi Santoso, M.Pd.', 'role' => 'Guru Matematika', 'subject' => 'Matematika'],
                        ['name' => 'Siti Rahmawati, S.Pd., M.M.', 'role' => 'Guru Bahasa Indonesia', 'subject' => 'Bahasa'],
                        ['name' => 'Ir. Herman Wijaya, M.T.', 'role' => 'Guru Fisika', 'subject' => 'IPA'],
                        ['name' => 'Dr. Rina Susanti, M.Si.', 'role' => 'Guru Biologi', 'subject' => 'IPA'],
                        ['name' => 'Andi Prasetyo, S.Kom.', 'role' => 'Guru TIK', 'subject' => 'Teknologi'],
                        ['name' => 'Dewi Lestari, S.Pd.', 'role' => 'Guru Bahasa Inggris', 'subject' => 'Bahasa'],
                        ['name' => 'Yuni Astuti, S.Psi.', 'role' => 'Konselor BK', 'subject' => 'BK'],
                    ];
                @endphp

                @foreach($teachers as $index => $teacher)
                    <div class="glass-card p-6 text-center group" style="animation-delay: {{ $index * 0.1 }}s"
                        x-show="activeFilter === 'Semua' || activeFilter === '{{ $teacher['subject'] }}'"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                        <div class="relative mb-6">
                            <div
                                class="w-28 h-28 mx-auto bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                                <svg class="w-14 h-14 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span
                                class="absolute -bottom-2 left-1/2 -translate-x-1/2 px-3 py-1 rounded-full text-xs font-semibold badge-{{ $index % 2 == 0 ? 'primary' : 'info' }}">
                                {{ $teacher['subject'] }}
                            </span>
                        </div>
                        <h3
                            class="font-bold text-slate-900 dark:text-white mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                            {{ $teacher['name'] }}
                        </h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400">{{ $teacher['role'] }}</p>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="#" class="btn btn-secondary px-8 py-4">
                    Lihat Semua Guru
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <section class="section bg-slate-50 dark:bg-slate-800 transition-colors">
        <div class="container-custom">
            <div class="section-header">
                <h2 class="section-title">Tim Pendukung</h2>
                <p class="section-subtitle">Staff administrasi yang mendukung operasional sekolah</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-card p-6 text-center">
                    <div
                        class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-1">Hendra Gunawan, S.E.</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Kepala Tata Usaha</p>
                </div>

                <div class="glass-card p-6 text-center">
                    <div
                        class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-1">Maria Susanti</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Bendahara</p>
                </div>

                <div class="glass-card p-6 text-center">
                    <div
                        class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-1">Bagus Purnomo</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Keamanan</p>
                </div>

                <div class="glass-card p-6 text-center">
                    <div
                        class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white mb-1">Agus Setiawan</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Petugas Kebersihan</p>
                </div>
            </div>
        </div>
    </section>
@endsection