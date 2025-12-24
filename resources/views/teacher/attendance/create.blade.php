@extends('layouts.teacher')

@section('title', 'Buat Pertemuan - ' . $classroom->name)

@push('styles')
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<style>
    /* Custom Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
    @keyframes shine { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }

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

    /* Glossy Inputs */
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
        background: rgba(255, 255, 255, 0.95);
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
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_8s_ease-in-out_infinite]"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen animate-[float_10s_ease-in-out_infinite_reverse]"></div>
    </div>

    <div class="max-w-3xl mx-auto relative z-10">
        
        {{-- Navigation --}}
        <div class="mb-8 animate-enter">
            <a href="{{ route('teacher.attendance.index', $classroom) }}" 
               class="group inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors">
                <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center mr-2 shadow-sm group-hover:shadow-md transition-all group-hover:-translate-x-1 text-emerald-500 border border-slate-100 dark:border-slate-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Absensi
            </a>
        </div>

        {{-- Main Form Card --}}
        <div class="glass-panel rounded-3xl p-8 sm:p-10 animate-enter delay-100">
            
            {{-- Header --}}
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 shadow-xl shadow-emerald-500/30 mb-6 text-white transform hover:rotate-6 transition-transform duration-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">Buat Pertemuan Baru</h1>
                <div class="flex items-center justify-center gap-2 mt-2 text-slate-500 dark:text-slate-400 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>{{ $classroom->name }}</span>
                </div>
            </div>

            <form action="{{ route('teacher.attendance.store-session', $classroom) }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Pertemuan Ke --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pertemuan Ke <span class="text-emerald-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="session_number" value="{{ old('session_number', $nextSessionNumber) }}"
                                class="input-glossy w-full pl-5 pr-4 py-3.5 rounded-xl text-slate-900 dark:text-white font-bold text-lg"
                                min="1" required>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <span class="text-xs font-bold">SESI</span>
                            </div>
                        </div>
                        @error('session_number') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tanggal --}}
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tanggal <span class="text-emerald-500">*</span></label>
                        <input type="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}"
                            class="input-glossy w-full px-5 py-3.5 rounded-xl text-slate-900 dark:text-white font-medium [color-scheme:light] dark:[color-scheme:dark]"
                            required>
                        @error('date') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Topik --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Materi / Topik Pembahasan <span class="text-emerald-500">*</span></label>
                    <input type="text" name="topic" value="{{ old('topic') }}"
                        class="input-glossy w-full px-5 py-3.5 rounded-xl text-slate-900 dark:text-white font-medium placeholder-slate-400"
                        placeholder="Contoh: Pengantar Aljabar Linear" required>
                    @error('topic') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Catatan --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Catatan Tambahan</label>
                    <textarea name="notes" rows="4"
                        class="input-glossy w-full px-5 py-3.5 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 resize-none"
                        placeholder="Catatan khusus untuk pertemuan ini (Opsional)...">{{ old('notes') }}</textarea>
                </div>

                {{-- Divider --}}
                <div class="w-full h-px bg-slate-200 dark:bg-slate-700/50 my-6"></div>

                {{-- Actions --}}
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <a href="{{ route('teacher.attendance.index', $classroom) }}"
                        class="w-full sm:w-auto px-6 py-4 rounded-xl text-slate-600 dark:text-slate-300 font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-center">
                        Batal
                    </a>
                    
                    <button type="submit" 
                            class="w-full sm:w-auto relative group overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-px shadow-xl shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="relative px-8 py-4 bg-transparent flex items-center justify-center gap-3 overflow-hidden rounded-xl">
                            <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
                            {{-- Shine Effect --}}
                            <div class="absolute inset-0 -translate-x-full group-hover:animate-[shine_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent z-10"></div>
                            
                            <span class="font-bold text-white tracking-wide z-20">Buat & Isi Absensi</span>
                            <svg class="w-5 h-5 text-white z-20 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection