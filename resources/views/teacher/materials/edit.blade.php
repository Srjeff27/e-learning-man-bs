@extends('layouts.teacher')

@section('title', 'Edit Materi')

@push('styles')
<style>
    /* Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shine { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }

    .animate-enter { animation: slideUpFade 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }

    /* Glass Effect & Glossy Inputs */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
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
</style>
{{-- Load AlpineJS for interactivity --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[100px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[600px] h-[600px] bg-teal-400/20 rounded-full blur-[100px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10" x-data="{ type: '{{ old('type', $material->type) }}' }">
        
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 animate-enter">
            <div>
                <a href="{{ route('teacher.materials.show', [$classroom, $material]) }}" 
                   class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors mb-2 group">
                    <svg class="w-4 h-4 mr-1 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Detail
                </a>
                <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-white">
                    Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-500 to-teal-400">Materi</span>
                </h1>
            </div>
            
            {{-- Delete Button (Top Action) --}}
            <form action="{{ route('teacher.materials.destroy', [$classroom, $material]) }}" method="POST"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini? Data tidak dapat dikembalikan.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="group flex items-center gap-2 px-4 py-2 rounded-xl text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all font-bold text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    <span>Hapus Materi</span>
                </button>
            </form>
        </div>

        {{-- Main Form --}}
        <form action="{{ route('teacher.materials.update', [$classroom, $material]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="glass-panel rounded-3xl p-6 sm:p-10 animate-enter delay-100 space-y-8">
                
                {{-- Judul --}}
                <div class="space-y-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Judul Materi <span class="text-emerald-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $material->title) }}" 
                           class="input-glossy w-full px-5 py-4 rounded-xl text-lg font-bold text-slate-900 dark:text-white placeholder-slate-400"
                           placeholder="Contoh: Pengenalan Aljabar" required>
                    @error('title') <p class="text-rose-500 text-sm mt-1 font-medium">{{ $message }}</p> @enderror
                </div>

                {{-- Tipe Materi (Radio Cards) --}}
                <div class="space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tipe Materi</label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @php
                            $types = [
                                ['val' => 'text', 'label' => 'Artikel', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                ['val' => 'file', 'label' => 'File', 'icon' => 'M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12'],
                                ['val' => 'video', 'label' => 'Video', 'icon' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z'],
                                ['val' => 'link', 'label' => 'Link', 'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
                            ];
                        @endphp
                        
                        @foreach($types as $t)
                        <label class="cursor-pointer group">
                            <input type="radio" name="type" value="{{ $t['val'] }}" x-model="type" class="sr-only peer">
                            <div class="relative p-3 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white/40 dark:bg-slate-800/40 hover:bg-white dark:hover:bg-slate-800 transition-all duration-300 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-500/10 peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 flex flex-col items-center gap-2">
                                <svg class="w-6 h-6 text-slate-400 peer-checked:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $t['icon'] }}"/></svg>
                                <span class="text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">{{ $t['label'] }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Dynamic Content Area --}}
                <div class="relative min-h-[120px]">
                    
                    {{-- 1. Text Content --}}
                    <div x-show="type === 'text'" x-transition.opacity.duration.300ms>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Konten Materi</label>
                        <textarea name="content" rows="8" 
                            class="input-glossy w-full px-5 py-4 rounded-xl text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none resize-none"
                            placeholder="Tulis konten materi di sini...">{{ old('content', $material->content) }}</textarea>
                    </div>

                    {{-- 2. File Upload --}}
                    <div x-show="type === 'file'" x-transition.opacity.duration.300ms>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Upload File Baru</label>
                        
                        @if($material->file_path)
                            <div class="flex items-center p-3 mb-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl">
                                <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span class="text-sm text-emerald-700 dark:text-emerald-300 font-medium truncate">File saat ini: {{ $material->file_name ?? basename($material->file_path) }}</span>
                            </div>
                        @endif

                        <div class="relative group">
                            <input type="file" name="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                            <div class="w-full h-32 rounded-xl border-2 border-dashed border-slate-300 dark:border-slate-600 bg-slate-50/50 dark:bg-slate-800/50 flex flex-col items-center justify-center gap-2 group-hover:border-emerald-400 group-hover:bg-emerald-50/30 dark:group-hover:bg-emerald-900/10 transition-all">
                                <span class="text-sm font-bold text-slate-600 dark:text-slate-300">Klik atau Drag file baru ke sini</span>
                                <span class="text-xs text-slate-400">Maksimal 10MB</span>
                            </div>
                        </div>
                        @error('file') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- 3. Link / Video --}}
                    <div x-show="type === 'link' || type === 'video'" x-transition.opacity.duration.300ms>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2" x-text="type === 'video' ? 'Link Youtube' : 'Link Eksternal'"></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-slate-400 font-bold text-sm">https://</span>
                            </div>
                            <input type="url" name="external_link" value="{{ old('external_link', $material->external_link) }}" 
                                   class="input-glossy w-full pl-20 pr-4 py-4 rounded-xl text-slate-800 dark:text-white font-medium"
                                   placeholder="www.example.com">
                        </div>
                        @error('external_link') <p class="text-rose-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="w-full h-px bg-slate-200 dark:bg-slate-700/50"></div>

                {{-- Footer: Publish & Actions --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                    
                    {{-- Toggle Publish --}}
                    <div class="flex items-center gap-3 w-full sm:w-auto p-3 bg-white/40 dark:bg-slate-800/40 rounded-xl border border-slate-100 dark:border-slate-700">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', $material->is_published) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-500 shadow-inner"></div>
                        </label>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200">Publikasikan</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <a href="{{ route('teacher.materials.show', [$classroom, $material]) }}" 
                           class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-center">
                            Batal
                        </a>
                        <button type="submit" 
                                class="w-full sm:w-auto relative group overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-px shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 hover:-translate-y-0.5">
                            <div class="relative px-8 py-3.5 bg-transparent flex items-center justify-center gap-2 overflow-hidden rounded-xl">
                                <div class="absolute inset-0 bg-white/0 group-hover:bg-white/10 transition-colors duration-300"></div>
                                {{-- Shine Effect --}}
                                <div class="absolute inset-0 -translate-x-full group-hover:animate-[shine_1.5s_infinite] bg-gradient-to-r from-transparent via-white/25 to-transparent z-10"></div>
                                
                                <span class="font-bold text-white tracking-wide relative z-20">Simpan Perubahan</span>
                                <svg class="w-5 h-5 text-white relative z-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection