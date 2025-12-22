@extends('layouts.teacher')

@section('title', 'Edit Tugas')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('teacher.assignments.show', [$classroom, $assignment]) }}"
                class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Detail Tugas
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-semibold text-slate-900 mb-6">Edit Tugas</h2>

            <form action="{{ route('teacher.assignments.update', [$classroom, $assignment]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $assignment->title) }}"
                        class="input @error('title') border-red-500 @enderror" 
                        placeholder="Contoh: Latihan Soal Bab 1" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" class="input"
                        placeholder="Deskripsi singkat tentang tugas ini">{{ old('description', $assignment->description) }}</textarea>
                </div>

                <div>
                    <label for="instructions" class="block text-sm font-medium text-gray-700 mb-1">Instruksi Pengerjaan</label>
                    <textarea id="instructions" name="instructions" rows="4" class="input"
                        placeholder="Petunjuk detail bagaimana mengerjakan tugas ini">{{ old('instructions', $assignment->instructions) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="max_score" class="block text-sm font-medium text-gray-700 mb-1">Nilai Maksimal *</label>
                        <input type="number" id="max_score" name="max_score" value="{{ old('max_score', $assignment->max_score) }}"
                            class="input" min="1" max="100" required>
                    </div>
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Deadline</label>
                        <input type="datetime-local" id="due_date" name="due_date" 
                            value="{{ old('due_date', $assignment->due_date ? $assignment->due_date->format('Y-m-d\TH:i') : '') }}"
                            class="input">
                    </div>
                </div>

                <div>
                    <label for="submission_type" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pengumpulan *</label>
                    <select id="submission_type" name="submission_type" class="input" required>
                        <option value="file" {{ old('submission_type', $assignment->submission_type) === 'file' ? 'selected' : '' }}>Upload File</option>
                        <option value="text" {{ old('submission_type', $assignment->submission_type) === 'text' ? 'selected' : '' }}>Teks/Essay</option>
                        <option value="link" {{ old('submission_type', $assignment->submission_type) === 'link' ? 'selected' : '' }}>Link URL</option>
                        <option value="multiple" {{ old('submission_type', $assignment->submission_type) === 'multiple' ? 'selected' : '' }}>Kombinasi</option>
                    </select>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center">
                        <input type="checkbox" id="allow_late_submission" name="allow_late_submission" value="1"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                            {{ old('allow_late_submission', $assignment->allow_late_submission) ? 'checked' : '' }}>
                        <label for="allow_late_submission" class="ml-2 text-sm text-gray-700">Izinkan pengumpulan terlambat</label>
                    </div>

                    <div id="late_penalty_wrapper" class="pl-6 {{ old('allow_late_submission', $assignment->allow_late_submission) ? '' : 'hidden' }}">
                        <label for="late_penalty_percent" class="block text-sm font-medium text-gray-700 mb-1">Potongan Nilai (%)</label>
                        <input type="number" id="late_penalty_percent" name="late_penalty_percent" 
                            value="{{ old('late_penalty_percent', $assignment->late_penalty_percent ?? 10) }}" class="input w-32" min="0" max="100">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_published" name="is_published" value="1"
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                        {{ old('is_published', $assignment->is_published) ? 'checked' : '' }}>
                    <label for="is_published" class="ml-2 text-sm text-gray-700">Publikasikan tugas</label>
                </div>

                <div class="flex justify-between items-center pt-4 border-t">
                    <form action="{{ route('teacher.assignments.destroy', [$classroom, $assignment]) }}" method="POST" 
                        onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                            Hapus Tugas
                        </button>
                    </form>
                    <div class="flex gap-3">
                        <a href="{{ route('teacher.assignments.show', [$classroom, $assignment]) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('allow_late_submission').addEventListener('change', function() {
            document.getElementById('late_penalty_wrapper').classList.toggle('hidden', !this.checked);
        });
    </script>
@endsection
