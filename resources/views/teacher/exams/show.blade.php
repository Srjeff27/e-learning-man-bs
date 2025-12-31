@extends('layouts.teacher')

@section('title', 'Detail Ujian')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('teacher.exams.index') }}"
                    class="group flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 rounded-xl shadow hover:shadow-md transition-all text-slate-500 hover:text-emerald-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    <span class="font-bold text-sm">Kembali ke Daftar Ujian</span>
                </a>
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 dark:text-white">{{ $exam->title }}</h2>
                    <p class="text-slate-500 dark:text-slate-400">Kelas: {{ $exam->classroom->name }} | Durasi:
                        {{ $exam->duration_minutes }} Menit</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-100 text-emerald-700 rounded-xl border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Question List (Left) -->
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Soal
                            ({{ $exam->questions->count() }})</h3>
                    </div>

                    <div class="space-y-4">
                        @forelse($exam->questions as $index => $question)
                            <div
                                class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50">
                                <div class="flex justify-between items-start">
                                    <div class="flex gap-3">
                                        <span
                                            class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-600 font-bold text-sm">
                                            {{ $index + 1 }}
                                        </span>
                                        <div>
                                            <p class="text-slate-800 dark:text-white font-medium mb-3">
                                                {{ $question->question_text }}</p>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm">
                                                <div
                                                    class="{{ $question->correct_answer == 'a' ? 'text-emerald-600 font-bold' : 'text-slate-600 dark:text-slate-400' }}">
                                                    A. {{ $question->option_a }}</div>
                                                <div
                                                    class="{{ $question->correct_answer == 'b' ? 'text-emerald-600 font-bold' : 'text-slate-600 dark:text-slate-400' }}">
                                                    B. {{ $question->option_b }}</div>
                                                <div
                                                    class="{{ $question->correct_answer == 'c' ? 'text-emerald-600 font-bold' : 'text-slate-600 dark:text-slate-400' }}">
                                                    C. {{ $question->option_c }}</div>
                                                <div
                                                    class="{{ $question->correct_answer == 'd' ? 'text-emerald-600 font-bold' : 'text-slate-600 dark:text-slate-400' }}">
                                                    D. {{ $question->option_d }}</div>
                                            </div>
                                            <div class="mt-2 text-xs text-slate-400">Poin: {{ $question->points }}</div>
                                        </div>
                                    </div>
                                    <form action="{{ route('teacher.exams.questions.destroy', [$exam, $question]) }}"
                                        method="POST" onsubmit="return confirm('Hapus soal ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 p-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path d="M3 6h18" />
                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div
                                class="text-center p-8 text-slate-400 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-dashed border-slate-300 dark:border-slate-700">
                                Belum ada soal ditambahkan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Add Question Form (Right) -->
            <div class="lg:col-span-1">
                <div
                    class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 shadow-lg p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Tambah Soal</h3>
                    <form action="{{ route('teacher.exams.questions.store', $exam) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label
                                class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Pertanyaan</label>
                            <textarea name="question_text" rows="3"
                                class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none text-sm dark:text-white"
                                required placeholder="Tulis pertanyaan..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 gap-3">
                            @foreach(['a', 'b', 'c', 'd'] as $opt)
                                <div>
                                    <label
                                        class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1 uppercase">Opsi
                                        {{ $opt }}</label>
                                    <input type="text" name="option_{{ $opt }}"
                                        class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none text-sm dark:text-white"
                                        required>
                                </div>
                            @endforeach
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Jawaban
                                    Benar</label>
                                <select name="correct_answer"
                                    class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none text-sm dark:text-white"
                                    required>
                                    <option value="a">A</option>
                                    <option value="b">B</option>
                                    <option value="c">C</option>
                                    <option value="d">D</option>
                                </select>
                            </div>
                            <div>
                                <label
                                    class="block text-xs font-medium text-slate-700 dark:text-slate-300 mb-1">Poin</label>
                                <input type="number" name="points" value="5" min="1"
                                    class="w-full px-3 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg focus:ring-2 focus:ring-emerald-500 outline-none text-sm dark:text-white"
                                    required>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition-colors font-medium text-sm mt-2">
                            + Tambah Soal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection