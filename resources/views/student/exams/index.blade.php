@extends('layouts.student')

@section('title', 'Daftar Ujian')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Daftar Ujian</h2>
            <p class="text-slate-500 dark:text-slate-400">Kerjakan ujian yang tersedia untuk kelas Anda.</p>
        </div>

        @if(session('info'))
            <div class="p-4 bg-blue-100 text-blue-700 rounded-xl border border-blue-200">
                {{ session('info') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-100 text-red-700 rounded-xl border border-red-200">
                {{ session('error') }}
            </div>
        @endif

        {{-- ACTIVE EXAMS --}}
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mt-8 mb-4 border-l-4 border-emerald-500 pl-3">Sedang
            Berlangsung</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            @forelse($activeExams as $exam)
                <div
                    class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-lg hover:shadow-xl transition-all duration-300 group relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4">
                        <span class="animate-pulse w-3 h-3 bg-emerald-500 rounded-full inline-block"></span>
                    </div>

                    <div class="flex justify-between items-start mb-4">
                        <div
                            class="p-3 bg-emerald-100 dark:bg-emerald-500/10 rounded-xl text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                            </svg>
                        </div>
                        <span
                            class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg text-xs font-bold mr-6">
                            {{ $exam->duration_minutes }} Menit
                        </span>
                    </div>

                    <h3
                        class="text-lg font-bold text-slate-800 dark:text-white mb-1 group-hover:text-emerald-600 transition-colors">
                        {{ $exam->title }}
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">{{ $exam->classroom->name }}</p>

                    @if($exam->description)
                        <p class="text-sm text-slate-600 dark:text-slate-300 mb-6 bg-slate-50 dark:bg-slate-900/50 p-3 rounded-lg">
                            {{ Str::limit($exam->description, 80) }}
                        </p>
                    @endif

                    @php
                        $attempt = $exam->attempts->first();
                        $isResume = $attempt && !$attempt->submitted_at;
                    @endphp

                    <a href="{{ route('student.exams.take', $exam) }}"
                        class="block w-full py-3 text-center bg-gradient-to-r {{ $isResume ? 'from-amber-500 to-orange-600' : 'from-emerald-500 to-green-600' }} text-white rounded-xl shadow-lg hover:shadow-xl transition-all font-bold">
                        {{ $isResume ? 'Lanjutkan Ujian' : 'Kerjakan Sekarang' }}
                    </a>
                </div>
            @empty
                <div
                    class="col-span-full text-center py-12 bg-slate-50 dark:bg-slate-800/50 rounded-3xl border border-dashed border-slate-300 dark:border-slate-700">
                    <p class="text-slate-500 dark:text-slate-400 font-medium">Tidak ada ujian aktif saat ini.</p>
                </div>
            @endforelse
        </div>

        {{-- HISTORY EXAMS --}}
        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-4 border-l-4 border-slate-500 pl-3">Riwayat Ujian
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($historyExams as $exam)
                @php $attempt = $exam->attempts->first(); @endphp
                <div
                    class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm grayscale hover:grayscale-0 transition-all duration-500 opacity-80 hover:opacity-100">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-slate-100 dark:bg-slate-700 rounded-xl text-slate-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </div>
                        <div class="text-right">
                            <span class="block text-xs text-slate-400 uppercase">Nilai Anda</span>
                            <span
                                class="text-2xl font-black {{ $attempt->score >= 75 ? 'text-emerald-500' : 'text-slate-700 dark:text-slate-300' }}">
                                {{ $attempt->score }}
                            </span>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-slate-700 dark:text-slate-300 mb-1">{{ $exam->title }}</h3>
                    <p class="text-xs text-slate-400 mb-4">Diselesaikan: {{ $attempt->submitted_at->format('d M Y, H:i') }}</p>

                    <a href="{{ route('student.exams.result', $exam) }}"
                        class="block w-full py-2 text-center bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors font-semibold text-sm">
                        Lihat Detail Hasil
                    </a>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-slate-400">
                    Belum ada riwayat ujian.
                </div>
            @endforelse
        </div>
    </div>
@endsection