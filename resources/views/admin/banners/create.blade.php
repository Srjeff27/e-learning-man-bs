@extends('layouts.admin')

@section('title', 'Tambah Pengumuman')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Tambah Pengumuman</h1>
            <a href="{{ route('admin.banners.index') }}"
                class="inline-flex items-center text-slate-600 hover:text-blue-600 dark:text-slate-400 dark:hover:text-blue-400 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Form -->
        <div class="glass-card p-6 lg:p-8 rounded-2xl">
            <form action="{{ route('admin.banners.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Judul Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Contoh: PPDB Tahun Ajaran 2025/2026 Telah Dibuka" value="{{ old('title') }}">
                    @error('title')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konten -->
                <div>
                    <label for="content" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                        Isi Pengumuman <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="4" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        placeholder="Tuliskan isi pengumuman secara singkat dan jelas...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Link -->
                    <div>
                        <label for="link" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Link Tautan (Opsional)
                        </label>
                        <input type="url" name="link" id="link"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="https://example.com" value="{{ old('link') }}">
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Kosongkan jika tidak ada link.</p>
                        @error('link')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link Text -->
                    <div>
                        <label for="link_text" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Teks Tombol Link (Opsional)
                        </label>
                        <input type="text" name="link_text" id="link_text"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            placeholder="Contoh: Selengkapnya" value="{{ old('link_text', 'Selengkapnya') }}">
                        @error('link_text')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                            Urutan Tampil
                        </label>
                        <input type="number" name="order" id="order" min="0" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                            value="{{ old('order', 0) }}">
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Semakin kecil angkamya, semakin awal
                            munculnya.</p>
                        @error('order')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="flex items-center pt-8">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" checked>
                            <div
                                class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                            </div>
                            <span class="ml-3 text-sm font-medium text-slate-700 dark:text-slate-300">Aktifkan
                                Pengumuman</span>
                        </label>
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="flex justify-end pt-6">
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                        Simpan Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection