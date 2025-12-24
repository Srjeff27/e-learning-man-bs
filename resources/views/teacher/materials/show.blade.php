@extends('layouts.teacher')

@section('title', $material->title)

@push('styles')
<style>
    /* Animations */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes pulse-glow { 0%, 100% { opacity: 0.5; } 50% { opacity: 1; } }

    .animate-enter { animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }

    /* Glass Panels */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 32px rgba(16, 185, 129, 0.05);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
    }

    /* Glossy Buttons & Cards */
    .card-glossy {
        background: linear-gradient(145deg, rgba(255,255,255,0.6) 0%, rgba(255,255,255,0.3) 100%);
        border: 1px solid rgba(255,255,255,0.4);
        transition: all 0.3s ease;
    }
    .dark .card-glossy {
        background: linear-gradient(145deg, rgba(30, 41, 59, 0.6) 0%, rgba(30, 41, 59, 0.3) 100%);
        border: 1px solid rgba(255,255,255,0.05);
    }
    .card-glossy:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.1);
        border-color: rgba(16, 185, 129, 0.4);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-500">
    
    {{-- Ambient Background Effects --}}
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute top-[-10%] left-[-5%] w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[120px] dark:bg-emerald-600/10 mix-blend-multiply dark:mix-blend-screen"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[500px] h-[500px] bg-teal-400/20 rounded-full blur-[120px] dark:bg-teal-600/10 mix-blend-multiply dark:mix-blend-screen"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10">
        
        {{-- Navigation Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 animate-enter">
            <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
               class="group inline-flex items-center text-sm font-bold text-slate-500 hover:text-emerald-600 dark:text-slate-400 dark:hover:text-emerald-400 transition-colors">
                <div class="w-8 h-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center mr-2 shadow-sm group-hover:shadow-md transition-all group-hover:-translate-x-1 text-emerald-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke {{ $classroom->name }}
            </a>

            <a href="{{ route('teacher.materials.edit', [$classroom, $material]) }}" 
               class="relative group overflow-hidden rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-5 py-2.5 font-bold text-sm shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 dark:via-slate-900/10 to-transparent -translate-x-full group-hover:animate-[shine_1s_infinite]"></div>
                <span class="relative flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit Materi
                </span>
            </a>
        </div>

        {{-- Main Content Card --}}
        <div class="glass-panel rounded-3xl p-8 sm:p-10 animate-enter delay-100">
            
            {{-- Title & Metadata --}}
            <div class="border-b border-slate-200 dark:border-slate-700/50 pb-6 mb-8">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    {{-- Type Badge --}}
                    @php
                        $typeColors = [
                            'text' => 'bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 border-blue-200 dark:border-blue-500/20',
                            'file' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20',
                            'video' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400 border-rose-200 dark:border-rose-500/20',
                            'link' => 'bg-purple-100 text-purple-700 dark:bg-purple-500/10 dark:text-purple-400 border-purple-200 dark:border-purple-500/20',
                        ];
                        $iconMap = [
                            'text' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                            'file' => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
                            'video' => 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z',
                            'link' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1',
                        ];
                        $colorClass = $typeColors[$material->type] ?? $typeColors['text'];
                        $iconPath = $iconMap[$material->type] ?? $iconMap['text'];
                    @endphp

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $colorClass }}">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/></svg>
                        {{ ucfirst($material->type) }}
                    </span>

                    {{-- Status Badge --}}
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $material->is_published ? 'bg-teal-100 text-teal-700 border-teal-200 dark:bg-teal-500/10 dark:text-teal-400 dark:border-teal-500/20' : 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-700 dark:text-slate-400' }}">
                        <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $material->is_published ? 'bg-teal-500 animate-pulse' : 'bg-slate-400' }}"></span>
                        {{ $material->is_published ? 'Terpublikasi' : 'Draft Mode' }}
                    </span>
                </div>

                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-tight mb-3">
                    {{ $material->title }}
                </h1>
                
                <div class="flex items-center text-sm text-slate-500 dark:text-slate-400 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Dibuat pada {{ $material->created_at->format('d F Y, H:i') }}
                </div>
            </div>

            {{-- Text Content --}}
            @if($material->content)
                <div class="prose prose-lg prose-slate dark:prose-invert max-w-none mb-10 leading-relaxed animate-enter delay-200">
                    {!! nl2br(e($material->content)) !!}
                </div>
            @endif

            {{-- Attachments Section --}}
            <div class="space-y-4 animate-enter delay-300">
                
                {{-- File Attachment --}}
                @if($material->file_path)
                    <div class="card-glossy rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 group">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 dark:text-white text-lg group-hover:text-emerald-600 transition-colors">{{ $material->file_name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">Dokumen Lampiran</p>
                            </div>
                        </div>
                        <a href="{{ Storage::url($material->file_path) }}" target="_blank" 
                           class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-500/30 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Download
                        </a>
                    </div>
                @endif

                {{-- External Link --}}
                @if($material->external_link)
                    <div class="card-glossy rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 group">
                        <div class="flex items-center gap-4 overflow-hidden">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/30 dark:to-indigo-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </div>
                            <div class="min-w-0">
                                <h3 class="font-bold text-slate-800 dark:text-white text-lg group-hover:text-blue-600 transition-colors">Referensi Eksternal</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 truncate">{{ $material->external_link }}</p>
                            </div>
                        </div>
                        <a href="{{ $material->external_link }}" target="_blank" 
                           class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                            Buka Link
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
@endsection