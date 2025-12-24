@extends('layouts.teacher')

@section('title', 'Absensi Kelas')
@section('page-title', 'Absensi Kelas')

@push('styles')
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<style>
    /* Custom Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    .animate-enter { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    
    /* Premium Glass Effect */
    .glass-card {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
    }
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
    }

    /* Glossy Elements */
    .glossy-stat {
        background: linear-gradient(145deg, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0.2) 100%);
        border: 1px solid rgba(255,255,255,0.4);
    }
    .dark .glossy-stat {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.5) 0%, rgba(30, 41, 59, 0.2) 100%);
        border: 1px solid rgba(255,255,255,0.05);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_8s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_10s_ease-in-out_infinite_reverse]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto space-y-10">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 animate-enter">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white">
                    Absensi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Kelas</span>
                </h2>
                <p class="mt-2 text-slate-600 dark:text-slate-400 font-medium">
                    Kelola kehadiran dan pantau aktivitas siswa secara real-time.
                </p>
            </div>
            
            <div class="glass-card px-5 py-2.5 rounded-full flex items-center gap-2 text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50/50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800">
                <span class="relative flex h-2.5 w-2.5">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                <span>{{ $classrooms->count() }} Kelas Aktif</span>
            </div>
        </div>

        {{-- Grid System --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($classrooms as $index => $classroom)
                <a href="{{ route('teacher.attendance.index', $classroom) }}" 
                   class="glass-card rounded-3xl p-6 relative group transition-all duration-300 hover:-translate-y-2 hover:shadow-emerald-500/10 hover:border-emerald-500/30 animate-enter"
                   style="animation-delay: {{ $index * 100 }}ms">
                    
                    {{-- Decorative Line --}}
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-t-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    {{-- Card Header --}}
                    <div class="flex items-start gap-4 mb-6">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-50 dark:from-emerald-900/30 dark:to-teal-900/30 flex items-center justify-center shadow-inner shrink-0 group-hover:scale-105 transition-transform">
                            <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-br from-emerald-600 to-teal-600 dark:from-emerald-400 dark:to-teal-400">
                                {{ strtoupper(substr($classroom->subject ?? $classroom->name, 0, 1)) }}
                            </span>
                        </div>
                        <div class="min-w-0">
                            <h3 class="font-bold text-lg text-slate-900 dark:text-white truncate group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                {{ $classroom->name }}
                            </h3>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider truncate">
                                {{ $classroom->subject ?? 'General' }}
                            </p>
                        </div>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="glossy-stat rounded-2xl p-3 text-center transition-colors group-hover:bg-emerald-50/50 dark:group-hover:bg-emerald-900/20">
                            <span class="block text-2xl font-black text-slate-800 dark:text-white">{{ $classroom->students_count }}</span>
                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase">Siswa</span>
                        </div>
                        <div class="glossy-stat rounded-2xl p-3 text-center transition-colors group-hover:bg-teal-50/50 dark:group-hover:bg-teal-900/20">
                            <span class="block text-2xl font-black text-slate-800 dark:text-white">{{ $classroom->attendance_sessions_count }}</span>
                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase">Sesi</span>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="flex items-center justify-between pt-4 border-t border-slate-200/50 dark:border-slate-700/50">
                        <div class="flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400">
                            <span class="bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded text-[10px] font-bold uppercase">{{ $classroom->grade }}</span>
                            <span>{{ $classroom->semester }}</span>
                        </div>
                        <div class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full animate-enter" style="animation-delay: 100ms">
                    <div class="glass-card rounded-3xl p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-6 shadow-sm">
                            <svg class="w-10 h-10 text-slate-300 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">Belum Ada Kelas</h3>
                        <p class="text-slate-500 dark:text-slate-400 mt-2 mb-6 max-w-sm mx-auto">Mulai dengan membuat kelas baru untuk mengelola absensi siswa Anda.</p>
                        
                        <a href="{{ route('teacher.classrooms.create') }}" 
                           class="relative group overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-px shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="relative px-6 py-3 bg-transparent flex items-center justify-center gap-2">
                                <span class="font-bold text-white tracking-wide">Buat Kelas Baru</span>
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                        </a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection