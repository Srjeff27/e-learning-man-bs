@extends('layouts.teacher')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Guru')

@section('content')
    <div class="space-y-6">
        {{-- Welcome Card --}}
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}! 👋</h2>
            <p class="text-emerald-100">Kelola kelas dan pantau perkembangan siswa Anda dengan mudah.</p>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Kelas</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['classrooms'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Siswa</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['students'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Tugas</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['assignments'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Menunggu Dinilai</p>
                        <p class="text-3xl font-bold text-orange-600">{{ $stats['pending_submissions'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            {{-- My Classes --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-5 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Kelas Saya</h3>
                        <a href="{{ route('teacher.classrooms.index') }}"
                            class="text-sm text-emerald-600 hover:text-emerald-800">Lihat Semua</a>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($classrooms->take(4) as $classroom)
                        <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                            class="block p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-lg flex items-center justify-center text-white font-bold">
                                        {{ strtoupper(substr($classroom->subject ?? $classroom->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $classroom->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $classroom->students_count }} siswa</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs rounded-full {{ $classroom->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $classroom->status === 'active' ? 'Aktif' : 'Arsip' }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <p>Belum ada kelas</p>
                            <a href="{{ route('teacher.classrooms.create') }}"
                                class="text-emerald-600 text-sm mt-2 inline-block">Buat Kelas Baru</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pending Submissions --}}
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-5 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-gray-900">Tugas Menunggu Penilaian</h3>
                    </div>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($recentSubmissions as $submission)
                        <a href="{{ route('teacher.assignments.show', [$submission->assignment->classroom_id, $submission->assignment_id]) }}"
                            class="block p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $submission->student->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $submission->assignment->title }}</p>
                                </div>
                                <span class="text-xs text-gray-400">
                                    {{ $submission->submitted_at ? $submission->submitted_at->diffForHumans() : '' }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            <svg class="w-12 h-12 text-green-300 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p>Semua tugas sudah dinilai! 🎉</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection