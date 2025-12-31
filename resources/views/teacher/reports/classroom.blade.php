@extends('layouts.teacher')

@section('title', 'Laporan - ' . $classroom->name)

@push('styles')
<style>
    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { height: 8px; width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(16, 185, 129, 0.2); border-radius: 20px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background-color: rgba(16, 185, 129, 0.4); }

    /* Animation */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-enter { animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }

    /* Glass Effect */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    /* Sticky Column Fix for Glass Effect */
    .sticky-col-bg {
        background: rgba(255, 255, 255, 0.95); /* Hampir solid agar tulisan dibawah tidak tembus saat scroll */
    }
    .dark .sticky-col-bg { background: #0f172a; } 
    tr:hover .sticky-col-bg { background: #f0fdf4; } /* Warna saat hover row (Emerald-50) */
    .dark tr:hover .sticky-col-bg { background: #111827; }
</style>
@endpush

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-[#F8FAFC] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-emerald-400/10 rounded-full blur-[100px] dark:bg-emerald-600/10"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-teal-400/10 rounded-full blur-[100px] dark:bg-teal-600/10"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10 space-y-6">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 animate-enter">
            <div>
                <a href="{{ route('teacher.reports.index') }}" class="group inline-flex items-center text-sm font-semibold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors mb-2">
                    <div class="p-1 rounded-full group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/30 mr-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </div>
                    Kembali ke Daftar Laporan
                </a>
                <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                    Rekapitulasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Nilai Siswa</span>
                </h1>
            </div>

            <a href="{{ route('teacher.reports.export', $classroom) }}" 
               class="group relative inline-flex items-center justify-center px-6 py-3 font-bold text-white transition-all duration-200 bg-slate-900 rounded-xl hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100 shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export Excel</span>
            </a>
        </div>

        {{-- Class Info Card --}}
        <div class="glass-panel rounded-2xl p-6 animate-enter delay-100">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 shadow-lg shadow-emerald-500/20 flex items-center justify-center text-white text-2xl font-black">
                    {{ strtoupper(substr($classroom->subject ?? $classroom->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $classroom->name }}</h2>
                    <div class="flex items-center gap-3 mt-1 text-sm font-medium text-slate-500 dark:text-slate-400">
                        <span class="bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide">
                            {{ $classroom->subject ?? 'General' }}
                        </span>
                        <span>&bull;</span>
                        <span>{{ $students->count() }} Siswa</span>
                        <span>&bull;</span>
                        <span>{{ $assignments->count() }} Tugas</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Table Section --}}
        <div class="glass-panel rounded-2xl overflow-hidden animate-enter delay-200 flex flex-col">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider border-b border-slate-200 dark:border-slate-700">
                            {{-- Sticky Header Columns --}}
                            <th class="sticky left-0 z-20 sticky-col-bg px-6 py-4 w-16">No</th>
                            <th class="sticky left-16 z-20 sticky-col-bg px-6 py-4 min-w-[250px] shadow-[4px_0_24px_-2px_rgba(0,0,0,0.05)]">Nama Siswa</th>
                            
                            {{-- Assignment Headers --}}
                            @foreach($assignments as $assignment)
                                <th class="px-4 py-4 min-w-[140px] text-center bg-slate-50/50 dark:bg-slate-800/50">
                                    <div class="flex flex-col items-center group cursor-help">
                                        <span class="line-clamp-1 group-hover:text-emerald-600 transition-colors">{{ $assignment->title }}</span>
                                        <span class="text-[10px] text-slate-400 font-normal mt-0.5">Max: {{ $assignment->max_score }}</span>
                                    </div>
                                </th>
                            @endforeach

                            {{-- Exam Headers --}}
                            @foreach($exams as $exam)
                                <th class="px-4 py-4 min-w-[140px] text-center bg-indigo-50/50 dark:bg-indigo-900/20">
                                    <div class="flex flex-col items-center group cursor-help">
                                        <span class="line-clamp-1 group-hover:text-indigo-600 transition-colors">{{ $exam->title }}</span>
                                        <span class="text-[10px] text-slate-400 font-normal mt-0.5">Ujian</span>
                                    </div>
                                </th>
                            @endforeach
                            
                            {{-- Average Header --}}
                            <th class="px-6 py-4 text-center min-w-[100px] bg-emerald-50/80 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400">Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($grades as $studentId => $data)
                            <tr class="group transition-colors hover:bg-emerald-50/30 dark:hover:bg-slate-800/50">
                                {{-- Sticky Body Columns --}}
                                <td class="sticky left-0 z-10 sticky-col-bg px-6 py-4 text-sm font-medium text-slate-500 dark:text-slate-400 transition-colors group-hover:text-slate-700 dark:group-hover:text-slate-200">
                                    {{ $loop->iteration }}
                                </td>
                                <td class="sticky left-16 z-10 sticky-col-bg px-6 py-4 text-sm font-bold text-slate-800 dark:text-white shadow-[4px_0_24px_-2px_rgba(0,0,0,0.05)]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-600 dark:text-slate-300">
                                            {{ substr($data['student']->name, 0, 1) }}
                                        </div>
                                        {{ $data['student']->name }}
                                    </div>
                                </td>

                                {{-- Assignment Scores --}}
                                @foreach($assignments as $assignment)
                                    <td class="px-4 py-4 text-center">
                                        @php 
                                            $submission = $data['assignments'][$assignment->id] ?? null;
                                            $score = $submission ? $submission->score : null;
                                            $max = $assignment->max_score;
                                            // Logic Warna
                                            if($score === null) {
                                                $badgeClass = "bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500";
                                                $display = "-";
                                            } elseif ($score >= ($max * 0.7)) {
                                                $badgeClass = "bg-emerald-100 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20";
                                                $display = $score;
                                            } elseif ($score >= ($max * 0.5)) {
                                                $badgeClass = "bg-amber-100 text-amber-700 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20";
                                                $display = $score;
                                            } else {
                                                $badgeClass = "bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20";
                                                $display = $score;
                                            }
                                            
                                            if($submission && $submission->status !== 'graded') {
                                                 $badgeClass = "bg-blue-100 text-blue-700 border border-blue-200 dark:bg-blue-500/10 dark:text-blue-400";
                                                 $display = "Wait";
                                            }
                                        @endphp

                                        <span class="inline-flex items-center justify-center min-w-[3rem] px-2 py-1 rounded-lg text-sm font-bold {{ $badgeClass }}">
                                            {{ $display }}
                                        </span>
                                    </td>
                                @endforeach

                                {{-- Exam Scores --}}
                                @foreach($exams as $exam)
                                    <td class="px-4 py-4 text-center">
                                        @php
                                            $attempt = $data['exams'][$exam->id] ?? null;
                                            $score = ($attempt && $attempt->score !== null) ? $attempt->score : null;
                                            
                                            // Logic Warna
                                            if($score === null) {
                                                $badgeClass = "bg-slate-100 text-slate-400 dark:bg-slate-800 dark:text-slate-500";
                                                $display = "-";
                                            } elseif ($score >= 75) { 
                                                // Assuming 75 is KKM
                                                $badgeClass = "bg-emerald-100 text-emerald-700 border border-emerald-200 dark:bg-emerald-500/10 dark:text-emerald-400 dark:border-emerald-500/20";
                                                $display = $score;
                                            } elseif ($score >= 50) {
                                                $badgeClass = "bg-amber-100 text-amber-700 border border-amber-200 dark:bg-amber-500/10 dark:text-amber-400 dark:border-amber-500/20";
                                                $display = $score;
                                            } else {
                                                $badgeClass = "bg-rose-100 text-rose-700 border border-rose-200 dark:bg-rose-500/10 dark:text-rose-400 dark:border-rose-500/20";
                                                $display = $score;
                                            }
                                        @endphp

                                        <span class="inline-flex items-center justify-center min-w-[3rem] px-2 py-1 rounded-lg text-sm font-bold {{ $badgeClass }}">
                                            {{ $display }}
                                        </span>
                                    </td>
                                @endforeach

                                {{-- Average Column --}}
                                <td class="px-6 py-4 text-center bg-emerald-50/30 dark:bg-emerald-900/10">
                                    @if($data['average'] !== null)
                                        <span class="text-sm font-black {{ $data['average'] >= 70 ? 'text-emerald-600 dark:text-emerald-400' : ($data['average'] >= 50 ? 'text-amber-500' : 'text-rose-500') }}">
                                            {{ number_format($data['average'], 1) }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                                <td colspan="{{ 3 + $assignments->count() + $exams->count() }}" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                                        <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                        <p class="font-medium">Belum ada data siswa di kelas ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Legend Footer --}}
            <div class="px-6 py-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-700 flex flex-wrap gap-6 items-center justify-center md:justify-start">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Keterangan:</span>
                
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 ring-2 ring-emerald-100 dark:ring-emerald-900"></span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-300">≥ 70 (Kompeten)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500 ring-2 ring-amber-100 dark:ring-amber-900"></span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-300">50-69 (Cukup)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-rose-500 ring-2 ring-rose-100 dark:ring-rose-900"></span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-300">< 50 (Perlu Remedial)</span>
                </div>
                 <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500 ring-2 ring-blue-100 dark:ring-blue-900"></span>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-300">Wait (Menunggu Dinilai)</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection