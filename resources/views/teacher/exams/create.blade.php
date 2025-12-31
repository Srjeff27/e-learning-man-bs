@extends('layouts.teacher')

@section('title', 'Buat Ujian Baru')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8 animate-fade-in-up">
        <!-- Header -->
        <div class="flex items-center gap-4">
            <a href="{{ route('teacher.exams.index') }}"
                class="group flex items-center justify-center h-12 w-12 bg-white dark:bg-slate-800 rounded-full shadow-lg shadow-slate-200/50 dark:shadow-slate-900/50 hover:bg-emerald-50 dark:hover:bg-slate-700 transition-all text-slate-500 hover:text-emerald-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="group-hover:-translate-x-1 transition-transform">
                    <path d="m15 18-6-6 6-6" />
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">Buat Ujian Baru</h2>
                <p class="text-slate-500 dark:text-slate-400 font-medium">Isi detail ujian di bawah ini.</p>
            </div>
        </div>

        <form action="{{ route('teacher.exams.store') }}" method="POST" class="space-y-6">
            @csrf

            <div
                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl border border-white/40 dark:border-slate-700/50 shadow-2xl shadow-slate-200/50 dark:shadow-slate-900/50 p-8 space-y-8 relative overflow-hidden">
                <!-- Decorative Background -->
                <div
                    class="absolute top-0 right-0 -mt-20 -mr-20 h-80 w-80 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-300/20 blur-3xl pointer-events-none">
                </div>
                <div
                    class="absolute bottom-0 left-0 -mb-20 -ml-20 h-80 w-80 rounded-full bg-gradient-to-tr from-indigo-400/10 to-blue-300/10 blur-3xl pointer-events-none">
                </div>

                <!-- Title -->
                <div class="space-y-3 relative z-10">
                    <label for="title"
                        class="flex items-center gap-2 text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                        <span class="w-1.5 h-4 bg-emerald-500 rounded-full"></span>
                        Judul Ujian
                    </label>
                    <input type="text" name="title" id="title" required
                        class="w-full px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all font-bold text-xl text-slate-800 dark:text-white placeholder-slate-400 shadow-inner"
                        placeholder="Contoh: Ujian Akhir Semester Matematika">
                </div>

                <!-- Classroom & Duration Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative z-10">
                    <div class="space-y-3">
                        <label for="classroom_id"
                            class="flex items-center gap-2 text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            <span class="w-1.5 h-4 bg-emerald-500 rounded-full"></span>
                            Kelas
                        </label>
                        <div class="relative group">
                            <select name="classroom_id" id="classroom_id" required
                                class="w-full px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all appearance-none font-semibold text-slate-700 dark:text-slate-200 cursor-pointer shadow-inner pr-12">
                                <option value="" disabled selected>Pilih Kelas...</option>
                                @foreach($classrooms as $classroom)
                                    <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                @endforeach
                            </select>
                            <div
                                class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 group-hover:text-emerald-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <label for="duration_minutes"
                            class="flex items-center gap-2 text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                            <span class="w-1.5 h-4 bg-emerald-500 rounded-full"></span>
                            Durasi (Menit)
                        </label>
                        <div class="relative group">
                            <input type="number" name="duration_minutes" id="duration_minutes" required min="1" value="60"
                                class="w-full px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all font-semibold text-slate-700 dark:text-slate-200 shadow-inner">
                            <div
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold bg-white dark:bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm group-focus-within:border-emerald-500/50 group-focus-within:text-emerald-600 transition-all">
                                Menit
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-3 relative z-10">
                    <label for="description"
                        class="flex items-center gap-2 text-sm font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">
                        <span class="w-1.5 h-4 bg-slate-300 dark:bg-slate-600 rounded-full"></span>
                        Deskripsi (Opsional)
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all resize-none placeholder-slate-400 text-base shadow-inner"
                        placeholder="Tambahkan instruksi khusus untuk siswa..."></textarea>
                </div>

                <!-- Buttons -->
                <div class="pt-6 flex justify-end gap-4 relative z-10 border-t border-slate-100 dark:border-slate-700/50">
                    <a href="{{ route('teacher.exams.index') }}"
                        class="px-8 py-3.5 bg-white text-slate-600 rounded-2xl font-bold hover:bg-slate-50 border border-slate-200 hover:border-slate-300 transition-all shadow-sm">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-10 py-3.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl font-bold shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:scale-[1.02] active:scale-[0.98] transition-all duration-300 flex items-center gap-2">
                        <span>Buat Ujian & Tambah Soal</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14" />
                            <path d="M12 5v14" />
                        </svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection