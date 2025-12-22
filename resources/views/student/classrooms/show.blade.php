@extends('layouts.lms')

@section('title', $classroom->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('student.classrooms.index') }}"
            class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Kelas Saya
        </a>
    </div>

    <!-- Class Header -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl p-6 text-white mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold mb-1">{{ $classroom->name }}</h1>
                <p class="text-blue-100">{{ $classroom->subject }} • {{ $classroom->grade }} • {{ $classroom->semester }}
                </p>
                <p class="text-blue-200 text-sm mt-2">Guru: {{ $classroom->teacher->name }}</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Announcements -->
            @if($classroom->announcements->isNotEmpty())
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                    <h3 class="font-semibold text-yellow-800 mb-2">📢 Pengumuman Terbaru</h3>
                    @foreach($classroom->announcements as $announcement)
                        <div class="bg-white rounded-lg p-3 mb-2 last:mb-0">
                            <p class="font-medium">{{ $announcement->title }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 150) }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Materials -->
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="px-6 py-4 border-b">
                    <h2 class="font-semibold text-slate-900">Materi Pembelajaran</h2>
                </div>
                <div class="divide-y">
                    @forelse($classroom->materials as $material)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    @if($material->type === 'file')
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h7" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-medium text-slate-900">{{ $material->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $material->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            @if($material->file_path)
                                <a href="{{ Storage::url($material->file_path) }}" target="_blank"
                                    class="btn btn-secondary text-sm">Download</a>
                            @endif
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            Belum ada materi
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Assignments -->
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="px-6 py-4 border-b">
                    <h2 class="font-semibold text-slate-900">Tugas</h2>
                </div>
                <div class="divide-y">
                    @forelse($assignments as $assignment)
                        <a href="{{ route('student.assignments.show', [$classroom, $assignment]) }}"
                            class="block px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-slate-900">{{ $assignment->title }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Deadline:
                                        {{ $assignment->due_date ? $assignment->due_date->format('d M Y H:i') : 'Tidak ada' }}
                                    </p>
                                </div>
                                <div>
                                    @if($assignment->submission)
                                        @if($assignment->submission->status === 'graded')
                                            <span class="badge badge-success">Dinilai:
                                                {{ $assignment->submission->score }}/{{ $assignment->max_score }}</span>
                                        @elseif($assignment->submission->status === 'submitted')
                                            <span class="badge badge-primary">Dikumpulkan</span>
                                        @else
                                            <span class="badge badge-warning">Draft</span>
                                        @endif
                                    @else
                                        @if($assignment->isOverdue())
                                            <span class="badge badge-danger">Terlambat</span>
                                        @else
                                            <span class="badge badge-warning">Belum dikumpulkan</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            Belum ada tugas
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Class Info -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <h3 class="font-semibold text-slate-900 mb-4">Informasi Kelas</h3>
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Guru</dt>
                        <dd class="font-medium">{{ $classroom->teacher->name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Tahun Ajaran</dt>
                        <dd>{{ $classroom->academic_year ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Semester</dt>
                        <dd>{{ $classroom->semester ?? '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-6 pt-4 border-t">
                    <form action="{{ route('student.classrooms.leave', $classroom) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin keluar dari kelas ini?')">
                        @csrf
                        <button type="submit" class="w-full text-center text-sm text-red-600 hover:text-red-700">
                            Keluar dari Kelas
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection