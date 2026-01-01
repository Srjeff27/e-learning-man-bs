@extends('layouts.student')

@section('title', 'Hasil Ujian')

@section('content')
    <div class="max-w-2xl mx-auto space-y-8 animate-fade-in-up py-8">
        <div
            class="relative bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-2xl overflow-hidden p-6 md:p-8 text-center ring-4 md:ring-8 ring-slate-50 dark:ring-slate-900">
            <!-- Decorative Confetti bg -->
            <div
                class="absolute inset-0 bg-[radial-gradient(#10b981_1px,transparent_1px)] [background-size:16px_16px] opacity-[0.05]">
            </div>

            <!-- Medal/Icon -->
            <div
                class="relative z-10 mx-auto w-20 h-20 md:w-24 md:h-24 bg-gradient-to-br from-emerald-400 to-teal-600 rounded-full flex items-center justify-center shadow-lg shadow-emerald-500/30 mb-5 md:mb-6 animate-bounce-slow">
                @if($score >= 75)
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-white md:w-12 md:h-12">
                        <circle cx="12" cy="8" r="7" />
                        <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88" />
                    </svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-white md:w-12 md:h-12">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
                        <line x1="9" y1="9" x2="9.01" y2="9" />
                        <line x1="15" y1="9" x2="15.01" y2="9" />
                    </svg>
                @endif
            </div>

            <h2 class="relative z-10 text-2xl md:text-3xl font-black text-slate-800 dark:text-white mb-2 tracking-tight">
                {{ $score >= 75 ? 'Selamat! Hasil Memuaskan' : 'Ujian Selesai' }}
            </h2>
            <p class="relative z-10 text-slate-500 dark:text-slate-400 mb-6 md:mb-8 text-sm md:text-base">
                Anda telah menyelesaikan ujian <strong>{{ $exam->title }}</strong>.
            </p>

            <!-- Score Card -->
            <div
                class="relative z-10 bg-slate-50 dark:bg-slate-700/50 rounded-2xl p-5 md:p-6 border border-slate-200 dark:border-slate-600 mb-6 md:mb-8">
                <p class="text-xs md:text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Nilai Akhir Anda</p>
                <div
                    class="text-5xl md:text-6xl font-black {{ $score >= 75 ? 'text-emerald-500' : 'text-slate-700 dark:text-white' }} tracking-tighter">
                    {{ $score }}
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="relative z-10 grid grid-cols-3 gap-3 md:gap-4 mb-6 md:mb-8">
                <div
                    class="p-3 md:p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl md:rounded-2xl border border-emerald-100 dark:border-emerald-900/50">
                    <p class="text-[10px] md:text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase">Benar</p>
                    <p class="text-xl md:text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $correct }}</p>
                </div>
                <div class="p-3 md:p-4 bg-red-50 dark:bg-red-900/20 rounded-xl md:rounded-2xl border border-red-100 dark:border-red-900/50">
                    <p class="text-[10px] md:text-xs font-bold text-red-600 dark:text-red-400 uppercase">Salah</p>
                    <p class="text-xl md:text-2xl font-black text-red-600 dark:text-red-400">{{ $wrong }}</p>
                </div>
                <div class="p-3 md:p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl md:rounded-2xl border border-slate-200 dark:border-slate-600">
                    <p class="text-[10px] md:text-xs font-bold text-slate-500 uppercase">Pelanggaran</p>
                    <p class="text-xl md:text-2xl font-black text-slate-700 dark:text-white">{{ $attempt->violation_count }}</p>
                </div>
            </div>

            <a href="{{ route('student.exams.index') }}"
                class="relative z-10 inline-flex items-center gap-2 px-8 py-3 bg-slate-800 dark:bg-white text-white dark:text-slate-800 rounded-xl font-bold hover:scale-105 active:scale-95 transition-all shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Kembali ke Daftar Ujian
            </a>
        </div>
    </div>
@endsection