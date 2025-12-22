@extends('layouts.teacher')

@section('title', 'Tambah Materi Baru')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke {{ $classroom->name }}
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-semibold text-slate-900 mb-6">Tambah Materi Baru</h2>

            <form action="{{ route('teacher.materials.store', $classroom) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Materi *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        class="input @error('title') border-red-500 @enderror" placeholder="Contoh: Pengenalan Aljabar"
                        required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Materi *</label>
                    <select id="type" name="type" class="input" required>
                        <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Teks/Artikel</option>
                        <option value="file" {{ old('type') === 'file' ? 'selected' : '' }}>Upload File</option>
                        <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video</option>
                        <option value="link" {{ old('type') === 'link' ? 'selected' : '' }}>Link Eksternal</option>
                    </select>
                </div>

                <div id="content_wrapper">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Konten</label>
                    <textarea id="content" name="content" rows="6" class="input"
                        placeholder="Tulis konten materi di sini...">{{ old('content') }}</textarea>
                </div>

                <div id="file_wrapper" class="hidden">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Upload File (maks. 10MB)</label>
                    <input type="file" id="file" name="file" class="input">
                    @error('file')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div id="link_wrapper" class="hidden">
                    <label for="external_link" class="block text-sm font-medium text-gray-700 mb-1">Link Eksternal</label>
                    <input type="url" id="external_link" name="external_link" value="{{ old('external_link') }}"
                        class="input" placeholder="https://...">
                    @error('external_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_published" name="is_published" value="1"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ old('is_published', true) ? 'checked' : '' }}>
                    <label for="is_published" class="ml-2 text-sm text-gray-700">Publikasikan materi sekarang</label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('teacher.classrooms.show', $classroom) }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Materi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const typeSelect = document.getElementById('type');
        const contentWrapper = document.getElementById('content_wrapper');
        const fileWrapper = document.getElementById('file_wrapper');
        const linkWrapper = document.getElementById('link_wrapper');

        function toggleFields() {
            const type = typeSelect.value;
            contentWrapper.classList.toggle('hidden', type === 'file');
            fileWrapper.classList.toggle('hidden', type !== 'file');
            linkWrapper.classList.toggle('hidden', type !== 'link' && type !== 'video');
        }

        typeSelect.addEventListener('change', toggleFields);
        toggleFields();
    </script>
@endsection