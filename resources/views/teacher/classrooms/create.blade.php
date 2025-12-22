@extends('layouts.teacher')

@section('title', 'Buat Kelas Baru')

@section('content')
    <div class="max-w-2xl">
        <div class="mb-6">
            <a href="{{ route('teacher.classrooms.index') }}"
                class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Kelas Saya
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-xl font-semibold text-slate-900 mb-6">Buat Kelas Baru</h2>

            <form action="{{ route('teacher.classrooms.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas *</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="input @error('name') input-error @enderror" placeholder="Contoh: Matematika Kelas XII IPA"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Mata Pelajaran</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" class="input"
                        placeholder="Contoh: Matematika">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select id="grade" name="grade" class="input">
                            <option value="">Pilih Kelas</option>
                            <option value="X" {{ old('grade') === 'X' ? 'selected' : '' }}>Kelas X</option>
                            <option value="XI" {{ old('grade') === 'XI' ? 'selected' : '' }}>Kelas XI</option>
                            <option value="XII" {{ old('grade') === 'XII' ? 'selected' : '' }}>Kelas XII</option>
                        </select>
                    </div>
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                        <select id="semester" name="semester" class="input">
                            <option value="">Pilih Semester</option>
                            <option value="Ganjil" {{ old('semester') === 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="Genap" {{ old('semester') === 'Genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="academic_year" class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                    <input type="text" id="academic_year" name="academic_year"
                        value="{{ old('academic_year', date('Y') . '/' . (date('Y') + 1)) }}" class="input"
                        placeholder="Contoh: 2024/2025">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="description" name="description" rows="3" class="input"
                        placeholder="Deskripsi singkat tentang kelas ini">{{ old('description') }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t">
                    <a href="{{ route('teacher.classrooms.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Buat Kelas</button>
                </div>
            </form>
        </div>
    </div>
@endsection