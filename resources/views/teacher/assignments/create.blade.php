@extends('layouts.teacher')

@section('title', 'Buat Tugas Baru')

@push('styles')
{{-- Optimasi: DNS Prefetch --}}
<link rel="dns-prefetch" href="//cdn.jsdelivr.net">
<link rel="dns-prefetch" href="//npmcdn.com">

{{-- Styles --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">

<style>
    /* CSS disederhanakan untuk rendering lebih cepat */
    @keyframes slideUpFade { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    @keyframes shine { 0% { transform: translateX(-100%); } 100% { transform: translateX(100%); } }

    .animate-enter { animation: slideUpFade 0.4s ease-out forwards; opacity: 0; }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.15s; }

    /* Glass Effect (Backdrop filter bisa berat di HP low-end, dioptimalkan opacity-nya) */
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }

    /* Input Styling */
    .input-glossy {
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid rgba(209, 213, 219, 0.5);
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    .dark .input-glossy {
        background: rgba(30, 41, 59, 0.5);
        border: 1px solid rgba(71, 85, 105, 0.5);
    }
    .input-glossy:focus {
        background: rgba(255, 255, 255, 0.95);
        border-color: #10B981;
        outline: none;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    
    /* Flatpickr Customization */
    .flatpickr-calendar {
        border-radius: 12px !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1) !important;
        border: none !important;
    }
    .dark .flatpickr-calendar {
        background: #1e293b !important;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5) !important;
    }
</style>
{{-- Alpine JS (Deferred) --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div class="min-h-screen py-10 px-4 sm:px-6 lg:px-8 bg-[#F0FDF4] dark:bg-[#0B1120] relative overflow-hidden transition-colors duration-300">
    
    {{-- Background blobs (Static CSS is faster than JS animations) --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-[10%] -left-[10%] w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-[80px] dark:bg-emerald-600/10"></div>
        <div class="absolute -bottom-[10%] -right-[10%] w-[500px] h-[500px] bg-teal-400/20 rounded-full blur-[80px] dark:bg-teal-600/10"></div>
    </div>

    <div class="max-w-5xl mx-auto relative z-10" x-data="assignmentForm()">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
            <div>
                <span class="inline-block px-3 py-1 mb-2 text-xs font-bold tracking-wider text-emerald-700 bg-emerald-100 rounded-full dark:bg-emerald-500/10 dark:text-emerald-400 uppercase">
                    Academic Workspace
                </span>
                <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white">
                    Buat Tugas <span class="text-emerald-500">Baru</span>
                </h1>
                <p class="mt-1 text-slate-500 dark:text-slate-400 font-medium">
                    Kelas: <span class="text-slate-800 dark:text-slate-200 font-bold">{{ $classroom->name }}</span>
                </p>
            </div>

            <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 font-bold text-white transition-colors bg-slate-900 rounded-xl hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('teacher.assignments.store', $classroom) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                
                {{-- Main Column --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- General Info Card --}}
                    <div class="glass-panel rounded-2xl p-6 md:p-8 animate-enter delay-100 relative group overflow-hidden">
                        <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="p-3 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </div>
                            <h2 class="text-xl font-bold text-slate-800 dark:text-white">Informasi Dasar</h2>
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Judul Tugas <span class="text-red-500">*</span></label>
                                <input type="text" name="title" value="{{ old('title') }}" 
                                       class="input-glossy w-full px-4 py-3 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 text-lg font-medium"
                                       placeholder="Contoh: Analisis Jaringan" required>
                                @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                                <textarea name="description" rows="4" 
                                          class="input-glossy w-full px-4 py-3 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 resize-none"
                                          placeholder="Jelaskan gambaran umum...">{{ old('description') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Instruksi Teknis</label>
                                <textarea name="instructions" rows="4" 
                                          class="input-glossy w-full px-4 py-3 rounded-xl text-slate-900 dark:text-white placeholder-slate-400 resize-none font-mono text-sm"
                                          placeholder="1. Unduh dataset...">{{ old('instructions') }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Submission Type Card --}}
                    <div class="glass-panel rounded-2xl p-6 md:p-8 animate-enter delay-200">
                        <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Metode Pengumpulan</h2>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @php
                                $types = [
                                    ['val' => 'file', 'label' => 'File Upload', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                    ['val' => 'text', 'label' => 'Text Entry', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                                    ['val' => 'link', 'label' => 'URL Link', 'icon' => 'M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1'],
                                    ['val' => 'multiple', 'label' => 'Hybrid', 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                                ];
                            @endphp

                            @foreach($types as $type)
                            <label class="cursor-pointer">
                                <input type="radio" name="submission_type" value="{{ $type['val'] }}" class="peer sr-only" {{ old('submission_type', 'file') == $type['val'] ? 'checked' : '' }}>
                                <div class="p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 hover:bg-white dark:hover:bg-slate-800 transition-all peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 peer-checked:border-emerald-500 peer-checked:ring-1 peer-checked:ring-emerald-500 flex flex-col items-center gap-2 text-center h-full">
                                    <svg class="w-5 h-5 text-slate-500 dark:text-slate-400 peer-checked:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $type['icon'] }}"/></svg>
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300 peer-checked:text-emerald-700 dark:peer-checked:text-emerald-400">{{ $type['label'] }}</span>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Sidebar: Settings --}}
                <div class="glass-panel rounded-2xl p-6 h-fit">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Pengaturan
                    </h3>

                    {{-- Due Date (ICON DIHAPUS DISINI) --}}
                    <div class="mb-5">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Deadline</label>
                        <div class="relative">
                            {{-- PADDING DIPERBAIKI: px-4 agar rata kiri biasa --}}
                            <input type="text" id="datepicker" 
                                   class="input-glossy w-full py-3 px-4 rounded-xl text-sm font-semibold text-slate-800 dark:text-white cursor-pointer placeholder:text-slate-400 focus:ring-2 focus:ring-emerald-500/20" 
                                   placeholder="Pilih Tanggal & Waktu">
                            <input type="hidden" name="due_date" id="real_date" value="{{ old('due_date') }}">
                        </div>
                    </div>

                    {{-- Max Score --}}
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nilai Maksimal</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                                <span class="text-xs font-extrabold text-slate-400 tracking-wider">POIN</span>
                            </div>
                            <input type="number" name="max_score" value="{{ old('max_score', 100) }}" 
                                   class="input-glossy w-full py-3 pl-16 pr-4 text-center rounded-xl text-2xl font-black text-slate-800 dark:text-white tracking-widest"
                                   min="0" max="100">
                        </div>
                    </div>

                    <div class="w-full h-px bg-slate-200 dark:bg-slate-700 my-5"></div>

                    {{-- Toggles --}}
                    <div class="space-y-4">
                        {{-- Publish --}}
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="block text-sm font-bold text-slate-800 dark:text-white">Publikasikan</span>
                                <span class="text-xs text-slate-500">Siswa dapat melihat</span>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_published" value="1" class="sr-only peer" {{ old('is_published', true) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:bg-emerald-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                            </label>
                        </div>

                        {{-- Late Submission --}}
                        <div x-data="{ open: {{ old('allow_late_submission') ? 'true' : 'false' }} }">
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <span class="block text-sm font-bold text-slate-800 dark:text-white">Terima Terlambat</span>
                                    <span class="text-xs text-slate-500">Izinkan lewat deadline</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="allow_late_submission" value="1" class="sr-only peer" x-model="open">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:bg-amber-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </label>
                            </div>
                            <div x-show="open" x-collapse style="display: none;">
                                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-100 dark:border-amber-800/30">
                                    <label class="block text-xs font-bold text-amber-700 dark:text-amber-400 mb-1">Denda (%)</label>
                                    <input type="number" name="late_penalty_percent" value="{{ old('late_penalty_percent', 10) }}"
                                           class="w-full bg-white dark:bg-slate-800 border border-amber-200 dark:border-amber-700 rounded-md px-2 py-1.5 text-sm font-bold text-amber-600 dark:text-amber-400 focus:outline-none focus:ring-1 focus:ring-amber-400">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                            class="mt-6 w-full relative group overflow-hidden rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 p-px shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 transform hover:-translate-y-0.5">
                        <div class="relative px-6 py-3.5 bg-transparent flex items-center justify-center gap-2">
                            <span class="font-bold text-white tracking-wide">Buat Tugas</span>
                        </div>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
{{-- Load Scripts dengan Defer untuk Performance --}}
<script defer src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script defer src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('assignmentForm', () => ({
            init() {
                // Menunggu Flatpickr load sempurna karena menggunakan defer
                const initFlatpickr = () => {
                    if (typeof flatpickr === 'undefined') {
                        setTimeout(initFlatpickr, 100); // Cek ulang setiap 100ms
                        return;
                    }
                    
                    const displayInput = document.getElementById('datepicker');
                    const realInput = document.getElementById('real_date');
                    
                    if(displayInput) {
                        flatpickr(displayInput, {
                            enableTime: true,
                            dateFormat: "Y-m-d H:i",
                            altInput: true,
                            altFormat: "j F Y, H:i",
                            locale: "id",
                            minDate: "today",
                            time_24hr: true,
                            defaultHour: 23,
                            defaultMinute: 59,
                            theme: "material_green",
                            disableMobile: "true",
                            onChange: (selectedDates, dateStr) => {
                                realInput.value = dateStr;
                            },
                            onReady: (selectedDates, dateStr, instance) => {
                                if (realInput.value) {
                                    instance.setDate(realInput.value, true);
                                }
                            }
                        });
                    }
                };
                
                // Mulai inisialisasi
                initFlatpickr();
            }
        }))
    });
</script>
@endpush