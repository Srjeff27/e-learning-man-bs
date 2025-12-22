@extends('layouts.lms')

@section('title', $classroom->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('teacher.classrooms.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Kelas Saya
        </a>
    </div>
    
    <!-- Class Header -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl p-6 text-white mb-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold mb-1">{{ $classroom->name }}</h1>
                <p class="text-green-100">{{ $classroom->subject }} • {{ $classroom->grade }} • {{ $classroom->semester }}</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="bg-white/20 rounded-lg px-4 py-2 text-center">
                    <div class="text-2xl font-bold">{{ $classroom->code }}</div>
                    <div class="text-xs text-green-100">Kode Kelas</div>
                </div>
                <a href="{{ route('teacher.classrooms.edit', $classroom) }}" class="btn bg-white/20 hover:bg-white/30 text-white border-0">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>
    
    <!-- Stats Row -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-slate-900">{{ $classroom->students->count() }}</div>
            <div class="text-sm text-gray-500">Siswa</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-slate-900">{{ $classroom->materials->count() }}</div>
            <div class="text-sm text-gray-500">Materi</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-slate-900">{{ $assignments->count() }}</div>
            <div class="text-sm text-gray-500">Tugas</div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border p-4 text-center">
            <div class="text-2xl font-bold text-slate-900">{{ $classroom->announcements->count() }}</div>
            <div class="text-sm text-gray-500">Pengumuman</div>
        </div>
    </div>
    
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Quick Actions -->
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('teacher.materials.create', $classroom) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Materi
                </a>
                <a href="{{ route('teacher.assignments.create', $classroom) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Buat Tugas
                </a>
                <a href="{{ route('teacher.classrooms.members', $classroom) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Kelola Siswa
                </a>
            </div>
            
            <!-- Materials -->
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h2 class="font-semibold text-slate-900">Materi Pembelajaran</h2>
                </div>
                <div class="divide-y">
                    @forelse($classroom->materials as $material)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    @if($material->type === 'file')
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    @elseif($material->type === 'video')
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-medium text-slate-900">{{ $material->title }}</h3>
                                    <p class="text-sm text-gray-500">{{ $material->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('teacher.materials.edit', [$classroom, $material]) }}" class="p-2 text-gray-400 hover:text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            Belum ada materi. <a href="{{ route('teacher.materials.create', $classroom) }}" class="text-green-600 hover:underline">Tambah materi pertama</a>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Assignments -->
            <div class="bg-white rounded-xl shadow-sm border">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h2 class="font-semibold text-slate-900">Tugas</h2>
                </div>
                <div class="divide-y">
                    @forelse($assignments as $assignment)
                        <a href="{{ route('teacher.assignments.show', [$classroom, $assignment]) }}" class="block px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-medium text-slate-900">{{ $assignment->title }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Deadline: {{ $assignment->due_date ? $assignment->due_date->format('d M Y H:i') : 'Tidak ada' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-gray-600">{{ $assignment->submissions()->submitted()->count() }}/{{ $classroom->students->count() }}</div>
                                    <div class="text-xs text-gray-400">dikumpulkan</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">
                            Belum ada tugas. <a href="{{ route('teacher.assignments.create', $classroom) }}" class="text-green-600 hover:underline">Buat tugas pertama</a>
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
                        <dt class="text-gray-500">Kode Kelas</dt>
                        <dd class="font-mono font-medium">{{ $classroom->code }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Tahun Ajaran</dt>
                        <dd>{{ $classroom->academic_year ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Status</dt>
                        <dd>
                            <span class="badge {{ $classroom->status === 'active' ? 'badge-success' : 'badge-warning' }}">
                                {{ $classroom->status === 'active' ? 'Aktif' : 'Diarsipkan' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
            
            <!-- Recent Students -->
            <div class="bg-white rounded-xl shadow-sm border p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-slate-900">Siswa Terdaftar</h3>
                    <span class="text-sm text-gray-500">{{ $classroom->students->count() }}</span>
                </div>
                <div class="space-y-3">
                    @forelse($classroom->students->take(5) as $student)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <span class="text-sm">{{ $student->name }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada siswa terdaftar</p>
                    @endforelse
                </div>
                @if($classroom->students->count() > 5)
                    <a href="{{ route('teacher.classrooms.members', $classroom) }}" class="text-sm text-green-600 hover:underline mt-4 block">
                        Lihat semua →
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection
