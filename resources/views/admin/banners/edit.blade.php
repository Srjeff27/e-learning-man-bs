@extends('layouts.admin')

@section('title', 'Edit Banner')
@section('page-title', 'Edit Banner Pengumuman')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('admin.banners.index') }}" class="text-gray-600 hover:text-blue-600 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Banner
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-semibold text-slate-900 mb-6">Edit Banner</h2>

            <form action="{{ route('admin.banners.update', $banner) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title', $banner->title) }}"
                            class="input @error('title') border-red-500 @enderror" placeholder="Contoh: Pengumuman"
                            required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten <span
                                class="text-red-500">*</span></label>
                        <textarea name="content" id="content" rows="3"
                            class="input @error('content') border-red-500 @enderror" placeholder="Isi pengumuman..."
                            required>{{ old('content', $banner->content) }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="link" class="block text-sm font-medium text-gray-700 mb-1">Link (Opsional)</label>
                            <input type="url" name="link" id="link" value="{{ old('link', $banner->link) }}"
                                class="input @error('link') border-red-500 @enderror" placeholder="https://example.com">
                            @error('link')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="link_text" class="block text-sm font-medium text-gray-700 mb-1">Teks Tombol</label>
                            <input type="text" name="link_text" id="link_text"
                                value="{{ old('link_text', $banner->link_text) }}" class="input" placeholder="Selengkapnya">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="order" class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                            <input type="number" name="order" id="order" value="{{ old('order', $banner->order) }}"
                                class="input" min="0">
                            <p class="text-gray-500 text-xs mt-1">Urutan lebih kecil ditampilkan lebih dulu</p>
                        </div>

                        <div class="flex items-center pt-6">
                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                class="w-4 h-4 text-blue-600 rounded border-gray-300" {{ old('is_active', $banner->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 text-sm text-gray-700">Aktifkan banner ini</label>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection