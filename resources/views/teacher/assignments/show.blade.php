@extends('layouts.teacher')

@section('title', $assignment->title)

@push('styles')
    <style>
        .animate-enter {
            animation: enter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes enter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.1);
        }

        .dark .glass-panel {
            background: rgba(15, 23, 42, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
        }

        .glass-header {
            background: rgba(255, 255, 255, 0.5);
            border-bottom: 1px solid rgba(16, 185, 129, 0.1);
        }

        .dark .glass-header {
            background: rgba(15, 23, 42, 0.4);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .input-glossy {
            background-color: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.6);
            transition: all 0.3s ease;
        }

        .dark .input-glossy {
            background-color: rgba(30, 41, 59, 0.5);
            border-color: rgba(255, 255, 255, 0.1);
        }

        .input-glossy:focus {
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
            border-color: #10b981;
        }

        .dark .input-glossy:focus {
            background-color: rgba(30, 41, 59, 0.9);
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-500 py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden font-sans">

        {{-- Ambient Background --}}
        <div
            class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen pointer-events-none animate-pulse">
        </div>
        <div
            class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-teal-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen pointer-events-none">
        </div>

        <div class="max-w-6xl mx-auto relative z-10 space-y-8">

            {{-- Navigation --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 animate-enter">
                <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                    class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                    <div
                        class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-400 dark:group-hover:border-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </div>
                    Kembali ke {{ $classroom->name }}
                </a>
                <a href="{{ route('teacher.assignments.edit', [$classroom, $assignment]) }}"
                    class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Tugas
                </a>
            </div>

            {{-- Assignment Detail Card --}}
            <div class="glass-panel rounded-[2rem] p-8 animate-enter" style="animation-delay: 0.1s;">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">
                            {{ $assignment->title }}
                        </h1>
                        <div class="flex items-center gap-3 mt-2 text-sm text-slate-500 dark:text-slate-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $assignment->created_at->format('d M Y') }}
                            </span>
                            <span>•</span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $assignment->created_at->format('H:i') }} WIB
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span
                            class="px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider border {{ $assignment->is_published ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-800' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-800' }}">
                            {{ $assignment->is_published ? 'Dipublikasikan' : 'Draft' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        @if($assignment->description)
                            <div class="prose dark:prose-invert max-w-none">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2">
                                    Deskripsi</h3>
                                <p class="text-slate-700 dark:text-slate-300 leading-relaxed">{{ $assignment->description }}</p>
                            </div>
                        @endif

                        @if($assignment->instructions)
                            <div class="prose dark:prose-invert max-w-none">
                                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-2">
                                    Instruksi Pengerjaan</h3>
                                <div
                                    class="text-slate-700 dark:text-slate-300 leading-relaxed p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-700">
                                    {!! nl2br(e($assignment->instructions)) !!}
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="lg:col-span-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div
                                class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl border border-emerald-100 dark:border-emerald-800/50">
                                <p
                                    class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-1">
                                    Nilai Maks</p>
                                <p class="text-2xl font-black text-slate-800 dark:text-white">{{ $assignment->max_score }}
                                </p>
                            </div>
                            <div
                                class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-100 dark:border-blue-800/50">
                                <p class="text-xs font-bold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">
                                    Tipe</p>
                                <p class="text-lg font-bold text-slate-800 dark:text-white capitalize">
                                    {{ $assignment->submission_type }}
                                </p>
                            </div>
                            <div
                                class="col-span-2 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-2xl border border-slate-100 dark:border-slate-700">
                                <div class="flex justify-between items-center mb-2">
                                    <p
                                        class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Deadline</p>
                                    @if($assignment->due_date && $assignment->due_date->isPast())
                                        <span
                                            class="text-[10px] font-bold text-red-500 bg-red-100 dark:bg-red-900/30 px-2 py-0.5 rounded">Berakhir</span>
                                    @endif
                                </div>
                                <p class="text-lg font-bold text-slate-800 dark:text-white">
                                    {{ $assignment->due_date ? $assignment->due_date->format('d M Y, H:i') : '-' }}
                                </p>
                                <p class="text-xs text-slate-500 mt-2 pt-2 border-t border-slate-200 dark:border-slate-700">
                                    Terlambat: <span
                                        class="font-semibold">{{ $assignment->allow_late_submission ? 'Diizinkan (-' . $assignment->late_penalty_percent . '%)' : 'Ditolak' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Submissions Section --}}
            <div class="glass-panel rounded-[2rem] overflow-hidden animate-enter" style="animation-delay: 0.2s;">
                <div
                    class="p-6 md:p-8 border-b border-slate-200 dark:border-slate-700/50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                        Pengumpulan Tugas
                        <span
                            class="px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-bold">
                            {{ $submissions->count() }} / {{ $classroom->students->count() }}
                        </span>
                    </h2>

                    {{-- Progress Bar --}}
                    <div class="w-full md:w-48 bg-slate-100 dark:bg-slate-800 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-gradient-to-r from-emerald-400 to-teal-500 h-2.5 rounded-full"
                            style="width: {{ ($submissions->count() / max($classroom->students->count(), 1)) * 100 }}%">
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    @if($submissions->count() > 0)
                        <table class="w-full">
                            <thead class="glass-header">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Siswa</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Waktu</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Nilai</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Kiriman</th>
                                    <th
                                        class="px-6 py-4 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($submissions as $submission)
                                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-gradient-to-tr from-emerald-400 to-teal-500 flex items-center justify-center text-white text-xs font-bold shadow-sm">
                                                    {{ substr($submission->student->name, 0, 1) }}
                                                </div>
                                                <span
                                                    class="font-bold text-slate-700 dark:text-slate-200">{{ $submission->student->name }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-slate-600 dark:text-slate-300">
                                                {{ $submission->submitted_at->format('d M H:i') }}
                                                @if($assignment->due_date && $submission->submitted_at->gt($assignment->due_date))
                                                    <span
                                                        class="ml-2 text-[10px] font-bold text-red-500 bg-red-50 dark:bg-red-900/20 px-1.5 py-0.5 rounded border border-red-100 dark:border-red-800">Terlambat</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-bold border {{ $submission->status === 'graded' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 border-green-200 dark:border-green-800' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 border-yellow-200 dark:border-yellow-800' }}">
                                                {{ $submission->status === 'graded' ? 'Dinilai' : 'Menunggu' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($submission->score !== null)
                                                <span
                                                    class="text-lg font-black text-slate-800 dark:text-white">{{ $submission->score }}</span>
                                                <span class="text-xs text-slate-400">/{{ $assignment->max_score }}</span>
                                            @else
                                                <span class="text-slate-400 text-sm">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            {{-- Show submission type indicator --}}
                                            @if($submission->file_path)
                                                <span
                                                    class="inline-flex items-center gap-1 text-xs font-medium text-blue-600 dark:text-blue-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                    </svg>
                                                    {{ $submission->file_name ?? 'File' }}
                                                </span>
                                            @elseif($submission->external_link)
                                                <span
                                                    class="inline-flex items-center gap-1 text-xs font-medium text-purple-600 dark:text-purple-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                                    Link
                                                </span>
                                            @elseif($submission->content)
                                                <span
                                                    class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 dark:text-emerald-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    Teks
                                                </span>
                                            @else
                                                <span class="text-slate-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                {{-- View Submission Button --}}
                                                <button
                                                    onclick="openSubmissionModal('{{ $submission->student->name }}', '{{ $submission->file_path ? asset('storage/' . $submission->file_path) : '' }}', '{{ $submission->file_name ?? '' }}', '{{ addslashes($submission->external_link ?? '') }}', `{{ addslashes($submission->content ?? '') }}`)"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-all shadow-sm">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    Lihat
                                                </button>
                                                {{-- Grade Button --}}
                                                <button
                                                    onclick="openGradeModal({{ $submission->id }}, '{{ $submission->student->name }}', {{ $submission->score ?? 'null' }}, '{{ $submission->feedback ?? '' }}')"
                                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-emerald-400 dark:hover:border-emerald-600 text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all shadow-sm">
                                                    {{ $submission->status === 'graded' ? 'Edit Nilai' : 'Beri Nilai' }}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex flex-col items-center justify-center py-16 px-4">
                            <div
                                class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4 border border-slate-100 dark:border-slate-700">
                                <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 font-medium">Belum ada siswa yang mengumpulkan tugas.
                            </p>
                        </div>
                    @endif
                </div>

                @if($notSubmitted->count() > 0)
                    <div class="bg-slate-50/50 dark:bg-slate-800/30 p-6 border-t border-slate-200 dark:border-slate-700/50">
                        <h3 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-4">Belum
                            Mengumpulkan ({{ $notSubmitted->count() }})</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($notSubmitted as $student)
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700 shadow-sm">
                                    {{ $student->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Grade Modal - Fullscreen Centered --}}
        <div id="gradeModal"
            class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 backdrop-blur-xl transition-opacity opacity-0"
            style="background: rgba(15, 23, 42, 0.85);" aria-hidden="true">

            {{-- Close Button --}}
            <button onclick="closeGradeModal()"
                class="absolute top-6 right-6 w-14 h-14 rounded-full bg-white/10 hover:bg-red-500/80 text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 backdrop-blur-md border border-white/20 shadow-lg hover:shadow-red-500/30 group">
                <svg class="w-7 h-7 transition-transform duration-300 group-hover:scale-110" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div id="gradeModalContent"
                class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl max-w-md w-full p-8 border border-slate-100 dark:border-slate-800 transform scale-95 transition-all duration-300 relative overflow-hidden"
                style="box-shadow: 0 0 80px rgba(16, 185, 129, 0.2), 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
                {{-- Decorative Blur --}}
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl -mr-10 -mt-10 pointer-events-none">
                </div>

                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1 relative z-10">Beri Nilai</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 relative z-10">Siswa: <span id="studentName"
                        class="font-bold text-emerald-600 dark:text-emerald-400"></span></p>

                <form id="gradeForm" method="POST" class="space-y-5 relative z-10">
                    @csrf
                    <div>
                        <label for="score" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Nilai
                            (Maks: {{ $assignment->max_score }})</label>
                        <input type="number" id="score" name="score"
                            class="input-glossy block w-full px-4 py-3 rounded-xl text-slate-900 dark:text-white border border-slate-200 dark:border-slate-700 outline-none"
                            min="0" max="{{ $assignment->max_score }}" required>
                    </div>
                    <div>
                        <label for="feedback"
                            class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Feedback /
                            Komentar</label>
                        <textarea id="feedback" name="feedback" rows="3"
                            class="input-glossy block w-full px-4 py-3 rounded-xl text-slate-900 dark:text-white resize-none border border-slate-200 dark:border-slate-700 outline-none"
                            placeholder="Berikan masukan untuk siswa..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <button type="button" onclick="closeGradeModal()"
                            class="px-5 py-2.5 rounded-xl text-sm font-bold text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 transition-all shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50">
                            Simpan Nilai
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Submission View Modal --}}
        <div id="submissionModal"
            class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 backdrop-blur-xl transition-opacity opacity-0"
            style="background: rgba(15, 23, 42, 0.85);" aria-hidden="true">

            {{-- Close Button --}}
            <button onclick="closeSubmissionModal()"
                class="absolute top-6 right-6 w-14 h-14 rounded-full bg-white/10 hover:bg-red-500/80 text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 backdrop-blur-md border border-white/20 shadow-lg hover:shadow-red-500/30 group">
                <svg class="w-7 h-7 transition-transform duration-300 group-hover:scale-110" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div id="submissionModalContent"
                class="bg-white dark:bg-slate-900 rounded-[2rem] shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-hidden border border-slate-100 dark:border-slate-800 transform scale-95 transition-all duration-300 flex flex-col">
                {{-- Header --}}
                <div
                    class="p-6 border-b border-slate-100 dark:border-slate-800 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Kiriman Tugas</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Dari: <span id="submissionStudentName"
                                    class="font-bold text-blue-600 dark:text-blue-400"></span></p>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 overflow-y-auto flex-1">
                    {{-- File Display --}}
                    <div id="submissionFileContent" class="hidden">
                        <div
                            class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700">
                            <div
                                class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p id="submissionFileName" class="font-bold text-slate-800 dark:text-white"></p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">File yang dikumpulkan siswa</p>
                            </div>
                            <a id="submissionFileLink" href="#" target="_blank" download
                                class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm transition-colors shadow-lg shadow-blue-500/30 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>

                    {{-- Link Display --}}
                    <div id="submissionLinkContent" class="hidden">
                        <div
                            class="p-4 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-200 dark:border-purple-800">
                            <p class="text-xs font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider mb-2">
                                Link Eksternal</p>
                            <a id="submissionLink" href="#" target="_blank"
                                class="inline-flex items-center gap-2 text-purple-700 dark:text-purple-300 hover:text-purple-900 dark:hover:text-purple-100 font-medium break-all transition-colors">
                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                <span id="submissionLinkText"></span>
                            </a>
                        </div>
                    </div>

                    {{-- Text Content Display --}}
                    <div id="submissionTextContent" class="hidden">
                        <p class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider mb-3">
                            Jawaban Teks</p>
                        <div
                            class="p-5 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-200 dark:border-slate-700 max-h-[400px] overflow-y-auto">
                            <pre id="submissionText"
                                class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap font-sans leading-relaxed text-sm"></pre>
                        </div>
                    </div>

                    {{-- Empty State --}}
                    <div id="submissionEmptyContent" class="hidden">
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div
                                class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 font-medium">Tidak ada konten yang ditampilkan.</p>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30">
                    <button onclick="closeSubmissionModal()"
                        class="w-full px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const gradeModal = document.getElementById('gradeModal');
        const gradeModalContent = document.getElementById('gradeModalContent');

        function openGradeModal(submissionId, studentName, score, feedback) {
            document.getElementById('gradeForm').action = '/teacher/classrooms/{{ $classroom->id }}/assignments/{{ $assignment->id }}/submissions/' + submissionId + '/grade';
            document.getElementById('studentName').textContent = studentName;
            document.getElementById('score').value = score || '';
            document.getElementById('feedback').value = feedback || '';

            gradeModal.classList.remove('hidden');
            gradeModal.classList.add('flex');

            // Small delay to allow display:flex to apply before opacity transition
            requestAnimationFrame(() => {
                gradeModal.classList.remove('opacity-0');
                gradeModalContent.classList.remove('scale-95');
                gradeModalContent.classList.add('scale-100');
            });
        }

        function closeGradeModal() {
            gradeModal.classList.add('opacity-0');
            gradeModalContent.classList.remove('scale-100');
            gradeModalContent.classList.add('scale-95');

            setTimeout(() => {
                gradeModal.classList.add('hidden');
                gradeModal.classList.remove('flex');
            }, 300); // Match transition duration
        }

        // Close on click outside
        gradeModal.addEventListener('click', function (e) {
            if (e.target === gradeModal) {
                closeGradeModal();
            }
        });

        // Submission Modal Functions
        const submissionModal = document.getElementById('submissionModal');
        const submissionModalContent = document.getElementById('submissionModalContent');

        function openSubmissionModal(studentName, filePath, fileName, externalLink, textContent) {
            // Set student name
            document.getElementById('submissionStudentName').textContent = studentName;

            // Hide all content sections first
            document.getElementById('submissionFileContent').classList.add('hidden');
            document.getElementById('submissionLinkContent').classList.add('hidden');
            document.getElementById('submissionTextContent').classList.add('hidden');
            document.getElementById('submissionEmptyContent').classList.add('hidden');

            // Show appropriate content
            if (filePath) {
                document.getElementById('submissionFileName').textContent = fileName || 'File Tugas';
                document.getElementById('submissionFileLink').href = filePath;
                document.getElementById('submissionFileContent').classList.remove('hidden');
            } else if (externalLink) {
                document.getElementById('submissionLink').href = externalLink;
                document.getElementById('submissionLinkText').textContent = externalLink;
                document.getElementById('submissionLinkContent').classList.remove('hidden');
            } else if (textContent) {
                document.getElementById('submissionText').textContent = textContent;
                document.getElementById('submissionTextContent').classList.remove('hidden');
            } else {
                document.getElementById('submissionEmptyContent').classList.remove('hidden');
            }

            // Show modal with animation
            submissionModal.classList.remove('hidden');
            submissionModal.classList.add('flex');

            requestAnimationFrame(() => {
                submissionModal.classList.remove('opacity-0');
                submissionModalContent.classList.remove('scale-95');
                submissionModalContent.classList.add('scale-100');
            });
        }

        function closeSubmissionModal() {
            submissionModal.classList.add('opacity-0');
            submissionModalContent.classList.remove('scale-100');
            submissionModalContent.classList.add('scale-95');

            setTimeout(() => {
                submissionModal.classList.add('hidden');
                submissionModal.classList.remove('flex');
            }, 300);
        }

        // Close submission modal on click outside
        submissionModal.addEventListener('click', function (e) {
            if (e.target === submissionModal) {
                closeSubmissionModal();
            }
        });

        // Close modals on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                if (!gradeModal.classList.contains('hidden')) {
                    closeGradeModal();
                }
                if (!submissionModal.classList.contains('hidden')) {
                    closeSubmissionModal();
                }
            }
        });
    </script>
@endsection