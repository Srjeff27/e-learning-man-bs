@extends('layouts.teacher')

@section('title', 'Absensi - Sesi ' . $session->session_number)

@push('styles')
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<style>
    /* Custom Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes scaleIn { from { transform: scale(0.95); opacity: 0; } to { transform: scale(1); opacity: 1; } }
    
    .animate-enter { animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
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

    /* Attendance Buttons Styles */
    .attendance-btn {
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .attendance-btn:hover { transform: translateY(-2px); }
    .attendance-btn:active { transform: scale(0.95); }
    
    /* Input Glossy */
    .input-glossy {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(209, 213, 219, 0.5);
        transition: all 0.3s ease;
    }
    .dark .input-glossy {
        background: rgba(30, 41, 59, 0.4);
        border: 1px solid rgba(71, 85, 105, 0.4);
    }
    .input-glossy:focus {
        background: rgba(255, 255, 255, 0.9);
        border-color: #10B981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.15);
        outline: none;
    }
    .dark .input-glossy:focus {
        background: rgba(30, 41, 59, 0.8);
        border-color: #34D399;
        box-shadow: 0 0 0 4px rgba(52, 211, 153, 0.15);
    }
</style>
{{-- AlpineJS for instant UI feedback --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-[600px] h-[600px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen"></div>
    </div>

    <div class="max-w-5xl mx-auto relative z-10 space-y-8">
        
        {{-- Navigation & Header --}}
        <div class="animate-enter">
            <a href="{{ route('teacher.attendance.index', $classroom) }}" 
               class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors mb-6 group">
                <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center mr-2 shadow-sm group-hover:shadow-md transition-all group-hover:-translate-x-1 text-emerald-500 border border-slate-100 dark:border-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Daftar Pertemuan
            </a>

            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-emerald-500 to-teal-600 shadow-xl shadow-emerald-500/30 text-white p-6 sm:p-8">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-xs font-bold uppercase tracking-wider shadow-sm">
                                Sesi {{ $session->session_number }}
                            </span>
                            <span class="flex items-center gap-1.5 text-emerald-50 font-medium text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                {{ $session->date->translatedFormat('l, d F Y') }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-black tracking-tight">{{ $session->topic }}</h1>
                        <p class="text-emerald-100 font-medium mt-1">{{ $classroom->name }}</p>
                    </div>

                    <div class="flex items-center gap-4 bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/10">
                        <div class="text-center">
                            <span class="block text-2xl font-black">{{ $students->count() }}</span>
                            <span class="text-xs text-emerald-100 uppercase font-bold tracking-wider">Total Siswa</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Form --}}
        <form action="{{ route('teacher.attendance.store', [$classroom, $session]) }}" method="POST" class="animate-enter delay-100">
            @csrf

            <div class="glass-panel rounded-3xl overflow-hidden flex flex-col">
                
                {{-- Legend / Helper --}}
                <div class="px-6 py-4 bg-slate-50/80 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700/50 flex flex-wrap items-center justify-between gap-4">
                    <p class="text-sm font-bold text-slate-500 dark:text-slate-400 hidden sm:block">Status Kehadiran:</p>
                    <div class="flex flex-wrap items-center gap-2 sm:gap-4 w-full sm:w-auto justify-center sm:justify-end">
                        @foreach(\App\Models\Attendance::STATUSES as $key => $data)
                            <div class="flex items-center gap-1.5 px-2 py-1 rounded-lg bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 shadow-sm">
                                <span class="w-5 h-5 rounded flex items-center justify-center text-[10px] font-black uppercase
                                    {{ $key === 'hadir' ? 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400' : '' }}
                                    {{ $key === 'izin' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-400' : '' }}
                                    {{ $key === 'sakit' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-400' : '' }}
                                    {{ $key === 'alpha' ? 'bg-rose-100 text-rose-700 dark:bg-rose-900/50 dark:text-rose-400' : '' }}">
                                    {{ substr($data['label'], 0, 1) }}
                                </span>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">{{ $data['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Student List --}}
                <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($students as $index => $student)
                        @php
                            $attendance = $attendances->get($student->id);
                            $currentStatus = $attendance?->status ?? 'hadir'; // Default Hadir
                            $currentNotes = $attendance?->notes ?? '';
                        @endphp
                        
                        {{-- Row Component with Alpine Data --}}
                        <div class="p-4 sm:p-5 hover:bg-emerald-50/20 dark:hover:bg-slate-800/40 transition-colors"
                             x-data="{ status: '{{ $currentStatus }}', notes: '{{ $currentNotes }}' }">
                            
                            <div class="flex flex-col lg:flex-row lg:items-center gap-4 lg:gap-6">
                                
                                {{-- Student Info --}}
                                <div class="flex items-center gap-4 lg:w-1/3 min-w-0">
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-sm font-bold text-slate-500 dark:text-slate-400 shrink-0">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 dark:text-white truncate text-base">{{ $student->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 truncate">{{ $student->email }}</p>
                                    </div>
                                </div>

                                {{-- Action Area --}}
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 lg:w-2/3">
                                    
                                    {{-- Status Buttons --}}
                                    <div class="flex items-center justify-between sm:justify-start gap-2 w-full sm:w-auto p-1 bg-slate-100/50 dark:bg-slate-800/50 rounded-2xl border border-slate-200/50 dark:border-slate-700/50">
                                        @foreach(\App\Models\Attendance::STATUSES as $key => $data)
                                            <label class="relative cursor-pointer">
                                                <input type="radio" name="attendance[{{ $student->id }}][status]" value="{{ $key }}"
                                                       x-model="status" class="sr-only">
                                                
                                                <div class="attendance-btn w-12 h-10 sm:w-14 sm:h-11 rounded-xl flex items-center justify-center font-bold text-sm transition-all duration-300 border"
                                                     :class="{
                                                        'bg-gradient-to-br from-green-500 to-green-600 text-white border-green-600 shadow-lg shadow-green-500/30 scale-105': status === 'hadir' && '{{ $key }}' === 'hadir',
                                                        'text-green-600 dark:text-green-400 border-transparent hover:bg-green-50 dark:hover:bg-green-900/20': status !== 'hadir' && '{{ $key }}' === 'hadir',
                                                        
                                                        'bg-gradient-to-br from-blue-500 to-blue-600 text-white border-blue-600 shadow-lg shadow-blue-500/30 scale-105': status === 'izin' && '{{ $key }}' === 'izin',
                                                        'text-blue-600 dark:text-blue-400 border-transparent hover:bg-blue-50 dark:hover:bg-blue-900/20': status !== 'izin' && '{{ $key }}' === 'izin',
                                                        
                                                        'bg-gradient-to-br from-amber-500 to-amber-600 text-white border-amber-600 shadow-lg shadow-amber-500/30 scale-105': status === 'sakit' && '{{ $key }}' === 'sakit',
                                                        'text-amber-600 dark:text-amber-400 border-transparent hover:bg-amber-50 dark:hover:bg-amber-900/20': status !== 'sakit' && '{{ $key }}' === 'sakit',
                                                        
                                                        'bg-gradient-to-br from-rose-500 to-rose-600 text-white border-rose-600 shadow-lg shadow-rose-500/30 scale-105': status === 'alpha' && '{{ $key }}' === 'alpha',
                                                        'text-rose-600 dark:text-rose-400 border-transparent hover:bg-rose-50 dark:hover:bg-rose-900/20': status !== 'alpha' && '{{ $key }}' === 'alpha',
                                                     }">
                                                    {{ substr($data['label'], 0, 1) }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>

                                    {{-- Notes Input --}}
                                    <div class="w-full relative group">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </div>
                                        <input type="text" name="attendance[{{ $student->id }}][notes]" x-model="notes"
                                            class="input-glossy w-full pl-9 pr-4 py-2.5 rounded-xl text-sm font-medium text-slate-800 dark:text-white placeholder-slate-400"
                                            placeholder="Catatan (Opsional)...">
                                    </div>

                                </div>
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

            {{-- Floating/Fixed Action Bar --}}
            @if($students->isNotEmpty())
                <div class="mt-8 flex flex-col sm:flex-row justify-end gap-4 animate-enter delay-200">
                    <a href="{{ route('teacher.attendance.index', $classroom) }}" 
                       class="px-8 py-4 rounded-xl text-slate-600 dark:text-slate-300 font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-center shadow-sm">
                        Batal
                    </a>
                    
                    <button type="submit" 
                            class="relative group overflow-hidden px-8 py-4 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-px shadow-xl shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative flex items-center justify-center gap-2">
                            <span class="font-bold text-white tracking-wide text-lg">Simpan Absensi</span>
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        {{-- Shine effect --}}
                        <div class="absolute inset-0 -translate-x-full group-hover:animate-[shine_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent z-10"></div>
                    </button>
                </div>
            @endif

        </form>
    </div>
</div>
@endsection