@extends('layouts.teacher')

@section('title', 'Edit Tugas')

@push('styles')
{{-- Performance Optimization --}}
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<style>
    /* Custom Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shine { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }

    .animate-enter { animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }

    /* Glass Effect & Inputs */
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

    /* Scrollbar for Textareas */
    textarea::-webkit-scrollbar { width: 8px; }
    textarea::-webkit-scrollbar-track { background: transparent; }
    textarea::-webkit-scrollbar-thumb { background-color: rgba(16, 185, 129, 0.2); border-radius: 20px; }
</style>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen"></div>
    </div>

    <div class="max-w-5xl mx-auto relative z-10" x-data="{ 
        lateSubmission: {{ old('allow_late_submission', $assignment->allow_late_submission) ? 'true' : 'false' }},
        submitType: '{{ old('submission_type', $assignment->submission_type) }}'
    }">
        
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 animate-enter">
            <div>
                <a href="{{ route('teacher.assignments.show', [$classroom, $assignment]) }}" 
                   class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors mb-2 group">
                    <svg class="w-4 h-4 mr-1 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Detail
                </a>
                <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                    Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Tugas</span>
                </h1>
            </div>

            {{-- Delete Button (Mobile: Bottom, Desktop: Top-right) --}}
            <button type="button" @click="if(confirm('Yakin ingin menghapus tugas ini secara permanen?')) document.getElementById('delete-form').submit()" 
                class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all font-bold text-sm border border-transparent hover:border-rose-200 dark:hover:border-rose-800">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Hapus Tugas
            </button>
        </div>

        <form action="{{ route('teacher.assignments.update', [$classroom, $assignment]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Left Column: Main Content --}}
                <div class="lg:col-span-2 space-y-6 animate-enter delay-100">
                    
                    {{-- General Info Card --}}
                    <div class="glass-panel rounded-3xl p-6 sm:p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800 dark:text-white">Informasi Dasar</h2>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Judul Tugas <span class="text-emerald-500">*</span></label>
                                <input type="text" name="title" value="{{ old('title', $assignment->title) }}" 
                                       class="input-glossy w-full px-5 py-3 rounded-xl text-lg font-bold text-slate-900 dark:text-white placeholder-slate-400"
                                       required>
                                @error('title') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Deskripsi</label>
                                <textarea name="description" rows="3" 
                                          class="input-glossy w-full px-5 py-3 rounded-xl text-slate-800 dark:text-white placeholder-slate-400 resize-none">{{ old('description', $assignment->description) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Instruksi Detail</label>
                                <textarea name="instructions" rows="5" 
                                          class="input-glossy w-full px-5 py-3 rounded-xl text-slate-800 dark:text-white placeholder-slate-400 resize-none font-mono text-sm">{{ old('instructions', $assignment->instructions) }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Technical Config Card --}}
                    <div class="glass-panel rounded-3xl p-6 sm:p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800 dark:text-white">Pengaturan Teknis</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Nilai Maksimal</label>
                                <div class="relative">
                                    <input type="number" name="max_score" value="{{ old('max_score', $assignment->max_score) }}"
                                        class="input-glossy w-full px-5 py-3 rounded-xl text-slate-900 dark:text-white font-bold" min="1" max="100" required>
                                    <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-xs font-bold text-slate-400">POIN</div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Deadline</label>
                                <input type="datetime-local" name="due_date" 
                                    value="{{ old('due_date', $assignment->due_date ? $assignment->due_date->format('Y-m-d\TH:i') : '') }}"
                                    class="input-glossy w-full px-5 py-3 rounded-xl text-slate-900 dark:text-white text-sm font-medium [color-scheme:light] dark:[color-scheme:dark]">
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Tipe Pengumpulan</label>
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                    @php
                                        $types = [
                                            ['val' => 'file', 'label' => 'Upload File', 'icon' => '📄'],
                                            ['val' => 'text', 'label' => 'Teks Essay', 'icon' => '✍️'],
                                            ['val' => 'link', 'label' => 'Link URL', 'icon' => '🔗'],
                                            ['val' => 'multiple', 'label' => 'Kombinasi', 'icon' => '🧩'],
                                        ];
                                    @endphp
                                    @foreach($types as $t)
                                    <label class="cursor-pointer group">
                                        <input type="radio" name="submission_type" value="{{ $t['val'] }}" x-model="submitType" class="peer sr-only">
                                        <div class="p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-800 transition-all text-center peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-500/10 peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500">
                                            <div class="text-xl mb-1">{{ $t['icon'] }}</div>
                                            <span class="text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">{{ $t['label'] }}</span>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Advanced & Actions --}}
                <div class="space-y-6 animate-enter delay-200">
                    
                    {{-- Advanced Settings --}}
                    <div class="glass-panel rounded-3xl p-6 h-fit">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            Lanjutan
                        </h3>

                        <div class="space-y-6">
                            {{-- Late Submission --}}
                            <div class="p-4 rounded-2xl bg-white/40 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700 transition-all duration-300"
                                 :class="{ 'bg-amber-50/50 border-amber-200 dark:bg-amber-900/10 dark:border-amber-800/50': lateSubmission }">
                                <div class="flex items-center justify-between mb-2">
                                    <label for="late_sub" class="font-bold text-sm text-slate-800 dark:text-slate-200 cursor-pointer">Terima Terlambat</label>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="allow_late_submission" id="late_sub" value="1" x-model="lateSubmission" class="sr-only peer">
                                        <div class="w-10 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-amber-500"></div>
                                    </label>
                                </div>
                                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-3">Izinkan siswa mengumpulkan tugas setelah deadline terlewati.</p>
                                
                                {{-- Penalty Input (Conditional) --}}
                                <div x-show="lateSubmission" x-transition.opacity.duration.300ms>
                                    <div class="flex items-center gap-3 mt-3 pt-3 border-t border-slate-200 dark:border-slate-700/50">
                                        <label class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase">Denda Nilai (%)</label>
                                        <input type="number" name="late_penalty_percent" 
                                            value="{{ old('late_penalty_percent', $assignment->late_penalty_percent ?? 10) }}"
                                            class="w-20 px-2 py-1 text-center text-sm font-bold rounded-lg border border-amber-200 dark:border-amber-800 bg-white dark:bg-slate-900 focus:outline-none focus:ring-1 focus:ring-amber-500">
                                    </div>
                                </div>
                            </div>

                            {{-- Publish Status --}}
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-white/40 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-700">
                                <div>
                                    <span class="block font-bold text-sm text-slate-800 dark:text-slate-200">Status Publikasi</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">Tugas dapat dilihat siswa</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $assignment->is_published) ? 'checked' : '' }}>
                                    <div class="w-10 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-500"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="space-y-3">
                        <button type="submit" 
                                class="w-full relative group overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 p-px shadow-xl shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 hover:-translate-y-1">
                            <div class="relative px-6 py-4 bg-transparent rounded-2xl flex items-center justify-center gap-2 overflow-hidden">
                                <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
                                <div class="absolute inset-0 -translate-x-full group-hover:animate-[shine_1.5s_infinite] bg-gradient-to-r from-transparent via-white/20 to-transparent z-10"></div>
                                <span class="font-bold text-white tracking-wide z-20">Simpan Perubahan</span>
                                <svg class="w-5 h-5 text-white z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </button>

                        <a href="{{ route('teacher.assignments.show', [$classroom, $assignment]) }}" 
                           class="block w-full py-4 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 font-bold text-center hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                            Batal
                        </a>
                        
                        {{-- Mobile Only Delete Button --}}
                        <button type="button" @click="if(confirm('Yakin ingin menghapus?')) document.getElementById('delete-form').submit()" 
                            class="sm:hidden w-full py-4 rounded-2xl border border-rose-200 dark:border-rose-900/50 text-rose-600 dark:text-rose-400 font-bold hover:bg-rose-50 dark:hover:bg-rose-900/10 transition-colors">
                            Hapus Tugas
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Hidden Delete Form --}}
        <form id="delete-form" action="{{ route('teacher.assignments.destroy', [$classroom, $assignment]) }}" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </div>
</div>
@endsection