@extends('layouts.teacher')

@section('title', 'Absensi - ' . $classroom->name)

@push('styles')
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<style>
    /* Custom Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    .animate-enter { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }

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

    /* Glossy Button */
    .btn-glossy {
        background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0.1) 100%);
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255,255,255,0.3);
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .dark .btn-glossy {
        background: linear-gradient(135deg, rgba(30,41,59,0.4) 0%, rgba(30,41,59,0.1) 100%);
        border: 1px solid rgba(255,255,255,0.05);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_8s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_10s_ease-in-out_infinite_reverse]"></div>
    </div>

    <div class="max-w-5xl mx-auto relative z-10 space-y-8">
        
        {{-- Breadcrumb & Header --}}
        <div class="animate-enter">
            <a href="{{ route('teacher.attendance.classrooms') }}" 
               class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors mb-6 group">
                <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center mr-2 shadow-sm group-hover:shadow-md transition-all group-hover:-translate-x-1 text-emerald-500 border border-slate-100 dark:border-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Daftar Kelas
            </a>

            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-black tracking-tight text-slate-900 dark:text-white">
                        {{ $classroom->name }}
                    </h1>
                    <div class="flex items-center gap-3 mt-2 text-slate-500 dark:text-slate-400 font-medium">
                        <span class="px-2.5 py-0.5 rounded-lg bg-emerald-100 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 text-xs font-bold uppercase tracking-wider">
                            {{ $classroom->subject }}
                        </span>
                        <span>•</span>
                        <span>{{ $classroom->grade }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('teacher.attendance.report', $classroom) }}" 
                       class="btn-glossy px-5 py-2.5 rounded-xl text-slate-700 dark:text-slate-200 font-bold hover:text-emerald-600 dark:hover:text-emerald-400 hover:bg-white dark:hover:bg-slate-800 transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="hidden sm:inline">Lihat</span> Rekap
                    </a>
                    
                    <a href="{{ route('teacher.attendance.create', $classroom) }}" 
                       class="relative group overflow-hidden px-6 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-bold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all transform hover:-translate-y-0.5">
                        <div class="absolute inset-0 w-full h-full bg-white/20 -translate-x-full group-hover:animate-[shine_1s_infinite]"></div>
                        <div class="relative flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            <span>Buat Pertemuan</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Content Area --}}
        <div class="animate-enter delay-100">
            @if($sessions->isEmpty())
                <div class="glass-panel rounded-3xl p-12 text-center flex flex-col items-center justify-center">
                    <div class="w-24 h-24 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-full flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-12 h-12 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Belum Ada Pertemuan</h3>
                    <p class="text-slate-500 dark:text-slate-400 mt-2 mb-8 max-w-md">Data pertemuan absensi masih kosong. Silakan buat pertemuan pertama untuk mulai mencatat kehadiran siswa.</p>
                    <a href="{{ route('teacher.attendance.create', $classroom) }}" class="inline-flex items-center px-6 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-bold hover:opacity-90 transition-opacity">
                        Buat Pertemuan Pertama
                    </a>
                </div>
            @else
                <div class="glass-panel rounded-3xl overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-slate-200/60 dark:border-slate-700/60 bg-white/40 dark:bg-slate-800/40 backdrop-blur-sm flex justify-between items-center">
                        <h2 class="font-bold text-lg text-slate-800 dark:text-white flex items-center gap-2">
                            <span class="w-2 h-6 rounded-full bg-emerald-500"></span>
                            Riwayat Pertemuan
                        </h2>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-100 dark:bg-slate-700 px-3 py-1 rounded-full">
                            {{ $sessions->total() }} Sesi
                        </span>
                    </div>
                    
                    <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @foreach($sessions as $session)
                            <div class="p-6 hover:bg-emerald-50/40 dark:hover:bg-emerald-900/10 transition-colors group relative">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                    
                                    {{-- Session Info --}}
                                    <div class="flex items-start gap-5">
                                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-white to-slate-100 dark:from-slate-700 dark:to-slate-800 border border-slate-200 dark:border-slate-600 flex flex-col items-center justify-center shadow-sm shrink-0">
                                            <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-400">Sesi</span>
                                            <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $session->session_number }}</span>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-1 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                                {{ $session->topic }}
                                            </h3>
                                            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                {{ $session->date->translatedFormat('l, d F Y') }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Stats & Actions --}}
                                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                                        {{-- Stats Badges --}}
                                        @php $s = $session->summary; @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="flex flex-col items-center px-3 py-1.5 rounded-lg bg-emerald-100/80 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800">
                                                <span class="text-xs font-bold text-emerald-700 dark:text-emerald-400">Hadir</span>
                                                <span class="font-black text-emerald-800 dark:text-emerald-300">{{ $s['hadir'] }}</span>
                                            </div>
                                            <div class="flex flex-col items-center px-3 py-1.5 rounded-lg bg-blue-100/80 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800">
                                                <span class="text-xs font-bold text-blue-700 dark:text-blue-400">Izin</span>
                                                <span class="font-black text-blue-800 dark:text-blue-300">{{ $s['izin'] }}</span>
                                            </div>
                                            <div class="flex flex-col items-center px-3 py-1.5 rounded-lg bg-amber-100/80 dark:bg-amber-900/30 border border-amber-200 dark:border-amber-800">
                                                <span class="text-xs font-bold text-amber-700 dark:text-amber-400">Sakit</span>
                                                <span class="font-black text-amber-800 dark:text-amber-300">{{ $s['sakit'] }}</span>
                                            </div>
                                            <div class="flex flex-col items-center px-3 py-1.5 rounded-lg bg-rose-100/80 dark:bg-rose-900/30 border border-rose-200 dark:border-rose-800">
                                                <span class="text-xs font-bold text-rose-700 dark:text-rose-400">Alpha</span>
                                                <span class="font-black text-rose-800 dark:text-rose-300">{{ $s['alpha'] }}</span>
                                            </div>
                                        </div>
                                        
                                        {{-- Action Buttons --}}
                                        <div class="flex items-center gap-2 pl-0 sm:pl-6 sm:border-l border-slate-200 dark:border-slate-700">
                                            <a href="{{ route('teacher.attendance.take', [$classroom, $session]) }}" 
                                               class="p-2.5 rounded-xl bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600 hover:border-emerald-500 hover:text-emerald-600 dark:hover:border-emerald-500 dark:hover:text-emerald-400 transition-all shadow-sm" title="Edit Absensi">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <a href="{{ route('teacher.attendance.show', [$classroom, $session]) }}" 
                                               class="p-2.5 rounded-xl bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600 hover:border-blue-500 hover:text-blue-600 dark:hover:border-blue-500 dark:hover:text-blue-400 transition-all shadow-sm" title="Lihat Detail">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <form action="{{ route('teacher.attendance.destroy', [$classroom, $session]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pertemuan ini? Data absensi siswa juga akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2.5 rounded-xl bg-white dark:bg-slate-700 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-600 hover:border-rose-500 hover:text-rose-600 dark:hover:border-rose-500 dark:hover:text-rose-400 transition-all shadow-sm" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($sessions->hasPages())
                        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700/50 bg-slate-50 dark:bg-slate-800/30">
                            {{ $sessions->links() }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection