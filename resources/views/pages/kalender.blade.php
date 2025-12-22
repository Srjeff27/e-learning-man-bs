@extends('layouts.app')

@section('title', 'Kalender Akademik')
@section('meta_description', 'Kalender akademik dan jadwal kegiatan SMAN 2 KAUR')

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
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Tahun Ajaran 2025/2026
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Kalender <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Akademik</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Jadwal kegiatan dan acara penting sepanjang tahun ajaran
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors">
        <div class="container-custom">
            <div class="grid lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="glass-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold gradient-text">Semester Ganjil</h2>
                            <span class="badge badge-primary">Juli - Desember</span>
                        </div>

                        <div class="space-y-4">
                            @php
                                $semester1 = [
                                    ['date' => '14 Juli 2025', 'event' => 'Awal Tahun Ajaran Baru', 'type' => 'primary'],
                                    ['date' => '17 Agustus 2025', 'event' => 'Upacara HUT RI ke-80', 'type' => 'danger'],
                                    ['date' => '1-7 September 2025', 'event' => 'Penilaian Tengah Semester', 'type' => 'warning'],
                                    ['date' => '28 Oktober 2025', 'event' => 'Hari Sumpah Pemuda', 'type' => 'info'],
                                    ['date' => '10 November 2025', 'event' => 'Hari Pahlawan', 'type' => 'info'],
                                    ['date' => '1-14 Desember 2025', 'event' => 'Penilaian Akhir Semester', 'type' => 'warning'],
                                    ['date' => '20 Desember 2025', 'event' => 'Pembagian Rapor', 'type' => 'success'],
                                    ['date' => '21 Des - 4 Jan', 'event' => 'Libur Semester', 'type' => 'success'],
                                ];
                            @endphp

                            @foreach($semester1 as $item)
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors">
                                    <div
                                        class="w-3 h-3 rounded-full bg-{{ $item['type'] == 'primary' ? 'blue' : ($item['type'] == 'success' ? 'green' : ($item['type'] == 'warning' ? 'amber' : ($item['type'] == 'danger' ? 'red' : 'cyan'))) }}-500 flex-shrink-0">
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-slate-900 dark:text-white">{{ $item['event'] }}</div>
                                        <div class="text-sm text-slate-600 dark:text-slate-400">{{ $item['date'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="glass-card p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-2xl font-bold gradient-text">Semester Genap</h2>
                            <span class="badge badge-info">Januari - Juni</span>
                        </div>

                        <div class="space-y-4">
                            @php
                                $semester2 = [
                                    ['date' => '5 Januari 2026', 'event' => 'Masuk Sekolah', 'type' => 'primary'],
                                    ['date' => '1 Februari 2026', 'event' => 'Hari Pendidikan Nasional', 'type' => 'info'],
                                    ['date' => '9-15 Maret 2026', 'event' => 'Penilaian Tengah Semester', 'type' => 'warning'],
                                    ['date' => '23 Maret - 5 April', 'event' => 'Libur Ramadhan & Idul Fitri', 'type' => 'success'],
                                    ['date' => '2 Mei 2026', 'event' => 'Hari Pendidikan Nasional', 'type' => 'info'],
                                    ['date' => '20 Mei 2026', 'event' => 'Hari Kebangkitan Nasional', 'type' => 'info'],
                                    ['date' => '1-14 Juni 2026', 'event' => 'Penilaian Akhir Tahun', 'type' => 'warning'],
                                    ['date' => '20 Juni 2026', 'event' => 'Pembagian Rapor', 'type' => 'success'],
                                    ['date' => '21 Juni - 13 Juli', 'event' => 'Libur Semester', 'type' => 'success'],
                                ];
                            @endphp

                            @foreach($semester2 as $item)
                                <div
                                    class="flex items-center gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors">
                                    <div
                                        class="w-3 h-3 rounded-full bg-{{ $item['type'] == 'primary' ? 'blue' : ($item['type'] == 'success' ? 'green' : ($item['type'] == 'warning' ? 'amber' : ($item['type'] == 'danger' ? 'red' : 'cyan'))) }}-500 flex-shrink-0">
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-semibold text-slate-900 dark:text-white">{{ $item['event'] }}</div>
                                        <div class="text-sm text-slate-600 dark:text-slate-400">{{ $item['date'] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Keterangan</h3>
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                                <span class="text-slate-600 dark:text-slate-400">Kegiatan Sekolah</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded-full bg-amber-500"></div>
                                <span class="text-slate-600 dark:text-slate-400">Ujian / Penilaian</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded-full bg-green-500"></div>
                                <span class="text-slate-600 dark:text-slate-400">Libur / Hari Besar</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded-full bg-cyan-500"></div>
                                <span class="text-slate-600 dark:text-slate-400">Hari Nasional</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-4 h-4 rounded-full bg-red-500"></div>
                                <span class="text-slate-600 dark:text-slate-400">Hari Kemerdekaan</span>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Unduh Kalender</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                            Download kalender akademik lengkap dalam format PDF
                        </p>
                        <a href="#" class="btn btn-primary w-full">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download PDF
                        </a>
                    </div>

                    <div class="glass-card p-6">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Acara Mendatang</h3>
                        <div class="space-y-4">
                            <div
                                class="p-4 rounded-xl bg-gradient-to-r from-blue-500/10 to-cyan-500/10 border border-blue-500/20">
                                <div class="text-sm text-blue-600 dark:text-blue-400 font-medium">21-28 Desember</div>
                                <div class="font-semibold text-slate-900 dark:text-white">Ujian Akhir Semester</div>
                            </div>
                            <div
                                class="p-4 rounded-xl bg-gradient-to-r from-green-500/10 to-emerald-500/10 border border-green-500/20">
                                <div class="text-sm text-green-600 dark:text-green-400 font-medium">25 Desember</div>
                                <div class="font-semibold text-slate-900 dark:text-white">Libur Natal</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection