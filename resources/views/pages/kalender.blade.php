@extends('layouts.app')

@section('title', 'Kalender Akademik')
@section('meta_description', 'Kalender akademik dan jadwal kegiatan SMAN 2 KAUR')

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
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Tahun Ajaran {{ $currentYear }}
            </span>
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 sm:mb-6">
                Kalender <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Akademik</span>
            </h1>
            <p class="text-sm sm:text-lg text-blue-100/80 max-w-2xl mx-auto px-2">
                Jadwal kegiatan sepanjang tahun ajaran
            </p>
        </div>
    </section>

    <section class="py-12 sm:py-16 lg:py-20 bg-white dark:bg-slate-900 transition-colors">
        <div class="container-custom px-4">
            <div class="grid lg:grid-cols-3 gap-6 sm:gap-8">
                <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                    @php
                        $colors = [
                            'primary' => 'blue',
                            'warning' => 'amber',
                            'success' => 'green',
                            'info' => 'cyan',
                            'danger' => 'red'
                        ];
                    @endphp

                    <!-- Semester Ganjil -->
                    <div class="glass-card p-4 sm:p-6 md:p-8">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0 mb-4 sm:mb-6">
                            <h2 class="text-lg sm:text-xl md:text-2xl font-bold gradient-text">Semester Ganjil</h2>
                            <span class="badge badge-primary text-[10px] sm:text-xs">Juli - Desember</span>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            @forelse($semesterGanjil as $item)
                                <div
                                    class="flex items-start gap-3 sm:gap-4 p-3 sm:p-4 rounded-lg sm:rounded-xl bg-slate-50 dark:bg-slate-800/50">
                                    <div
                                        class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-{{ $colors[$item->event_type ?? 'primary'] ?? 'blue' }}-500 flex-shrink-0 mt-1.5">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm sm:text-base font-semibold text-slate-900 dark:text-white">
                                            {{ $item->title }}</div>
                                        <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                                            @if($item->is_all_day)
                                                {{ $item->event_date->format('d M Y') }}
                                            @elseif($item->end_date && $item->end_date->format('Y-m-d') != $item->event_date->format('Y-m-d'))
                                                {{ $item->event_date->format('d M') }} - {{ $item->end_date->format('d M Y') }}
                                            @else
                                                {{ $item->event_date->format('d M Y') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500 italic">Belum ada agenda semester ganjil.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Semester Genap -->
                    <div class="glass-card p-4 sm:p-6 md:p-8">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 sm:gap-0 mb-4 sm:mb-6">
                            <h2 class="text-lg sm:text-xl md:text-2xl font-bold gradient-text">Semester Genap</h2>
                            <span class="badge badge-info text-[10px] sm:text-xs">Januari - Juni</span>
                        </div>

                        <div class="space-y-3 sm:space-y-4">
                            @forelse($semesterGenap as $item)
                                <div
                                    class="flex items-start gap-3 sm:gap-4 p-3 sm:p-4 rounded-lg sm:rounded-xl bg-slate-50 dark:bg-slate-800/50">
                                    <div
                                        class="w-2.5 h-2.5 sm:w-3 sm:h-3 rounded-full bg-{{ $colors[$item->event_type ?? 'primary'] ?? 'blue' }}-500 flex-shrink-0 mt-1.5">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-sm sm:text-base font-semibold text-slate-900 dark:text-white">
                                            {{ $item->title }}</div>
                                        <div class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                                            @if($item->is_all_day)
                                                {{ $item->event_date->format('d M Y') }}
                                            @elseif($item->end_date && $item->end_date->format('Y-m-d') != $item->event_date->format('Y-m-d'))
                                                {{ $item->event_date->format('d M') }} - {{ $item->end_date->format('d M Y') }}
                                            @else
                                                {{ $item->event_date->format('d M Y') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500 italic">Belum ada agenda semester genap.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-4 sm:space-y-6">
                    <!-- Keterangan -->
                    <div class="glass-card p-4 sm:p-6">
                        <h3 class="text-sm sm:text-lg font-bold text-slate-900 dark:text-white mb-3 sm:mb-4">Keterangan</h3>
                        <div class="space-y-2 sm:space-y-3">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-blue-500"></div>
                                <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">Kegiatan Sekolah</span>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-amber-500"></div>
                                <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">Ujian / Penilaian</span>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-green-500"></div>
                                <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">Libur / Hari
                                    Besar</span>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-cyan-500"></div>
                                <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">Hari Nasional</span>
                            </div>
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-3 h-3 sm:w-4 sm:h-4 rounded-full bg-red-500"></div>
                                <span class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">Kemerdekaan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Download -->
                    <div class="glass-card p-4 sm:p-6">
                        <h3 class="text-sm sm:text-lg font-bold text-slate-900 dark:text-white mb-3 sm:mb-4">Unduh Kalender
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mb-3 sm:mb-4">
                            Download kalender akademik format PDF
                        </p>
                        <a href="{{ route('kalender.download') }}"
                            class="btn btn-primary w-full text-sm sm:text-base py-2.5 sm:py-3" target="_blank">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download PDF
                        </a>
                    </div>

                    <!-- Acara Mendatang -->
                    @if($upcomingEvents->count() > 0)
                        <div class="glass-card p-4 sm:p-6">
                            <h3 class="text-sm sm:text-lg font-bold text-slate-900 dark:text-white mb-3 sm:mb-4">Acara Mendatang
                            </h3>
                            <div class="space-y-3 sm:space-y-4">
                                @foreach($upcomingEvents as $upcoming)
                                    <div
                                        class="p-3 sm:p-4 rounded-lg sm:rounded-xl bg-gradient-to-r from-{{ $colors[$upcoming->event_type ?? 'primary'] ?? 'blue' }}-500/10 to-{{ $colors[$upcoming->event_type ?? 'primary'] ?? 'blue' }}-500/5 border border-{{ $colors[$upcoming->event_type ?? 'primary'] ?? 'blue' }}-500/20">
                                        <div
                                            class="text-xs sm:text-sm text-{{ $colors[$upcoming->event_type ?? 'primary'] ?? 'blue' }}-600 dark:text-{{ $colors[$upcoming->event_type ?? 'primary'] ?? 'blue' }}-400 font-medium">
                                            @if($upcoming->is_all_day)
                                                {{ $upcoming->event_date->format('d M') }}
                                            @elseif($upcoming->end_date && $upcoming->end_date->format('Y-m-d') != $upcoming->event_date->format('Y-m-d'))
                                                {{ $upcoming->event_date->format('d M') }} - {{ $upcoming->end_date->format('d M') }}
                                            @else
                                                {{ $upcoming->event_date->format('d M') }}
                                            @endif
                                        </div>
                                        <div class="text-sm sm:text-base font-semibold text-slate-900 dark:text-white">
                                            {{ $upcoming->title }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection