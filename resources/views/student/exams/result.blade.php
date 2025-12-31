@extends('layouts.student')

@section('title', 'Hasil Ujian')

@section('content')
    <div class="max-w-2xl mx-auto text-center space-y-8 pt-10">
        <div
            class="w-24 h-24 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                <polyline points="22 4 12 14.01 9 11.01" />
            </svg>
        </div>

        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white mb-2">Ujian Selesai!</h2>
            <p class="text-slate-500 dark:text-slate-400">Terima kasih telah mengerjakan ujian.</p>
        </div>

        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl border border-slate-200 dark:border-slate-700 p-8 shadow-2xl transform hover:scale-105 transition-transform duration-500">
            <p class="text-sm font-semibold uppercase tracking-widest text-slate-500 mb-2">Nilai Akhir Anda</p>
            <div
                class="text-6xl font-black bg-gradient-to-r from-emerald-500 to-green-600 bg-clip-text text-transparent mb-4">
                {{ $attempt->score }}
            </div>

            @php
                $correct = $attempt->answers->where('is_correct', true)->count();
                $total = $exam->questions->count();
                $wrong = $total - $correct;
            @endphp

            <div class="flex justify-center gap-4 mb-4">
                <div
                    class="px-4 py-2 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800">
                    <span class="block text-xs uppercase text-emerald-600 font-bold">Benar</span>
                    <span class="text-xl font-bold text-emerald-500">{{ $correct }}</span>
                </div>
                <div class="px-4 py-2 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-800">
                    <span class="block text-xs uppercase text-red-600 font-bold">Salah</span>
                    <span class="text-xl font-bold text-red-500">{{ $wrong }}</span>
                </div>
            </div>
            <div class="mt-6 flex justify-center gap-8 text-sm">
                <div>
                    <span class="block text-slate-400">Mulai</span>
                    <span
                        class="font-bold text-slate-700 dark:text-slate-300">{{ $attempt->started_at->format('H:i') }}</span>
                </div>
                <div>
                    <span class="block text-slate-400">Selesai</span>
                    <span
                        class="font-bold text-slate-700 dark:text-slate-300">{{ $attempt->submitted_at->format('H:i') }}</span>
                </div>
            </div>
        </div>

        <div>
            <a href="{{ route('student.exams.index') }}"
                class="px-8 py-3 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl font-bold hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                Kembali ke Daftar Ujian
            </a>
        </div>
    </div>
@endsection