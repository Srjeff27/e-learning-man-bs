@extends('layouts.lms')

@section('title', $assignment->title)

@section('content')
    <div class="mb-6">
        <a href="{{ route('student.classrooms.show', $classroom) }}"
            class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke {{ $classroom->name }}
        </a>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <!-- Assignment Details -->
            <div class="bg-white rounded-xl shadow-sm border p-6 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">{{ $assignment->title }}</h1>
                        <p class="text-gray-500">{{ $classroom->name }}</p>
                    </div>
                    <span class="badge {{ $assignment->isOverdue() ? 'badge-danger' : 'badge-primary' }}">
                        {{ $assignment->isOverdue() ? 'Terlambat' : 'Aktif' }}
                    </span>
                </div>

                @if($assignment->description)
                    <div class="prose max-w-none mb-6">
                        {!! nl2br(e($assignment->description)) !!}
                    </div>
                @endif

                @if($assignment->instructions)
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <h3 class="font-medium text-slate-900 mb-2">Petunjuk Pengerjaan</h3>
                        <div class="text-sm text-gray-600">
                            {!! nl2br(e($assignment->instructions)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Submission Form -->
            @if(!$submission || $submission->status === 'draft')
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <h2 class="font-semibold text-slate-900 mb-4">Kumpulkan Tugas</h2>

                    <form action="{{ route('student.assignments.submit', [$classroom, $assignment]) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-4">
                        @csrf

                        @if(in_array($assignment->submission_type, ['text', 'multiple']))
                            <div>
                                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Jawaban</label>
                                <textarea id="content" name="content" rows="6" class="input"
                                    placeholder="Tulis jawaban Anda di sini...">{{ old('content', $submission->content ?? '') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if(in_array($assignment->submission_type, ['file', 'multiple']))
                            <div>
                                <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Upload File</label>
                                <input type="file" id="file" name="file" class="input">
                                @if($submission && $submission->file_name)
                                    <p class="text-sm text-gray-500 mt-1">File sebelumnya: {{ $submission->file_name }}</p>
                                @endif
                                @error('file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        @if(in_array($assignment->submission_type, ['link', 'multiple']))
                            <div>
                                <label for="external_link" class="block text-sm font-medium text-gray-700 mb-1">Link URL</label>
                                <input type="url" id="external_link" name="external_link"
                                    value="{{ old('external_link', $submission->external_link ?? '') }}" class="input"
                                    placeholder="https://...">
                                @error('external_link')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="pt-4 border-t">
                            <button type="submit" class="btn btn-primary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Kumpulkan Tugas
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <!-- Submission Status -->
                <div class="bg-white rounded-xl shadow-sm border p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-slate-900">Status Pengumpulan</h2>
                        <span class="badge {{ $submission->status === 'graded' ? 'badge-success' : 'badge-primary' }}">
                            {{ $submission->status === 'graded' ? 'Sudah Dinilai' : 'Dikumpulkan' }}
                        </span>
                    </div>

                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Waktu Pengumpulan</dt>
                            <dd>{{ $submission->submitted_at->format('d M Y H:i') }}</dd>
                        </div>
                        @if($submission->is_late)
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Status</dt>
                                <dd class="text-red-600">Terlambat</dd>
                            </div>
                        @endif
                        @if($submission->status === 'graded')
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Nilai</dt>
                                <dd class="font-bold text-lg text-green-600">{{ $submission->score }}/{{ $assignment->max_score }}
                                </dd>
                            </div>
                            @if($submission->feedback)
                                <div class="pt-3 border-t">
                                    <dt class="text-gray-500 mb-1">Feedback dari Guru</dt>
                                    <dd class="bg-gray-50 rounded p-3">{{ $submission->feedback }}</dd>
                                </div>
                            @endif
                        @endif
                    </dl>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-slate-900 mb-4">Detail Tugas</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Deadline</dt>
                        <dd class="{{ $assignment->isOverdue() ? 'text-red-600' : '' }}">
                            {{ $assignment->due_date ? $assignment->due_date->format('d M Y H:i') : 'Tidak ada' }}
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Nilai Maks</dt>
                        <dd>{{ $assignment->max_score }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Tipe Pengumpulan</dt>
                        <dd>{{ ucfirst($assignment->submission_type) }}</dd>
                    </div>
                    @if($assignment->allow_late_submission)
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Penalti Terlambat</dt>
                            <dd>{{ $assignment->late_penalty_percent }}%</dd>
                        </div>
                    @endif
                </dl>
            </div>
        </div>
    </div>
@endsection