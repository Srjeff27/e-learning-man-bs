@extends('layouts.student')

@section('title', $assignment->title)

@section('content')
<div class="max-w-7xl mx-auto space-y-8 animate-fade-in-up">
    
    <div>
        <a href="{{ route('student.classrooms.show', $classroom) }}" 
           class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium text-slate-600 dark:text-slate-300 bg-white/50 dark:bg-slate-800/50 backdrop-blur-md border border-white/20 dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 transition-all duration-300 group">
            <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>Kembali ke {{ $classroom->name }}</span>
        </a>
    </div>

    <div class="grid lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-8">
            
            <div class="relative overflow-hidden rounded-3xl bg-white/70 dark:bg-slate-900/60 backdrop-blur-xl border border-white/20 dark:border-slate-700 shadow-xl p-8">
                <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-gradient-to-br from-blue-500/20 to-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div>
                            <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-slate-900 to-slate-600 dark:from-white dark:to-slate-300 leading-tight">
                                {{ $assignment->title }}
                            </h1>
                            <div class="flex items-center gap-2 mt-2 text-sm text-slate-500 dark:text-slate-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    {{ $classroom->name }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm border
                                {{ $assignment->isOverdue() 
                                    ? 'bg-red-50 text-red-600 border-red-100 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800' 
                                    : 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800' }}">
                                <span class="w-2 h-2 rounded-full mr-2 {{ $assignment->isOverdue() ? 'bg-red-500 animate-pulse' : 'bg-emerald-500' }}"></span>
                                {{ $assignment->isOverdue() ? 'Terlambat' : 'Aktif' }}
                            </span>
                        </div>
                    </div>

                    @if($assignment->description)
                        <div class="prose prose-slate dark:prose-invert max-w-none prose-p:leading-relaxed prose-a:text-blue-600 hover:prose-a:text-blue-500 transition-colors">
                            {!! nl2br(e($assignment->description)) !!}
                        </div>
                    @endif

                    @if($assignment->instructions)
                        <div class="mt-8 p-5 rounded-2xl bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/30">
                            <div class="flex items-start gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-800/50 rounded-lg text-blue-600 dark:text-blue-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-800 dark:text-slate-200 mb-1">Petunjuk Pengerjaan</h3>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                                        {!! nl2br(e($assignment->instructions)) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if(!$submission || $submission->status === 'draft')
                <div class="rounded-3xl bg-white/70 dark:bg-slate-900/60 backdrop-blur-xl border border-white/20 dark:border-slate-700 shadow-xl overflow-hidden relative">
                    <div class="p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2.5 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg shadow-blue-500/30 text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800 dark:text-white">Kumpulkan Tugas</h2>
                        </div>

                        <form action="{{ route('student.assignments.submit', [$classroom, $assignment]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                            @csrf

                            @if(in_array($assignment->submission_type, ['text', 'multiple']))
                                <div class="group">
                                    <label for="content" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 ml-1">Jawaban Teks</label>
                                    <div class="relative">
                                        <textarea id="content" name="content" rows="6" 
                                            class="w-full rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all p-4 text-slate-700 dark:text-slate-200 placeholder:text-slate-400 resize-none"
                                            placeholder="Ketikan jawaban lengkap Anda di sini...">{{ old('content', $submission->content ?? '') }}</textarea>
                                    </div>
                                    @error('content') <p class="mt-2 text-sm text-rose-500 flex items-center gap-1"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>{{ $message }}</p> @enderror
                                </div>
                            @endif

                            @if(in_array($assignment->submission_type, ['file', 'multiple']))
                                <div>
                                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 ml-1">Upload File</label>
                                    <label class="relative flex flex-col items-center justify-center w-full h-32 rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-600 hover:border-blue-500 dark:hover:border-blue-400 bg-slate-50 dark:bg-slate-800/30 hover:bg-blue-50/50 dark:hover:bg-slate-800/60 transition-all cursor-pointer group">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-8 h-8 mb-3 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            <p class="text-sm text-slate-500 dark:text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        </div>
                                        <input type="file" id="file" name="file" class="hidden" onchange="document.getElementById('file-name').innerText = this.files[0].name" />
                                    </label>
                                    <p id="file-name" class="mt-2 text-sm text-blue-600 dark:text-blue-400 font-medium ml-1">
                                        @if($submission && $submission->file_name) File tersimpan: {{ $submission->file_name }} @endif
                                    </p>
                                    @error('file') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            @if(in_array($assignment->submission_type, ['link', 'multiple']))
                                <div>
                                    <label for="external_link" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2 ml-1">Link Eksternal</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        </div>
                                        <input type="url" id="external_link" name="external_link" value="{{ old('external_link', $submission->external_link ?? '') }}" 
                                            class="w-full pl-11 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all p-3 text-slate-700 dark:text-slate-200"
                                            placeholder="https://docs.google.com/...">
                                    </div>
                                    @error('external_link') <p class="mt-2 text-sm text-rose-500">{{ $message }}</p> @enderror
                                </div>
                            @endif

                            <div class="pt-6 border-t border-slate-100 dark:border-slate-800">
                                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transform hover:-translate-y-0.5 transition-all duration-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Kirim Tugas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="rounded-3xl bg-white/70 dark:bg-slate-900/60 backdrop-blur-xl border border-white/20 dark:border-slate-700 shadow-xl overflow-hidden">
                    <div class="p-8">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="p-2.5 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <h2 class="text-xl font-bold text-slate-800 dark:text-white">Status Pengumpulan</h2>
                            </div>
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold border
                                {{ $submission->status === 'graded' 
                                    ? 'bg-emerald-50 text-emerald-600 border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800' 
                                    : 'bg-blue-50 text-blue-600 border-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800' }}">
                                {{ $submission->status === 'graded' ? 'Sudah Dinilai' : 'Menunggu Penilaian' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Waktu Submit</p>
                                    <p class="text-slate-700 dark:text-slate-200 font-medium">{{ $submission->submitted_at->format('d M Y, H:i') }} WIB</p>
                                </div>
                                
                                @if($submission->is_late)
                                    <div class="p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/20 border border-rose-100 dark:border-rose-800">
                                        <p class="text-xs font-bold text-rose-400 uppercase tracking-wider mb-1">Status Keterlambatan</p>
                                        <p class="text-rose-600 dark:text-rose-400 font-bold">Terlambat</p>
                                    </div>
                                @endif
                            </div>

                            @if($submission->status === 'graded')
                                <div class="relative p-6 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/20 overflow-hidden">
                                    <div class="absolute top-0 right-0 -mt-8 -mr-8 w-24 h-24 bg-white/20 rounded-full blur-2xl"></div>
                                    <div class="relative z-10 text-center">
                                        <p class="text-emerald-100 text-sm font-medium mb-1">Nilai Akhir</p>
                                        <div class="text-4xl font-extrabold tracking-tight">
                                            {{ $submission->score }}<span class="text-2xl text-emerald-100/70 font-semibold">/{{ $assignment->max_score }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($submission->feedback)
                            <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800">
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                    Catatan Guru
                                </h3>
                                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-5 border border-slate-100 dark:border-slate-700 italic text-slate-600 dark:text-slate-300">
                                    "{{ $submission->feedback }}"
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="lg:col-span-4 space-y-6">
            <div class="sticky top-24 rounded-3xl bg-white/70 dark:bg-slate-900/60 backdrop-blur-xl border border-white/20 dark:border-slate-700 shadow-xl p-6">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Informasi Tugas
                </h3>
                
                <div class="space-y-5">
                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="p-2.5 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Tenggat Waktu</p>
                            <p class="font-semibold {{ $assignment->isOverdue() ? 'text-rose-600 dark:text-rose-400' : 'text-slate-700 dark:text-slate-200' }}">
                                {{ $assignment->due_date ? $assignment->due_date->format('d M Y, H:i') : 'Tanpa Batas' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="p-2.5 rounded-xl bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Poin Maksimal</p>
                            <p class="font-semibold text-slate-700 dark:text-slate-200">{{ $assignment->max_score }} Poin</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="p-2.5 rounded-xl bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Tipe Jawaban</p>
                            <p class="font-semibold text-slate-700 dark:text-slate-200 capitalize">{{ ucfirst($assignment->submission_type) }}</p>
                        </div>
                    </div>

                    @if($assignment->allow_late_submission)
                        <div class="flex items-start gap-4 p-3 rounded-2xl hover:bg-white/50 dark:hover:bg-slate-800/50 transition-colors">
                            <div class="p-2.5 rounded-xl bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wide">Denda Keterlambatan</p>
                                <p class="font-semibold text-rose-600 dark:text-rose-400">{{ $assignment->late_penalty_percent }}% Pengurangan</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Animations */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
@endsection