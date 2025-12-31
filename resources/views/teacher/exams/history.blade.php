@extends('layouts.teacher')

@section('title', 'Riwayat Ujian')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('teacher.exams.index') }}"
                class="group flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-xl shadow hover:shadow-md transition-all text-slate-500 hover:text-emerald-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
                <span class="font-bold text-sm">Kembali ke Daftar Ujian</span>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Riwayat Ujian: {{ $exam->title }}</h2>
                <div class="flex items-center gap-2">
                    <span class="text-xs px-2 py-1 rounded bg-slate-100 text-slate-600 font-bold">Status: Selesai</span>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <p class="text-slate-500 dark:text-slate-400 text-sm">Total Partisipan</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $attempts->count() }}</p>
            </div>
            <div
                class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <p class="text-slate-500 dark:text-slate-400 text-sm">Selesai Mengerjakan</p>
                <p class="text-3xl font-bold text-emerald-600">{{ $attempts->whereNotNull('submitted_at')->count() }}</p>
            </div>
            <div
                class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
                <p class="text-slate-500 dark:text-slate-400 text-sm">Rata-rata Nilai</p>
                @php
                    $avg = $attempts->whereNotNull('submitted_at')->avg('score');
                @endphp
                <p class="text-3xl font-bold text-indigo-500">{{ round($avg ?? 0, 1) }}</p>
            </div>
        </div>

        <!-- Attempts Table -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Hasil Siswa</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 text-sm uppercase tracking-wider">
                            <th class="p-4 font-semibold">Nama Siswa</th>
                            <th class="p-4 font-semibold">Waktu Selesai</th>
                            <th class="p-4 font-semibold text-center">B / S</th>
                            <th class="p-4 font-semibold">Nilai</th>
                            <th class="p-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700 text-slate-600 dark:text-slate-300">
                        @forelse($attempts as $attempt)
                            @php
                                $correct = $attempt->answers->where('is_correct', true)->count();
                                $total = $exam->questions->count();
                                $wrong = $attempt->answers->count() - $correct; // Or handle unattempted if needed
                            @endphp
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="p-4 font-medium text-slate-800 dark:text-white">{{ $attempt->user->name }}</td>
                                <td class="p-4 text-sm">
                                    @if($attempt->submitted_at)
                                        {{ $attempt->submitted_at->format('d M Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4 text-center">
                                    <span class="text-emerald-500 font-bold">{{ $correct }}</span> /
                                    <span class="text-red-500 font-bold">{{ $wrong }}</span>
                                </td>
                                <td
                                    class="p-4 text-lg font-bold {{ $attempt->score >= 75 ? 'text-emerald-600' : 'text-slate-800' }}">
                                    {{ $attempt->score ?? '-' }}
                                </td>
                                <td class="p-4">
                                    @if($attempt->status === 'terminated')
                                        <span
                                            class="px-2 py-1 bg-red-100 text-red-600 rounded-lg text-xs font-semibold">Dihentikan</span>
                                    @elseif($attempt->submitted_at)
                                        <span
                                            class="px-2 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-xs font-semibold">Selesai</span>
                                    @else
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded-lg text-xs font-semibold">Belum
                                            Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400">Belum ada data riwayat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection