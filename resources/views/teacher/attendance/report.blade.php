@extends('layouts.teacher')

@section('title', 'Rekap Absensi - ' . $classroom->name)

@push('styles')
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<style>
    /* Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shine { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }

    .animate-enter { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }

    /* Glass Panels */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.05);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }

    /* Table Specifics for Glass Effect */
    /* Sticky column needs solid background to prevent see-through when scrolling */
    .sticky-col { background: rgba(255, 255, 255, 0.95); }
    .dark .sticky-col { background: #0f172a; }
    tr:hover .sticky-col { background: #f0fdf4; }
    .dark tr:hover .sticky-col { background: #111827; }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar { height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background-color: rgba(16, 185, 129, 0.3); border-radius: 20px; }
</style>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_8s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_10s_ease-in-out_infinite_reverse]"></div>
    </div>

    <div class="max-w-7xl mx-auto relative z-10 space-y-8">
        
        {{-- Header Navigation --}}
        <div class="animate-enter">
            <a href="{{ route('teacher.attendance.index', $classroom) }}" 
               class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors mb-6 group">
                <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center mr-2 shadow-sm group-hover:shadow-md transition-all group-hover:-translate-x-1 text-emerald-500 border border-slate-100 dark:border-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Daftar Pertemuan
            </a>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 dark:text-white">
                        Rekap <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Absensi</span>
                    </h1>
                    <div class="flex items-center gap-3 mt-2 text-slate-500 dark:text-slate-400 font-medium">
                        <span class="px-2.5 py-0.5 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider">
                            {{ $classroom->name }}
                        </span>
                        <span>•</span>
                        <span>{{ $sessions->count() }} Pertemuan Total</span>
                    </div>
                </div>

                {{-- Export Button --}}
                <a href="{{ route('teacher.attendance.export', $classroom) }}" 
                   class="relative group overflow-hidden px-6 py-2.5 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-bold shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <div class="absolute inset-0 w-full h-full bg-white/20 -translate-x-full group-hover:animate-[shine_1s_infinite]"></div>
                    <div class="relative flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>Export CSV</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Main Table Card --}}
        <div class="glass-panel rounded-3xl overflow-hidden flex flex-col animate-enter delay-100">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700">
                            {{-- Sticky Name Column --}}
                            <th class="px-6 py-4 text-left text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-wider sticky left-0 z-20 sticky-col shadow-[4px_0_24px_-2px_rgba(0,0,0,0.05)] min-w-[200px]">
                                Nama Siswa
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">
                                Hadir
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-black text-blue-600 dark:text-blue-400 uppercase tracking-wider">
                                Izin
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-black text-amber-600 dark:text-amber-400 uppercase tracking-wider">
                                Sakit
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-black text-rose-600 dark:text-rose-400 uppercase tracking-wider">
                                Alpha
                            </th>
                            <th class="px-4 py-4 text-center text-xs font-black text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-wider min-w-[140px]">
                                Persentase
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($students as $index => $student)
                            @php
                                $data = $summary[$student->id] ?? ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0, 'total' => 0];
                                $percentage = $data['total'] > 0 ? round(($data['hadir'] / $data['total']) * 100) : 0;
                                
                                // Color Logic
                                if($percentage >= 80) {
                                    $progressColor = 'bg-emerald-500';
                                    $textColor = 'text-emerald-600 dark:text-emerald-400';
                                } elseif($percentage >= 60) {
                                    $progressColor = 'bg-amber-500';
                                    $textColor = 'text-amber-600 dark:text-amber-400';
                                } else {
                                    $progressColor = 'bg-rose-500';
                                    $textColor = 'text-rose-600 dark:text-rose-400';
                                }
                            @endphp
                            <tr class="group transition-colors hover:bg-emerald-50/30 dark:hover:bg-slate-800/50">
                                {{-- Sticky Name Column --}}
                                <td class="px-6 py-4 sticky left-0 z-10 sticky-col shadow-[4px_0_24px_-2px_rgba(0,0,0,0.05)]">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-500 dark:text-slate-300">
                                            {{ $index + 1 }}
                                        </div>
                                        <span class="font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                            {{ $student->name }}
                                        </span>
                                    </div>
                                </td>
                                
                                {{-- Stats Columns --}}
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] py-1 rounded-lg bg-emerald-100/50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 font-bold text-sm">
                                        {{ $data['hadir'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] py-1 rounded-lg bg-blue-100/50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 font-bold text-sm">
                                        {{ $data['izin'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] py-1 rounded-lg bg-amber-100/50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 font-bold text-sm">
                                        {{ $data['sakit'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="inline-flex items-center justify-center min-w-[2.5rem] py-1 rounded-lg bg-rose-100/50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 font-bold text-sm">
                                        {{ $data['alpha'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <span class="font-black text-slate-700 dark:text-slate-300">{{ $data['total'] }}</span>
                                </td>
                                
                                {{-- Progress Column --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1.5">
                                        <div class="flex items-center justify-between text-xs font-bold">
                                            <span class="text-slate-400">Rate</span>
                                            <span class="{{ $textColor }}">{{ $percentage }}%</span>
                                        </div>
                                        <div class="w-full h-2 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full {{ $progressColor }} transition-all duration-1000 ease-out" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada data absensi untuk ditampilkan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Footer Legend --}}
            <div class="px-6 py-4 bg-white/40 dark:bg-slate-800/40 border-t border-slate-200 dark:border-slate-700/50 flex flex-wrap gap-6 items-center justify-center sm:justify-start">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Keterangan:</span>
                
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></span>
                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">≥ 80% (Baik)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-sm shadow-amber-500/50"></span>
                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">60-79% (Cukup)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-rose-500 shadow-sm shadow-rose-500/50"></span>
                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">< 60% (Kurang)</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection