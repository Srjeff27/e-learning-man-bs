@extends('layouts.teacher')

@section('title', 'Buat Ujian Baru')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('teacher.exams.index') }}"
                class="p-2 bg-white dark:bg-slate-800 rounded-full shadow hover:shadow-md transition-all text-slate-500 hover:text-emerald-500">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Buat Ujian Baru</h2>
        </div>

        <!-- Form -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 shadow-lg p-8">
            <form action="{{ route('teacher.exams.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Classroom -->
                <div>
                    <label for="classroom_id"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Kelas</label>
                    <select name="classroom_id" id="classroom_id"
                        class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all dark:text-white"
                        required>
                        <option value="" disabled selected>Pilih Kelas</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                    @error('classroom_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul
                        Ujian</label>
                    <input type="text" name="title" id="title"
                        class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all dark:text-white"
                        placeholder="Contoh: Ujian Tengah Semester Matematika" required>
                    @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Duration -->
                <div>
                    <label for="duration_minutes"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Durasi (Menit)</label>
                    <input type="number" name="duration_minutes" id="duration_minutes"
                        class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all dark:text-white"
                        value="60" min="1" required>
                    @error('duration_minutes') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description"
                        class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi
                        (Opsional)</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-3 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none transition-all dark:text-white"
                        placeholder="Deskripsi singkat mengenai ujian ini..."></textarea>
                    @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 font-bold transform hover:-translate-y-1">
                        Buat Ujian
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection