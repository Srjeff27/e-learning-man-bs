@extends('layouts.teacher')

@section('title', $assignment->title)

@section('content')
    <div class="max-w-4xl">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke {{ $classroom->name }}
            </a>
            <a href="{{ route('teacher.assignments.edit', [$classroom, $assignment]) }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
        </div>

        {{-- Assignment Details --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $assignment->title }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Dibuat {{ $assignment->created_at->format('d M Y H:i') }}
                    </p>
                </div>
                <span
                    class="px-3 py-1 rounded-full text-sm font-medium {{ $assignment->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ $assignment->is_published ? 'Dipublikasikan' : 'Draft' }}
                </span>
            </div>

            @if($assignment->description)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-1">Deskripsi</h3>
                    <p class="text-gray-600">{{ $assignment->description }}</p>
                </div>
            @endif

            @if($assignment->instructions)
                <div class="mb-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-1">Instruksi</h3>
                    <div class="text-gray-600 prose prose-sm max-w-none">
                        {!! nl2br(e($assignment->instructions)) !!}
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-xs text-gray-500">Nilai Maksimal</p>
                    <p class="text-lg font-bold text-slate-900">{{ $assignment->max_score }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Deadline</p>
                    <p class="text-lg font-bold text-slate-900">
                        {{ $assignment->due_date ? $assignment->due_date->format('d M Y H:i') : '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Tipe Pengumpulan</p>
                    <p class="text-lg font-bold text-slate-900 capitalize">{{ $assignment->submission_type }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Terlambat</p>
                    <p class="text-lg font-bold text-slate-900">
                        {{ $assignment->allow_late_submission ? 'Diizinkan (-' . $assignment->late_penalty_percent . '%)' : 'Tidak' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Submissions --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-slate-900 mb-4">
                Pengumpulan Tugas ({{ $submissions->count() }}/{{ $classroom->students->count() }})
            </h2>

            @if($submissions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Siswa</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($submissions as $submission)
                                <tr>
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-slate-900">{{ $submission->student->name }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">
                                        {{ $submission->submitted_at->format('d M Y H:i') }}
                                        @if($assignment->due_date && $submission->submitted_at->gt($assignment->due_date))
                                            <span class="text-red-500 text-xs">(Terlambat)</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="px-2 py-1 rounded-full text-xs font-medium
                                                                    {{ $submission->status === 'graded' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ $submission->status === 'graded' ? 'Dinilai' : 'Belum Dinilai' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 font-medium">
                                        {{ $submission->score !== null ? $submission->score . '/' . $assignment->max_score : '-' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <button type="button"
                                            onclick="openGradeModal({{ $submission->id }}, '{{ $submission->student->name }}', {{ $submission->score ?? 'null' }}, '{{ $submission->feedback ?? '' }}')"
                                            class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            {{ $submission->status === 'graded' ? 'Edit Nilai' : 'Beri Nilai' }}
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Belum ada siswa yang mengumpulkan tugas.</p>
            @endif

            @if($notSubmitted->count() > 0)
                <div class="mt-6 pt-6 border-t">
                    <h3 class="text-sm font-medium text-gray-700 mb-3">Belum Mengumpulkan ({{ $notSubmitted->count() }})</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($notSubmitted as $student)
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-sm">{{ $student->name }}</span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Grade Modal --}}
    <div id="gradeModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Beri Nilai - <span id="studentName"></span></h3>
            <form id="gradeForm" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="score" class="block text-sm font-medium text-gray-700 mb-1">Nilai
                            (0-{{ $assignment->max_score }})</label>
                        <input type="number" id="score" name="score" class="input" min="0"
                            max="{{ $assignment->max_score }}" required>
                    </div>
                    <div>
                        <label for="feedback" class="block text-sm font-medium text-gray-700 mb-1">Feedback</label>
                        <textarea id="feedback" name="feedback" rows="3" class="input"
                            placeholder="Berikan komentar atau masukan..."></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeGradeModal()" class="btn btn-secondary">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openGradeModal(submissionId, studentName, score, feedback) {
            document.getElementById('gradeForm').action = '{{ route("teacher.assignments.grade", [$classroom->id, $assignment->id, ""]) }}/' + submissionId;
            document.getElementById('studentName').textContent = studentName;
            document.getElementById('score').value = score || '';
            document.getElementById('feedback').value = feedback || '';
            document.getElementById('gradeModal').classList.remove('hidden');
            document.getElementById('gradeModal').classList.add('flex');
        }

        function closeGradeModal() {
            document.getElementById('gradeModal').classList.add('hidden');
            document.getElementById('gradeModal').classList.remove('flex');
        }
    </script>
@endsection