@extends('layouts.teacher')

@section('title', 'Tambah Materi Baru')

@push('styles')
    <style>
        .animate-enter {
            animation: enter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes enter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.1);
        }

        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
        }

        .input-glossy {
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.5);
        }

        .dark .input-glossy {
            background-color: rgba(30, 41, 59, 0.5);
        }

        .input-glossy:focus {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }

        .dark .input-glossy:focus {
            background-color: rgba(30, 41, 59, 0.8);
        }

        /* Toggle Switch */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #10b981;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #10b981;
        }

        /* Smooth Transition for Dynamic Fields */
        .dynamic-field {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            opacity: 0;
            max-height: 0;
            transform: translateY(-10px);
        }

        .dynamic-field.active {
            opacity: 1;
            max-height: 600px;
            transform: translateY(0);
            margin-top: 1.5rem;
        }

        /* File dropzone */
        .file-dropzone {
            transition: all 0.3s ease;
        }

        .file-dropzone.dragover {
            border-color: #10b981;
            background-color: rgba(16, 185, 129, 0.1);
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-500 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden font-sans">

        {{-- Ambient Background --}}
        <div
            class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen pointer-events-none animate-pulse">
        </div>
        <div
            class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-teal-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen pointer-events-none">
        </div>

        <div class="max-w-3xl mx-auto relative z-10">

            {{-- Navigation --}}
            <div class="mb-8 animate-enter flex justify-between items-center">
                <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                    class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                    <div
                        class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-400 dark:group-hover:border-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    Kembali ke {{ $classroom->name }}
                </a>
            </div>

            <div class="glass-panel rounded-[2rem] p-8 md:p-10 animate-enter" style="animation-delay: 0.1s;">
                {{-- Header --}}
                <div class="flex items-center gap-4 mb-8 border-b border-slate-200 dark:border-slate-700/50 pb-6">
                    <div
                        class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center text-white">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Tambah Materi Baru</h1>
                        <p class="text-slate-500 dark:text-slate-400 text-sm">Bagikan bahan ajar, video, atau referensi
                            untuk siswa.</p>
                    </div>
                </div>

                <form action="{{ route('teacher.materials.store', $classroom) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6" id="materialForm">
                    @csrf

                    {{-- Judul Materi --}}
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Judul
                            Materi <span class="text-emerald-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}"
                            class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 outline-none @error('title') border-red-500 ring-2 ring-red-500/20 @enderror"
                            placeholder="Contoh: Pengenalan Aljabar Linear" required>
                        @error('title')
                            <p class="text-sm text-red-500 flex items-center gap-1 mt-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Tipe Materi with Visual Cards --}}
                    <div class="space-y-3">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Tipe Materi <span
                                class="text-emerald-500">*</span></label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            <label class="type-card cursor-pointer group">
                                <input type="radio" name="type" value="text" class="sr-only peer" {{ old('type', 'text') === 'text' ? 'checked' : '' }}>
                                <div
                                    class="p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all text-center">
                                    <div
                                        class="w-10 h-10 mx-auto mb-2 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 peer-checked:bg-emerald-500 peer-checked:text-white group-hover:scale-105 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Teks/Artikel</span>
                                </div>
                            </label>
                            <label class="type-card cursor-pointer group">
                                <input type="radio" name="type" value="file" class="sr-only peer" {{ old('type') === 'file' ? 'checked' : '' }}>
                                <div
                                    class="p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all text-center">
                                    <div
                                        class="w-10 h-10 mx-auto mb-2 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 peer-checked:bg-emerald-500 peer-checked:text-white group-hover:scale-105 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Upload File</span>
                                </div>
                            </label>
                            <label class="type-card cursor-pointer group">
                                <input type="radio" name="type" value="video" class="sr-only peer" {{ old('type') === 'video' ? 'checked' : '' }}>
                                <div
                                    class="p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all text-center">
                                    <div
                                        class="w-10 h-10 mx-auto mb-2 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 peer-checked:bg-emerald-500 peer-checked:text-white group-hover:scale-105 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Video</span>
                                </div>
                            </label>
                            <label class="type-card cursor-pointer group">
                                <input type="radio" name="type" value="link" class="sr-only peer" {{ old('type') === 'link' ? 'checked' : '' }}>
                                <div
                                    class="p-4 rounded-xl border-2 border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-800/50 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all text-center">
                                    <div
                                        class="w-10 h-10 mx-auto mb-2 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 peer-checked:bg-emerald-500 peer-checked:text-white group-hover:scale-105 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                    </div>
                                    <span class="text-xs font-bold text-slate-600 dark:text-slate-300">Link URL</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Dynamic Fields --}}

                    {{-- 1. Content Wrapper (Text) --}}
                    <div id="content_wrapper" class="dynamic-field">
                        <label for="content"
                            class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1 mb-2">Konten
                            Artikel</label>
                        <textarea id="content" name="content" rows="10"
                            class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 outline-none resize-none"
                            placeholder="Tulis materi pembelajaran secara lengkap di sini...">{{ old('content') }}</textarea>
                        <p class="mt-2 text-xs text-slate-500">Anda dapat menulis materi dalam bentuk teks panjang atau
                            paragraf.</p>
                    </div>

                    {{-- 2. File Wrapper --}}
                    <div id="file_wrapper" class="dynamic-field">
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1 mb-2">Upload
                            Dokumen</label>
                        <div id="file_dropzone"
                            class="file-dropzone mt-1 flex justify-center px-6 pt-8 pb-8 border-2 border-slate-300 dark:border-slate-700 border-dashed rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors cursor-pointer">
                            <div class="space-y-2 text-center">
                                <div id="file_icon"
                                    class="mx-auto w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                    <svg class="h-8 w-8 text-slate-400" stroke="currentColor" fill="none"
                                        viewBox="0 0 48 48">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div id="file_preview" class="hidden">
                                    <div
                                        class="flex items-center justify-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-200 dark:border-emerald-800">
                                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <div class="text-left">
                                            <p id="file_name"
                                                class="text-sm font-bold text-emerald-700 dark:text-emerald-300"></p>
                                            <p id="file_size" class="text-xs text-emerald-600 dark:text-emerald-400"></p>
                                        </div>
                                        <button type="button" onclick="clearFile()"
                                            class="ml-2 p-1 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/20 rounded-full">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <div id="file_placeholder">
                                    <div class="flex text-sm text-slate-600 dark:text-slate-400 justify-center">
                                        <span
                                            class="font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-500">Klik
                                            untuk upload</span>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-slate-500 mt-1">PDF, PPTX, DOCX, XLS (Maks. 10MB)</p>
                                </div>
                                <input id="file" name="file" type="file" class="sr-only"
                                    accept=".pdf,.ppt,.pptx,.doc,.docx,.xls,.xlsx">
                            </div>
                        </div>
                        @error('file')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- 3. Link Wrapper (Link / Video) --}}
                    <div id="link_wrapper" class="dynamic-field">
                        <label for="external_link"
                            class="block text-sm font-bold text-slate-700 dark:text-slate-300 ml-1 mb-2">
                            <span id="link_label">Link URL</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg id="link_icon" class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <input type="url" id="external_link" name="external_link" value="{{ old('external_link') }}"
                                class="input-glossy block w-full pl-12 pr-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 outline-none"
                                placeholder="https://example.com/materi">
                        </div>
                        <p id="link_hint" class="mt-2 text-xs text-slate-500">Masukkan URL lengkap termasuk https://</p>
                        @error('external_link')
                            <p class="mt-2 text-sm text-red-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <hr class="border-slate-200 dark:border-slate-700/50">

                    {{-- Publish Toggle --}}
                    <div
                        class="flex items-center justify-between bg-white/40 dark:bg-slate-900/40 p-4 rounded-xl border border-slate-200 dark:border-slate-700/50">
                        <label for="is_published" class="flex flex-col cursor-pointer">
                            <span class="font-bold text-slate-800 dark:text-slate-200">Publikasikan Sekarang</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">Materi akan langsung terlihat oleh
                                siswa.</span>
                        </label>
                        <div
                            class="relative inline-block w-12 h-6 align-middle select-none transition duration-200 ease-in">
                            <input type="checkbox" name="is_published" id="is_published" value="1"
                                class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-slate-300 appearance-none cursor-pointer transition-all duration-300 focus:outline-none"
                                {{ old('is_published', true) ? 'checked' : '' }}>
                            <label for="is_published"
                                class="toggle-label block overflow-hidden h-6 rounded-full bg-slate-300 cursor-pointer transition-colors duration-300"></label>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-2 flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                            class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-center shadow-sm">
                            Batal
                        </a>
                        <button type="submit" id="submitBtn"
                            class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-white font-bold bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transform hover:-translate-y-0.5 transition-all text-center flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Simpan Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeCards = document.querySelectorAll('input[name="type"]');
            const contentWrapper = document.getElementById('content_wrapper');
            const fileWrapper = document.getElementById('file_wrapper');
            const linkWrapper = document.getElementById('link_wrapper');
            const fileInput = document.getElementById('file');
            const fileDropzone = document.getElementById('file_dropzone');
            const linkLabel = document.getElementById('link_label');
            const linkHint = document.getElementById('link_hint');
            const linkIcon = document.getElementById('link_icon');

            function toggleFields() {
                const selectedType = document.querySelector('input[name="type"]:checked')?.value || 'text';

                const setActive = (el, isActive) => {
                    if (isActive) {
                        el.style.display = 'block';
                        setTimeout(() => el.classList.add('active'), 10);
                    } else {
                        el.classList.remove('active');
                        setTimeout(() => {
                            if (!el.classList.contains('active')) el.style.display = 'none';
                        }, 400);
                    }
                };

                setActive(contentWrapper, selectedType === 'text');
                setActive(fileWrapper, selectedType === 'file');
                setActive(linkWrapper, selectedType === 'link' || selectedType === 'video');

                // Update link label and hint based on type
                if (selectedType === 'video') {
                    linkLabel.textContent = 'Link Video (YouTube/Vimeo)';
                    linkHint.textContent = 'Masukkan link YouTube atau platform video lainnya';
                    linkIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>';
                } else {
                    linkLabel.textContent = 'Link URL Eksternal';
                    linkHint.textContent = 'Masukkan URL lengkap termasuk https://';
                    linkIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>';
                }
            }

            // Listen to type card changes
            typeCards.forEach(card => {
                card.addEventListener('change', toggleFields);
            });

            // Initial state
            [contentWrapper, fileWrapper, linkWrapper].forEach(el => el.style.display = 'none');
            toggleFields();

            // File handling
            fileDropzone.addEventListener('click', () => fileInput.click());

            fileDropzone.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileDropzone.classList.add('dragover');
            });

            fileDropzone.addEventListener('dragleave', () => {
                fileDropzone.classList.remove('dragover');
            });

            fileDropzone.addEventListener('drop', (e) => {
                e.preventDefault();
                fileDropzone.classList.remove('dragover');
                if (e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    showFilePreview(e.dataTransfer.files[0]);
                }
            });

            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    showFilePreview(e.target.files[0]);
                }
            });

            window.showFilePreview = function (file) {
                const filePreview = document.getElementById('file_preview');
                const filePlaceholder = document.getElementById('file_placeholder');
                const fileIcon = document.getElementById('file_icon');
                const fileName = document.getElementById('file_name');
                const fileSize = document.getElementById('file_size');

                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);

                filePreview.classList.remove('hidden');
                filePlaceholder.classList.add('hidden');
                fileIcon.classList.add('hidden');
            };

            window.clearFile = function () {
                const filePreview = document.getElementById('file_preview');
                const filePlaceholder = document.getElementById('file_placeholder');
                const fileIcon = document.getElementById('file_icon');

                fileInput.value = '';
                filePreview.classList.add('hidden');
                filePlaceholder.classList.remove('hidden');
                fileIcon.classList.remove('hidden');
            };

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
        });
    </script>
@endsection