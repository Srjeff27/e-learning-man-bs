@extends('layouts.teacher')

@section('title', 'Detail Pertemuan - ' . $classroom->name)

@push('styles')
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<style>
    /* Custom Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
    @keyframes pulse-soft { 0%, 100% { opacity: 1; } 50% { opacity: 0.7; } }

    .animate-enter { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }

    /* Glass Effect */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.05);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }

    /* Stat Cards */
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_8s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_10s_ease-in-out_infinite_reverse]"></div>
    </div>

    <div class="max-w-6xl mx-auto relative z-10 space-y-8">
        
        {{-- Navigation --}}
        <div class="animate-enter">
            <a href="{{ route('teacher.attendance.index', $classroom) }}" 
               class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors mb-4 group">
                <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center mr-2 shadow-sm group-hover:shadow-md transition-all group-hover:-translate-x-1 text-emerald-500 border border-slate-100 dark:border-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Daftar Pertemuan
            </a>
        </div>

        {{-- Main Header Card --}}
        <div class="animate-enter delay-100 relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-xl shadow-emerald-500/30 text-white p-6 sm:p-10">
            {{-- Decorative Shapes --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-teal-900/20 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-xs font-bold uppercase tracking-wider shadow-sm">
                            Pertemuan Ke-{{ $session->session_number }}
                        </span>
                        <span class="flex items-center gap-1.5 text-emerald-50 font-medium text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            {{ $session->date->translatedFormat('l, d F Y') }}
                        </span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight leading-tight">
                        {{ $session->topic }}
                    </h1>
                    <p class="text-emerald-100 text-lg font-medium opacity-90">
                        {{ $classroom->name }} &bull; {{ $classroom->subject ?? 'Mata Pelajaran' }}
                    </p>
                </div>

                <a href="{{ route('teacher.attendance.take', [$classroom, $session]) }}" 
                   class="group relative overflow-hidden px-6 py-3 rounded-xl bg-white text-emerald-600 font-bold shadow-lg transition-all hover:shadow-xl hover:-translate-y-0.5 whitespace-nowrap">
                    <div class="relative flex items-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>Edit Absensi</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Summary Stats Grid --}}
        @php $summary = $session->summary; @endphp
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 animate-enter delay-200">
            {{-- Total Students --}}
            <div class="stat-card glass-panel rounded-2xl p-5 flex flex-col items-center justify-center text-center">
                <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-300 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-3xl font-black text-slate-800 dark:text-white">{{ $students->count() }}</span>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide">Total Siswa</span>
            </div>

            {{-- Hadir --}}
            <div class="stat-card glass-panel rounded-2xl p-5 flex flex-col items-center justify-center text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-emerald-500/5 group-hover:bg-emerald-500/10 transition-colors"></div>
                <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400">{{ $summary['hadir'] }}</span>
                <span class="text-xs font-bold text-emerald-600/70 dark:text-emerald-400/70 uppercase tracking-wide mt-1">Hadir</span>
                <div class="w-full h-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-full mt-3 overflow-hidden">
                    <div class="h-full bg-emerald-500" style="width: {{ $students->count() > 0 ? ($summary['hadir'] / $students->count()) * 100 : 0 }}%"></div>
                </div>
            </div>

            {{-- Izin --}}
            <div class="stat-card glass-panel rounded-2xl p-5 flex flex-col items-center justify-center text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-blue-500/5 group-hover:bg-blue-500/10 transition-colors"></div>
                <span class="text-3xl font-black text-blue-600 dark:text-blue-400">{{ $summary['izin'] }}</span>
                <span class="text-xs font-bold text-blue-600/70 dark:text-blue-400/70 uppercase tracking-wide mt-1">Izin</span>
            </div>

            {{-- Sakit --}}
            <div class="stat-card glass-panel rounded-2xl p-5 flex flex-col items-center justify-center text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-amber-500/5 group-hover:bg-amber-500/10 transition-colors"></div>
                <span class="text-3xl font-black text-amber-600 dark:text-amber-400">{{ $summary['sakit'] }}</span>
                <span class="text-xs font-bold text-amber-600/70 dark:text-amber-400/70 uppercase tracking-wide mt-1">Sakit</span>
            </div>

            {{-- Alpha --}}
            <div class="stat-card glass-panel rounded-2xl p-5 flex flex-col items-center justify-center text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-rose-500/5 group-hover:bg-rose-500/10 transition-colors"></div>
                <span class="text-3xl font-black text-rose-600 dark:text-rose-400">{{ $summary['alpha'] }}</span>
                <span class="text-xs font-bold text-rose-600/70 dark:text-rose-400/70 uppercase tracking-wide mt-1">Alpha</span>
            </div>
        </div>

        {{-- Detail List --}}
        <div class="glass-panel rounded-3xl overflow-hidden animate-enter delay-300 flex flex-col">
            <div class="px-8 py-6 border-b border-slate-200 dark:border-slate-700/50 bg-white/40 dark:bg-slate-800/40 backdrop-blur-sm flex justify-between items-center">
                <h2 class="font-bold text-lg text-slate-800 dark:text-white flex items-center gap-2">
                    <span class="w-1.5 h-6 rounded-full bg-emerald-500"></span>
                    Detail Kehadiran Siswa
                </h2>
                <div class="text-xs font-medium text-slate-500 dark:text-slate-400">
                    Diurutkan berdasarkan nama
                </div>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                @forelse($students as $index => $student)
                    @php
                        $attendance = $attendances->get($student->id);
                        $status = $attendance?->status ?? '-';
                        
                        // Define styles based on status
                        $statusStyles = [
                            'hadir' => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'text' => 'text-emerald-700 dark:text-emerald-400', 'border' => 'border-emerald-200 dark:border-emerald-800', 'label' => 'Hadir'],
                            'izin' => ['bg' => 'bg-blue-100 dark:bg-blue-900/30', 'text' => 'text-blue-700 dark:text-blue-400', 'border' => 'border-blue-200 dark:border-blue-800', 'label' => 'Izin'],
                            'sakit' => ['bg' => 'bg-amber-100 dark:bg-amber-900/30', 'text' => 'text-amber-700 dark:text-amber-400', 'border' => 'border-amber-200 dark:border-amber-800', 'label' => 'Sakit'],
                            'alpha' => ['bg' => 'bg-rose-100 dark:bg-rose-900/30', 'text' => 'text-rose-700 dark:text-rose-400', 'border' => 'border-rose-200 dark:border-rose-800', 'label' => 'Alpha'],
                            '-' => ['bg' => 'bg-slate-100 dark:bg-slate-800', 'text' => 'text-slate-500 dark:text-slate-400', 'border' => 'border-slate-200 dark:border-slate-700', 'label' => 'Belum Absen'],
                        ];
                        $style = $statusStyles[$status] ?? $statusStyles['-'];
                    @endphp

                    <div class="p-5 hover:bg-emerald-50/30 dark:hover:bg-slate-800/50 transition-colors group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center text-sm font-bold text-slate-500 dark:text-slate-400">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 dark:text-white text-base">{{ $student->name }}</p>
                                    @if($attendance?->notes)
                                        <div class="flex items-center gap-1.5 mt-1 text-xs text-slate-500 dark:text-slate-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                            <span class="italic">{{ $attendance->notes }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <span class="px-4 py-1.5 rounded-lg text-sm font-bold border {{ $style['bg'] }} {{ $style['text'] }} {{ $style['border'] }} shadow-sm">
                                {{ $style['label'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada siswa yang terdaftar di kelas ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection