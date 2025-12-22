@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('page-title', 'Edit Berita')
@section('page-subtitle', 'Edit berita: {{ $news->title }}')

@section('content')
    <div class="max-w-4xl">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="glass-card rounded-2xl p-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul
                            Berita</label>
                        <input type="text" name="title" value="{{ old('title', $news->title) }}" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('title')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Kategori</label>
                        <select name="category"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            <option value="">Pilih Kategori</option>
                            <option value="Pengumuman" {{ $news->category == 'Pengumuman' ? 'selected' : '' }}>Pengumuman
                            </option>
                            <option value="Kegiatan" {{ $news->category == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                            <option value="Prestasi" {{ $news->category == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="Akademik" {{ $news->category == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Gambar
                            Utama</label>
                        @if($news->featured_image)
                            <div class="mb-2">
                                <img src="{{ Storage::url($news->featured_image) }}" class="w-32 h-24 rounded-lg object-cover">
                            </div>
                        @endif
                        <input type="file" name="featured_image" accept="image/*"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('featured_image')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Konten</label>
                        <textarea name="content" rows="10" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('content', $news->content) }}</textarea>
                        @error('content')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center space-x-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" {{ $news->is_published ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">Dipublikasikan</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_featured" value="1" {{ $news->is_featured ? 'checked' : '' }}
                                class="w-5 h-5 rounded border-slate-300 text-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">Berita Unggulan</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.news.index') }}"
                    class="px-6 py-3 text-slate-700 dark:text-slate-300 font-medium rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300">
                    Update Berita
                </button>
            </div>
        </form>
    </div>
@endsection