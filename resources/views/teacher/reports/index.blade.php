@extends('layouts.teacher')

@section('title', 'Laporan Penilaian')
@section('page-title', 'Laporan Penilaian')

@push('styles')
<style>
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    
    .animate-card { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    
    .glass-panel {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.05);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
    }

    .glass-button {
        background: linear-gradient(135deg, #10B981 0%, #0F766E 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }
    .glass-button:hover {
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden transition-colors duration-500 bg-[#F0FDF4] dark:bg-[#0B1120]">
    
    {{-- Ambient Background --}}
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_8s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_10s_ease-in-out_infinite_reverse]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto space-y-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 animate-card">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-slate-900 dark:text-white">
                    Laporan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Penilaian</span>
                </h2>
                <p class="mt-2 text-slate-600 dark:text-slate-400 font-medium">
                    Pantau progres akademik dan rekapitulasi nilai siswa Anda.
                </p>
            </div>
            
            <div class="glass-panel px-4 py-2 rounded-full flex items-center gap-2 text-xs font-bold text-emerald-700 dark:text-emerald-400 bg-emerald-50/50 dark:bg-emerald-900/20">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>{{ $classrooms->count() }} Kelas Aktif</span>
            </div>
        </div>

        {{-- Classrooms Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($classrooms as $index => $classroom)
                <div class="glass-panel rounded-3xl p-6 relative group transition-all duration-300 hover:-translate-y-2 hover:border-emerald-500/30 dark:hover:border-emerald-500/30 animate-card" 
                     style="animation-delay: {{ $index * 100 }}ms">
                    
                    {{-- Decorative Gradient Line --}}
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-t-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>

                    {{-- Card Header --}}
                    <div class="flex items-start justify-between mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-100 to-teal-50 dark:from-slate-700 dark:to-slate-800 flex items-center justify-center shadow-inner">
                                <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-br from-emerald-600 to-teal-600 dark:from-emerald-400 dark:to-teal-400">
                                    {{ strtoupper(substr($classroom->subject ?? $classroom->name, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white line-clamp-1 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                    {{ $classroom->name }}
                                </h3>
                                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                    {{ $classroom->subject ?? 'General' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="p-3 rounded-2xl bg-white/50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 text-center group-hover:bg-emerald-50/50 dark:group-hover:bg-emerald-900/10 transition-colors">
                            <span class="block text-2xl font-black text-slate-800 dark:text-white">{{ $classroom->students_count }}</span>
                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase">Siswa</span>
                        </div>
                        <div class="p-3 rounded-2xl bg-white/50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 text-center group-hover:bg-teal-50/50 dark:group-hover:bg-teal-900/10 transition-colors">
                            <span class="block text-2xl font-black text-slate-800 dark:text-white">{{ $classroom->assignments_count }}</span>
                            <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase">Tugas</span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('teacher.reports.classroom', $classroom) }}" 
                           class="glass-button flex-1 py-2.5 px-4 rounded-xl text-white font-bold text-sm text-center flex items-center justify-center gap-2 transition-all">
                            <span>Buka Laporan</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        
                        <a href="{{ route('teacher.reports.export', $classroom) }}" 
                           class="p-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors border border-transparent hover:border-emerald-200 dark:hover:border-emerald-800"
                           title="Export Data">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full animate-card" style="animation-delay: 100ms">
                    <div class="glass-panel rounded-3xl p-12 text-center flex flex-col items-center justify-center">
                        <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">Data Belum Tersedia</h3>
                        <p class="text-slate-500 dark:text-slate-400 mt-2">Belum ada kelas yang dapat ditampilkan laporannya saat ini.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection