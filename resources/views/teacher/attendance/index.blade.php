@extends('layouts.teacher')

@section('title', 'Absensi - ' . $classroom->name)
@section('page-title', 'Absensi ' . $classroom->name)

@push('styles')
<style>
    .animate-enter { animation: enter 0.6s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .delay-100 { animation-delay: 0.1s; }
    @keyframes enter { to { opacity: 1; transform: translateY(0); } }

    .glass-card {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(16px) saturate(180%);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
    }
    .dark .glass-card {
        background: rgba(20, 30, 25, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    {{-- Breadcrumb --}}
    <div class="animate-enter">
        <a href="{{ route('teacher.attendance.classrooms') }}" class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
            <div class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-300 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </div>
            Kembali ke Daftar Kelas
        </a>
    </div>

    {{-- Header --}}
    <div class="animate-enter flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $classroom->name }}</h1>
            <p class="text-slate-500 dark:text-slate-400">{{ $classroom->subject }} • {{ $classroom->grade }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('teacher.attendance.report', $classroom) }}" class="px-4 py-2.5 glass-card rounded-xl text-slate-600 dark:text-slate-300 font-semibold hover:bg-white dark:hover:bg-slate-800 transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Rekap
            </a>
            <a href="{{ route('teacher.attendance.create', $classroom) }}" class="px-4 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl font-semibold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Pertemuan
            </a>
        </div>
    </div>

    {{-- Sessions List --}}
    <div class="animate-enter delay-100">
        @if($sessions->isEmpty())
            <div class="glass-card rounded-2xl p-12 text-center">
                <div class="w-20 h-20 bg-emerald-50 dark:bg-emerald-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Belum Ada Pertemuan</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6">Buat pertemuan pertama untuk mulai mengabsen siswa.</p>
                <a href="{{ route('teacher.attendance.create', $classroom) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-semibold hover:from-emerald-600 hover:to-teal-700 transition-all shadow-lg shadow-emerald-500/30">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Buat Pertemuan Pertama
                </a>
            </div>
        @else
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 bg-white/50 dark:bg-slate-900/50 backdrop-blur-md">
                    <h2 class="font-bold text-lg text-slate-800 dark:text-white">Daftar Pertemuan</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $sessions->total() }} pertemuan tercatat</p>
                </div>
                
                <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @foreach($sessions as $session)
                        <div class="p-6 hover:bg-white/60 dark:hover:bg-slate-800/50 transition-colors group">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-xl flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold text-lg shadow-sm">
                                        {{ $session->session_number }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 dark:text-white">Pertemuan {{ $session->session_number }}</h3>
                                        <p class="text-sm text-slate-600 dark:text-slate-300">{{ $session->topic }}</p>
                                        <p class="text-xs text-slate-400 mt-1">{{ $session->date->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    @php
                                        $summary = $session->summary;
                                    @endphp
                                    <div class="flex items-center gap-2 text-xs">
                                        <span class="px-2 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 font-semibold">H: {{ $summary['hadir'] }}</span>
                                        <span class="px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-semibold">I: {{ $summary['izin'] }}</span>
                                        <span class="px-2 py-1 rounded-full bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 font-semibold">S: {{ $summary['sakit'] }}</span>
                                        <span class="px-2 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 font-semibold">A: {{ $summary['alpha'] }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('teacher.attendance.take', [$classroom, $session]) }}" class="p-2 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors" title="Edit Absensi">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <a href="{{ route('teacher.attendance.show', [$classroom, $session]) }}" class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Lihat Detail">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <form action="{{ route('teacher.attendance.destroy', [$classroom, $session]) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pertemuan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors" title="Hapus">
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
                    <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/30">
                        {{ $sessions->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
