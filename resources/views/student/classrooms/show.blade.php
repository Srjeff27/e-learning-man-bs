@extends('layouts.student')

@section('title', $classroom->name)

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50/30 to-white dark:from-slate-900 dark:to-slate-800" 
     x-data="{ 
         selectedMaterial: {{ $classroom->materials->first() ? $classroom->materials->first()->id : 'null' }},
         materials: {{ $classroom->materials->toJson() }},
         getMaterial() {
             return this.materials.find(m => m.id === this.selectedMaterial);
         }
     }">
    
    {{-- Header --}}
    <div class="glass-card border-b border-white/20 dark:border-slate-700/50 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('student.classrooms.index') }}" 
                       class="relative p-2 rounded-xl bg-gradient-to-br from-white/80 to-slate-100 dark:from-slate-800 dark:to-slate-900 shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                    </a>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-lg">{{ substr($classroom->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-slate-900 dark:text-white">{{ $classroom->name }}</h1>
                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $classroom->subject ?? 'Mata Pelajaran' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $classroom->teacher->name }}</p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Pengajar</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-6 animate-fade-in">
            {{-- Left Sidebar --}}
            <div class="lg:col-span-4 space-y-6">
                {{-- Deskripsi Kursus --}}
                <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6 shadow-xl shadow-blue-500/5">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center mr-3 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="font-bold text-slate-900 dark:text-white">Deskripsi Kursus</h2>
                    </div>
                    
                    @if($classroom->subject)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/30 dark:to-cyan-900/30 dark:text-blue-300 mb-3 shadow-sm">
                            🏷️ {{ $classroom->subject }}
                        </span>
                    @endif
                    
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                        {{ $classroom->description ?? 'Pelajari materi ' . $classroom->subject . ' dengan berbagai modul pembelajaran interaktif. Kelas ini akan membahas dasar-dasar hingga materi lanjutan.' }}
                    </p>
                    
                    <div class="pt-4 border-t border-slate-200/50 dark:border-slate-700/30">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-600 dark:text-slate-400">Tahun Ajaran</span>
                            <span class="font-medium text-slate-900 dark:text-white">{{ $classroom->academic_year ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm mt-2">
                            <span class="text-slate-600 dark:text-slate-400">Semester</span>
                            <span class="font-medium text-slate-900 dark:text-white capitalize">{{ $classroom->semester ?? '-' }}</span>
                        </div>
                    </div>
                </div>

                {{-- Materi Pelajaran --}}
                <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6 shadow-xl shadow-blue-500/5">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center mr-3 shadow-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                                </svg>
                            </div>
                            <h2 class="font-bold text-slate-900 dark:text-white">Materi Pelajaran</h2>
                        </div>
                        <span class="px-3 py-1 text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/30 dark:to-cyan-900/30 dark:text-blue-300 rounded-full">
                            {{ $classroom->materials->count() }} Materi
                        </span>
                    </div>
                    
                    <div class="space-y-2">
                        @forelse($classroom->materials as $index => $material)
                            <button 
                                @click="selectedMaterial = {{ $material->id }}"
                                :class="selectedMaterial === {{ $material->id }} ? 
                                    'bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 border-blue-200 dark:border-blue-700/50' : 
                                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 border-transparent hover:border-blue-200 dark:hover:border-blue-700/50'"
                                class="w-full flex items-center justify-between p-4 rounded-xl border transition-all duration-300 text-left group hover:shadow-md">
                                <div class="flex items-center">
                                    <div class="relative mr-3">
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center"
                                            :class="selectedMaterial === {{ $material->id }} ? 
                                                'bg-gradient-to-br from-blue-500 to-cyan-400' : 
                                                'bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700'">
                                            @if($material->type === 'file' || $material->type === 'text')
                                                <svg class="w-5 h-5" :class="selectedMaterial === {{ $material->id }} ? 'text-white' : 'text-blue-500 dark:text-blue-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            @elseif($material->type === 'video')
                                                <svg class="w-5 h-5" :class="selectedMaterial === {{ $material->id }} ? 'text-white' : 'text-red-500 dark:text-red-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5" :class="selectedMaterial === {{ $material->id }} ? 'text-white' : 'text-purple-500 dark:text-purple-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                            @endif
                                        </div>
                                        @if($index === 0)
                                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full flex items-center justify-center">
                                                <svg class="w-2 h-2 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-slate-900 dark:text-white mb-1 line-clamp-1">{{ $material->title }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">
                                            @if($material->type === 'video') Video @elseif($material->type === 'file') File @else Link @endif
                                            • {{ $material->created_at->format('d M') }}
                                        </p>
                                    </div>
                                </div>
                                <svg class="w-5 h-5 text-green-500 transform transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        @empty
                            <div class="text-center py-8">
                                <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 dark:text-slate-400 text-sm">Belum ada materi</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Main Content Area --}}
            <div class="lg:col-span-8">
                @if($classroom->materials->isNotEmpty())
                    {{-- Material Viewer --}}
                    @foreach($classroom->materials as $material)
                        <div x-show="selectedMaterial === {{ $material->id }}" x-cloak class="space-y-6 animate-slide-up">
                            {{-- Material Header --}}
                            <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6 shadow-xl shadow-blue-500/5">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6">
                                    <div class="flex items-center space-x-3 mb-4 sm:mb-0">
                                        @if($material->type === 'file' || $material->type === 'text')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-500 to-cyan-400 text-white shadow-lg">
                                                📘 EBOOK
                                            </span>
                                        @elseif($material->type === 'video')
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-red-500 to-pink-400 text-white shadow-lg">
                                                🎬 VIDEO
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-purple-500 to-pink-400 text-white shadow-lg">
                                                🔗 LINK
                                            </span>
                                        @endif
                                        <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $material->title }}</h3>
                                    </div>
                                    <button class="relative group/complete inline-flex items-center px-4 py-2 rounded-xl bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/20 text-emerald-700 dark:text-emerald-300 font-semibold text-sm hover:shadow-lg transition-all duration-300">
                                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/20 to-green-500/10 rounded-xl opacity-0 group-hover/complete:opacity-100 transition-opacity duration-300"></div>
                                        <svg class="relative w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="relative">Selesai Dipelajari</span>
                                    </button>
                                </div>

                                {{-- Content Viewer --}}
                                @if($material->type === 'video' && $material->external_link)
                                    <div class="relative aspect-video bg-gradient-to-br from-gray-900 to-black rounded-2xl overflow-hidden shadow-2xl">
                                        @if(str_contains($material->external_link, 'youtube') || str_contains($material->external_link, 'youtu.be'))
                                            @php
                                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $material->external_link, $matches);
                                                $videoId = $matches[1] ?? '';
                                            @endphp
                                            <iframe 
                                                src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&modestbranding=1"
                                                class="absolute inset-0 w-full h-full"
                                                frameborder="0" 
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                allowfullscreen>
                                            </iframe>
                                        @else
                                            <iframe src="{{ $material->external_link }}" class="absolute inset-0 w-full h-full" frameborder="0"></iframe>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                                    </div>
                                @elseif($material->file_path)
                                    @php
                                        $extension = pathinfo($material->file_name ?? $material->file_path, PATHINFO_EXTENSION);
                                    @endphp
                                    @if(in_array(strtolower($extension), ['pdf']))
                                        <div class="relative aspect-[4/3] bg-gradient-to-br from-gray-900 to-black rounded-2xl overflow-hidden shadow-2xl">
                                            <iframe 
                                                src="{{ Storage::url($material->file_path) }}#toolbar=0&navpanes=0&scrollbar=0" 
                                                class="absolute inset-0 w-full h-full"
                                                frameborder="0">
                                            </iframe>
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <a href="{{ Storage::url($material->file_path) }}" target="_blank" 
                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 text-blue-600 dark:text-blue-400 font-medium text-sm hover:shadow-lg transition-all duration-300">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                                Buka di Tab Baru
                                            </a>
                                        </div>
                                    @else
                                        <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-8 text-center">
                                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-2xl">
                                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <p class="text-slate-900 dark:text-white font-medium mb-2">{{ $material->file_name }}</p>
                                            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">Ukuran: {{ round(filesize(storage_path('app/public/' . $material->file_path)) / 1024 / 1024, 2) }} MB</p>
                                            <a href="{{ Storage::url($material->file_path) }}" target="_blank" 
                                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Download File
                                            </a>
                                        </div>
                                    @endif
                                @elseif($material->external_link)
                                    <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6">
                                        <div class="flex items-center mb-4">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-500 to-pink-400 flex items-center justify-center mr-3 shadow-lg">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-medium text-slate-900 dark:text-white">Link Materi Eksternal</p>
                                                <p class="text-sm text-slate-600 dark:text-slate-400">Klik untuk mengakses</p>
                                            </div>
                                        </div>
                                        <a href="{{ $material->external_link }}" target="_blank" 
                                           class="block p-4 bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-600 transition-colors duration-300 break-all">
                                            <span class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">{{ $material->external_link }}</span>
                                        </a>
                                    </div>
                                @elseif($material->content)
                                    <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6">
                                        <div class="prose prose-slate dark:prose-invert max-w-none">
                                            {!! nl2br(e($material->content)) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            {{-- Tugas Terkait Materi --}}
                            <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6 shadow-xl shadow-blue-500/5">
                                <div class="flex items-center mb-6">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center mr-3 shadow-lg">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                    </div>
                                    <h3 class="font-bold text-slate-900 dark:text-white">Tugas Terkait</h3>
                                </div>
                                
                                @if($assignments->isNotEmpty())
                                    <div class="space-y-3">
                                        @foreach($assignments as $assignment)
                                            <a href="{{ route('student.assignments.show', [$classroom, $assignment]) }}"
                                               class="group block glass-card rounded-xl border border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-600 p-5 transition-all duration-300 hover:shadow-lg">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex-1">
                                                        <div class="flex items-center mb-2">
                                                            <h4 class="font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $assignment->title }}</h4>
                                                            @if($assignment->due_date)
                                                                <span class="ml-3 px-2 py-1 text-xs font-semibold {{ $assignment->due_date->isPast() ? 'bg-gradient-to-r from-red-100 to-pink-100 text-red-700 dark:from-red-900/30 dark:to-pink-900/30 dark:text-red-300' : 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 dark:from-emerald-900/30 dark:to-green-900/30 dark:text-emerald-300' }} rounded-full">
                                                                    {{ $assignment->due_date->isPast() ? 'Terlambat' : 'Deadline: ' . $assignment->due_date->format('d M') }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if($assignment->description)
                                                            <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{{ $assignment->description }}</p>
                                                        @endif
                                                    </div>
                                                    <svg class="w-5 h-5 text-slate-400 group-hover:text-blue-500 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                    </svg>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-8">
                                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-slate-100 to-slate-200 dark:from-slate-800 dark:to-slate-700 rounded-xl flex items-center justify-center">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 dark:text-slate-400 text-sm">Tidak ada tugas terkait materi ini</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Empty State --}}
                    <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-12 text-center animate-fade-in">
                        <div class="max-w-md mx-auto">
                            <div class="relative">
                                <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-3xl blur-xl"></div>
                                <div class="relative">
                                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-2xl">
                                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">Belum ada materi</h3>
                                    <p class="text-slate-600 dark:text-slate-400 mb-6">Guru akan segera menambahkan materi pembelajaran untuk kelas ini</p>
                                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 rounded-xl text-blue-600 dark:text-blue-400 text-sm font-semibold">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Periksa kembali nanti
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
    
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
    
    .animate-slide-up {
        animation: slide-up 0.5s ease-out;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.7);
    }
    
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .prose {
        color: #334155;
    }
    
    .dark .prose {
        color: #cbd5e1;
    }
    
    .prose p {
        margin-bottom: 1em;
    }
    
    .prose p:last-child {
        margin-bottom: 0;
    }
</style>
@endsection