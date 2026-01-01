@extends('layouts.teacher')

@section('title', 'Detail Ujian')

@section('content')
    <div class="max-w-5xl mx-auto space-y-5 md:space-y-8 animate-fade-in-up">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-6">
            <div class="flex items-center gap-3 md:gap-4 w-full md:w-auto">
                <a href="{{ route('teacher.exams.index') }}"
                    class="group flex items-center justify-center h-10 w-10 md:h-12 md:w-12 bg-white dark:bg-slate-800 rounded-full shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50 hover:bg-emerald-50 dark:hover:bg-slate-700 transition-all text-slate-500 hover:text-emerald-600 flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
                </a>
                <div class="min-w-0">
                    <h2 class="text-xl md:text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight truncate">{{ $exam->title }}</h2>
                    <div class="flex flex-wrap items-center gap-2 md:gap-3 mt-1 text-slate-500 dark:text-slate-400 font-medium">
                        <span class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded text-[10px] md:text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                            {{ $exam->classroom->name }}
                        </span>
                        <span class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded text-[10px] md:text-xs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            {{ $exam->duration_minutes }} Menit
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 w-full md:w-auto">
                <button onclick="document.getElementById('add-question-form').scrollIntoView({behavior: 'smooth'})"
                    class="w-full md:w-auto px-5 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl font-bold text-sm shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center gap-2 transform active:scale-95">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Soal
                </button>
            </div>
        </div>

        <!-- Add Question Form -->
        <div id="add-question-form" class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl md:rounded-3xl border border-white/40 dark:border-slate-700/50 shadow-xl shadow-emerald-900/5 overflow-hidden">
            <div class="p-4 md:p-6 border-b border-emerald-100 dark:border-emerald-900/30 bg-emerald-50/50 dark:bg-emerald-900/10 flex items-center gap-3">
                <div class="p-1.5 md:p-2 bg-emerald-500 text-white rounded-lg shadow-md shadow-emerald-500/30">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.5 2H8.6c-.4 0-.8.2-1.1.5-.3.3-.5.7-.5 1.1v12.8c0 .4.2.8.5 1.1.3.3.7.5 1.1.5h9.8c.4 0 .8-.2 1.1-.5.3-.3.5-.7.5-1.1V6.5L15.5 2z"/><path d="M3 7.6v12.8c0 .4.2.8.5 1.1.3.3.7.5 1.1.5h9.8"/><path d="M15 2v5h5"/></svg>
                </div>
                <h3 class="text-base md:text-xl font-bold text-emerald-900 dark:text-emerald-100">Buat Soal Baru</h3>
            </div>
            
            <form action="{{ route('teacher.exams.questions.store', $exam) }}" method="POST" class="p-5 md:p-8 space-y-5 md:space-y-8">
                @csrf
                <!-- Question Text -->
                <div class="space-y-2 md:space-y-3">
                    <label class="block text-xs md:text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Pertanyaan</label>
                    <textarea name="question_text" rows="3" required
                        class="w-full px-4 py-3 md:px-5 md:py-4 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl md:rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all text-base md:text-lg font-medium placeholder-slate-400"
                        placeholder="Tulis pertanyaan Anda di sini..."></textarea>
                </div>
                
                <!-- Points Input -->
                <div class="space-y-2 md:space-y-3">
                    <label class="block text-xs md:text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Bobot Nilai (Poin)</label>
                    <input type="number" name="points" value="10" min="1" required
                        class="w-full md:w-1/3 px-4 py-3 md:px-5 md:py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all font-medium placeholder-slate-400">
                </div>

                <!-- Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    @foreach(['a', 'b', 'c', 'd'] as $option)
                        <div class="space-y-2 md:space-y-3 group">
                            <label class="flex items-center gap-2 md:gap-3 cursor-pointer">
                                <input type="radio" name="correct_answer" value="{{ $option }}" required
                                    class="w-4 h-4 md:w-5 md:h-5 text-emerald-600 bg-slate-100 border-slate-300 focus:ring-emerald-500">
                                <span class="text-xs md:text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider group-hover:text-emerald-600 transition-colors">Opsi {{ strtoupper($option) }}</span>
                                <span class="text-[10px] md:text-xs text-slate-400 font-normal">(Pilih jika benar)</span>
                            </label>
                            <input type="text" name="option_{{ $option }}" required
                                class="w-full px-4 py-3 md:px-5 md:py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all text-sm md:text-base font-medium placeholder-slate-400"
                                placeholder="Jawaban {{ strtoupper($option) }}">
                        </div>
                    @endforeach
                </div>

                <div class="flex justify-end pt-2 md:pt-4">
                    <button type="submit" class="w-full md:w-auto px-8 md:px-10 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-lg shadow-emerald-600/30 transition-all font-bold text-sm transform hover:-translate-y-1">
                        Simpan Soal
                    </button>
                </div>
            </form>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Ada kesalahan!</strong>
                <ul class="mt-1 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <!-- Questions List -->
        <div class="space-y-4 md:space-y-6">
            <h3 class="text-lg md:text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                <span class="w-6 h-1 md:w-8 bg-emerald-500 rounded-full inline-block"></span>
                Daftar Soal ({{ $exam->questions->count() }})
            </h3>
            
            <div class="grid grid-cols-1 gap-3 md:gap-4">
                @forelse($exam->questions as $question)
                    <div class="group bg-white dark:bg-slate-800 rounded-xl md:rounded-2xl border border-slate-200 dark:border-slate-700 p-4 md:p-6 hover:shadow-xl hover:shadow-emerald-500/5 hover:border-emerald-500/30 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl -mr-16 -mt-16 group-hover:bg-emerald-500/10 transition-colors"></div>
                        
                        <div class="relative z-10">
                            <div class="flex justify-between items-start gap-3 md:gap-4 mb-3 md:mb-4">
                                <span class="flex-shrink-0 h-7 w-7 md:h-8 md:w-8 bg-emerald-100 text-emerald-700 rounded-lg flex items-center justify-center font-bold text-xs md:text-sm">
                                    {{ $loop->iteration }}
                                </span>
                                <div class="flex-grow">
                                    <p class="text-sm md:text-lg font-medium text-slate-800 dark:text-white leading-relaxed">{{ $question->question_text }}</p>
                                </div>
                                <form action="{{ route('teacher.exams.questions.destroy', [$exam, $question]) }}" method="POST"
                                    onsubmit="return confirm('Hapus soal ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-slate-400 hover:text-red-500 transition-colors p-1.5 md:p-2 hover:bg-red-50 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-3 pl-10 md:pl-12">
                                @foreach(['a', 'b', 'c', 'd'] as $option)
                                    <div class="flex items-center gap-2 md:gap-3 p-2.5 md:p-3 rounded-xl border {{ $question->correct_answer == $option ? 'bg-emerald-50 border-emerald-200 dark:bg-emerald-900/20 dark:border-emerald-800' : 'bg-slate-50 border-slate-100 dark:bg-slate-700/50 dark:border-slate-700' }}">
                                        <span class="w-5 h-5 md:w-6 md:h-6 flex items-center justify-center rounded-full text-[10px] md:text-xs font-bold {{ $question->correct_answer == $option ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500' }}">
                                            {{ strtoupper($option) }}
                                        </span>
                                        <span class="text-xs md:text-sm {{ $question->correct_answer == $option ? 'text-emerald-900 dark:text-emerald-300 font-semibold' : 'text-slate-600 dark:text-slate-400' }}">
                                            {{ $question->{'option_'.$option} }}
                                        </span>
                                        @if($question->correct_answer == $option)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="ml-auto text-emerald-500"><polyline points="20 6 9 17 4 12"/></svg>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 md:p-12 text-center bg-slate-50 dark:bg-slate-800 rounded-2xl md:rounded-3xl border border-slate-100 dark:border-slate-700">
                        <div class="inline-flex p-3 md:p-4 bg-white dark:bg-slate-700/50 rounded-full mb-3 md:mb-4 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" md:width="32" md:height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-300"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                        </div>
                        <p class="text-slate-500 font-medium text-sm md:text-base">Belum ada soal.</p>
                        <p class="text-slate-400 text-xs md:text-sm">Gunakan form di atas untuk menambahkan soal pertama.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection