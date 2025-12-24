@extends('layouts.app')

@section('title', 'Guru & Staff')
@section('meta_description', 'Daftar Guru dan Staff ' . ($profile->name ?? 'SMAN 2 KAUR'))

@section('content')
    <section class="relative hero-gradient py-16 sm:py-20 lg:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 left-20 w-40 sm:w-72 h-40 sm:h-72 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-32 sm:w-64 h-32 sm:h-64 bg-cyan-500/20 rounded-full blur-3xl"></div>
        </div>

        <div class="container-custom relative z-10 text-center px-4">
            <span
                class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-blue-200 text-xs sm:text-sm font-medium mb-4 sm:mb-6">
                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 text-cyan-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Tim Kami
            </span>
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 sm:mb-6">
                Guru & <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Staff</span>
            </h1>
            <p class="text-sm sm:text-lg text-blue-100/80 max-w-2xl mx-auto px-2">
                Pendidik profesional untuk kesuksesan siswa
            </p>
        </div>
    </section>

    <section class="py-12 sm:py-16 lg:py-20 bg-white dark:bg-slate-900 transition-colors"
        x-data="{ activeFilter: 'Semua' }">
        <div class="container-custom px-4">
            <!-- Filter buttons -->
            <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-8 sm:mb-12">
                <button @click="activeFilter = 'Semua'"
                    :class="activeFilter === 'Semua' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700'"
                    class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-semibold transition-all">
                    Semua
                </button>
                @php
                    $subjects = $teachers->pluck('subject_specialty')->filter()->unique()->values();
                @endphp
                @foreach($subjects as $subject)
                    <button @click="activeFilter = '{{ $subject }}'"
                        :class="activeFilter === '{{ $subject }}' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700'"
                        class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all">
                        {{ $subject }}
                    </button>
                @endforeach
            </div>

            <!-- Teachers Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-6 md:gap-8">
                @forelse($teachers as $index => $teacher)
                    <div class="glass-card p-4 sm:p-6 text-center group" style="animation-delay: {{ $index * 0.1 }}s"
                        x-show="activeFilter === 'Semua' || activeFilter === '{{ $teacher->subject_specialty }}'"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">
                        <div class="relative mb-4 sm:mb-6">
                            <div
                                class="w-16 h-16 sm:w-24 sm:h-24 md:w-28 md:h-28 mx-auto bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl sm:rounded-2xl md:rounded-3xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform overflow-hidden">
                                @if($teacher->photo || ($teacher->user && $teacher->user->avatar))
                                    <img src="{{ Storage::url($teacher->photo ?? $teacher->user->avatar) }}"
                                        class="w-full h-full object-cover" alt="{{ $teacher->full_name }}">
                                @else
                                    <svg class="w-8 h-8 sm:w-12 sm:h-12 md:w-14 md:h-14 text-white/80" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                @endif
                            </div>
                            @if($teacher->subject_specialty)
                                <span
                                    class="absolute -bottom-1 sm:-bottom-2 left-1/2 -translate-x-1/2 px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                                    {{ $teacher->subject_specialty }}
                                </span>
                            @endif
                        </div>
                        <h3
                            class="text-xs sm:text-sm md:text-base font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                            {{ $teacher->full_name }}
                        </h3>
                        <p class="text-[10px] sm:text-xs md:text-sm text-slate-600 dark:text-slate-400">
                            @if($teacher->nip)
                                NIP: {{ $teacher->nip }}
                            @else
                                Guru {{ $teacher->subject_specialty ?? '' }}
                            @endif
                        </p>
                    </div>
                @empty
                    <!-- Default data if no teachers in database -->
                    @php
                        $defaultTeachers = [
                            ['name' => 'Dr. H. Ahmad Suryadi, M.Pd.', 'role' => 'Kepala Sekolah', 'subject' => 'Admin'],
                            ['name' => 'Drs. Budi Santoso, M.Pd.', 'role' => 'Guru Matematika', 'subject' => 'MTK'],
                            ['name' => 'Siti Rahmawati, S.Pd.', 'role' => 'Guru B.Indo', 'subject' => 'Bahasa'],
                            ['name' => 'Ir. Herman Wijaya, M.T.', 'role' => 'Guru Fisika', 'subject' => 'IPA'],
                        ];
                    @endphp
                    @foreach($defaultTeachers as $index => $teacher)
                        <div class="glass-card p-4 sm:p-6 text-center group" style="animation-delay: {{ $index * 0.1 }}s"
                            x-show="activeFilter === 'Semua' || activeFilter === '{{ $teacher['subject'] }}'"
                            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100">
                            <div class="relative mb-4 sm:mb-6">
                                <div
                                    class="w-16 h-16 sm:w-24 sm:h-24 md:w-28 md:h-28 mx-auto bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl sm:rounded-2xl md:rounded-3xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                                    <svg class="w-8 h-8 sm:w-12 sm:h-12 md:w-14 md:h-14 text-white/80" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span
                                    class="absolute -bottom-1 sm:-bottom-2 left-1/2 -translate-x-1/2 px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300">
                                    {{ $teacher['subject'] }}
                                </span>
                            </div>
                            <h3
                                class="text-xs sm:text-sm md:text-base font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                {{ $teacher['name'] }}
                            </h3>
                            <p class="text-[10px] sm:text-xs md:text-sm text-slate-600 dark:text-slate-400">{{ $teacher['role'] }}
                            </p>
                        </div>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <!-- Staff Section using organization_structure -->
    @php
        $orgStructure = $profile->organization_structure ?? [];
        $staffMembers = array_slice($orgStructure, 5); // Get coordinators/staff
    @endphp

    @if(count($staffMembers) > 0)
        <section class="py-12 sm:py-16 lg:py-20 bg-slate-50 dark:bg-slate-800 transition-colors">
            <div class="container-custom px-4">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white mb-2 sm:mb-3">Tim
                        Pendukung</h2>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400">Staff pendukung operasional
                        sekolah</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                    @foreach($staffMembers as $staff)
                        @if(!empty($staff['name']))
                            <div class="glass-card p-4 sm:p-6 text-center">
                                <div
                                    class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl sm:rounded-2xl flex items-center justify-center mb-3 sm:mb-4 overflow-hidden">
                                    @if(isset($staff['photo']) && $staff['photo'])
                                        <img src="{{ Storage::url($staff['photo']) }}" class="w-full h-full object-cover"
                                            alt="{{ $staff['name'] }}">
                                    @else
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    @endif
                                </div>
                                <h3 class="text-xs sm:text-sm md:text-base font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1">
                                    {{ $staff['name'] }}</h3>
                                <p class="text-[10px] sm:text-xs md:text-sm text-slate-600 dark:text-slate-400">
                                    {{ $staff['position'] ?? '' }}</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
    @else
        <section class="py-12 sm:py-16 lg:py-20 bg-slate-50 dark:bg-slate-800 transition-colors">
            <div class="container-custom px-4">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white mb-2 sm:mb-3">Tim
                        Pendukung</h2>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400">Staff pendukung operasional
                    </p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
                    <div class="glass-card p-4 sm:p-6 text-center">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl sm:rounded-2xl flex items-center justify-center mb-3 sm:mb-4">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm md:text-base font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1">
                            Hendra Gunawan, S.E.</h3>
                        <p class="text-[10px] sm:text-xs md:text-sm text-slate-600 dark:text-slate-400">Kepala TU</p>
                    </div>

                    <div class="glass-card p-4 sm:p-6 text-center">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl sm:rounded-2xl flex items-center justify-center mb-3 sm:mb-4">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm md:text-base font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1">
                            Maria Susanti</h3>
                        <p class="text-[10px] sm:text-xs md:text-sm text-slate-600 dark:text-slate-400">Bendahara</p>
                    </div>

                    <div class="glass-card p-4 sm:p-6 text-center">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl sm:rounded-2xl flex items-center justify-center mb-3 sm:mb-4">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm md:text-base font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1">
                            Bagus Purnomo</h3>
                        <p class="text-[10px] sm:text-xs md:text-sm text-slate-600 dark:text-slate-400">Keamanan</p>
                    </div>

                    <div class="glass-card p-4 sm:p-6 text-center">
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-xl sm:rounded-2xl flex items-center justify-center mb-3 sm:mb-4">
                            <svg class="w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xs sm:text-sm md:text-base font-bold text-slate-900 dark:text-white mb-0.5 sm:mb-1">Agus
                            Setiawan</h3>
                        <p class="text-[10px] sm:text-xs md:text-sm text-slate-600 dark:text-slate-400">Kebersihan</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection