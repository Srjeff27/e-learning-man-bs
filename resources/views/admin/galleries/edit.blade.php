@extends('layouts.admin')

@section('title', 'Edit Galeri')
@section('page-title', 'Edit Galeri')

@section('content')
    <div class="max-w-2xl">
        <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="glass-card rounded-2xl p-6 space-y-6">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul</label>
                    <input type="text" name="title" value="{{ old('title', $gallery->title) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Kategori</label>
                    <select name="category"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Pilih Kategori</option>
                        <option value="Kegiatan" {{ $gallery->category == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                        <option value="Fasilitas" {{ $gallery->category == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                        <option value="Prestasi" {{ $gallery->category == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                        <option value="Ekstrakurikuler" {{ $gallery->category == 'Ekstrakurikuler' ? 'selected' : '' }}>
                            Ekstrakurikuler</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">File Baru
                        (opsional)</label>
                    @if($gallery->file_path)
                        <div class="mb-2">
                            @if($gallery->type === 'photo')
                                <img src="{{ Storage::url($gallery->file_path) }}" class="w-32 h-24 rounded-lg object-cover">
                            @endif
                        </div>
                    @endif
                    <input type="file" name="file" accept="image/*,video/*"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('description', $gallery->description) }}</textarea>
                </div>

                <label class="flex items-center">
                    <input type="checkbox" name="is_featured" value="1" {{ $gallery->is_featured ? 'checked' : '' }}
                        class="w-5 h-5 rounded border-slate-300 text-violet-500 focus:ring-violet-500">
                    <span class="ml-2 text-sm text-slate-700 dark:text-slate-300">Tampilkan di halaman utama</span>
                </label>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.galleries.index') }}"
                    class="px-6 py-3 text-slate-700 dark:text-slate-300 font-medium rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">Batal</a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-violet-500 to-purple-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-violet-500/30 transition-all duration-300">Update</button>
            </div>
        </form>
    </div>
@endsection