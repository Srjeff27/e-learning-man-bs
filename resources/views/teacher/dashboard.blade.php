@extends('layouts.teacher')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Guru')

@section('content')
    <div class="space-y-8 animate-fade-in">
        {{-- Welcome Card --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 p-8 text-white shadow-xl shadow-emerald-500/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-64 w-64 rounded-full bg-black/10 blur-3xl"></div>

            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-2">Selamat datang, {{ auth()->user()->name }}! 👋</h2>
                <p class="text-emerald-100 text-lg max-w-2xl">Kelola kelas, pantau perkembangan siswa, dan periksa tugas
                    dengan mudah dalam satu tempat.</p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Stat 1: Total Kelas --}}
            <div
                class="glass-card p-6 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Kelas</p>
                    <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $stats['classrooms'] }}</p>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
            </div>

            {{-- Stat 2: Total Siswa --}}
            <div
                class="glass-card p-6 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Siswa</p>
                    <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $stats['students'] }}</p>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>

            {{-- Stat 3: Total Tugas --}}
            <div
                class="glass-card p-6 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Total Tugas</p>
                    <p class="text-3xl font-bold text-slate-800 dark:text-white mt-1">{{ $stats['assignments'] }}</p>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white shadow-lg shadow-purple-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>

            {{-- Stat 4: Menunggu Dinilai --}}
            <div
                class="glass-card p-6 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Perlu Dinilai</p>
                    <p class="text-3xl font-bold text-orange-500 mt-1">{{ $stats['pending_submissions'] }}</p>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 animate-slide-up">
            {{-- My Classes --}}
            <div class="glass-card overflow-hidden h-full flex flex-col">
                <div
                    class="p-6 border-b border-slate-200/50 dark:border-slate-700/50 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white">Kelas Terbaru</h3>
                    <a href="{{ route('teacher.classrooms.index') }}"
                        class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">Lihat
                        Semua</a>
                </div>
                <div class="p-4 flex-1">
                    @forelse($classrooms->take(4) as $classroom)
                        <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                            class="group block p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-300 mb-2 last:mb-0">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                                        {{ strtoupper(substr($classroom->subject ?? $classroom->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p
                                            class="font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                            {{ $classroom->name }}</p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $classroom->students_count }}
                                            Siswa</p>
                                    </div>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $classroom->status === 'active' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400' }}">
                                    {{ $classroom->status === 'active' ? 'Aktif' : 'Arsip' }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div
                            class="flex flex-col items-center justify-center py-12 text-center text-slate-500 dark:text-slate-400">
                            <div
                                class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <p class="mb-2">Belum ada kelas</p>
                            <a href="{{ route('teacher.classrooms.create') }}"
                                class="text-emerald-600 font-semibold hover:underline">Buat Kelas Baru</a>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Pending Submissions --}}
            <div class="glass-card overflow-hidden h-full flex flex-col">
                <div
                    class="p-6 border-b border-slate-200/50 dark:border-slate-700/50 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white">Butuh Penilaian</h3>
                </div>
                <div class="p-4 flex-1">
                    @forelse($recentSubmissions as $submission)
                        <a href="{{ route('teacher.assignments.show', [$submission->assignment->classroom_id, $submission->assignment_id]) }}"
                            class="group block p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-300 mb-2 last:mb-0">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-lg font-bold text-slate-600 dark:text-slate-300">
                                        {{ strtoupper(substr($submission->student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p
                                            class="font-bold text-slate-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                            {{ $submission->student->name }}</p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 line-clamp-1">
                                            {{ $submission->assignment->title }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-medium text-slate-400">
                                    {{ $submission->submitted_at ? $submission->submitted_at->diffForHumans() : '' }}
                                </span>
                            </div>
                        </a>
                    @empty
                        <div
                            class="flex flex-col items-center justify-center py-12 text-center text-slate-500 dark:text-slate-400">
                            <div
                                class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/10 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-emerald-500/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="font-medium">Semua tugas sudah dinilai! 🎉</p>
                            <p class="text-sm mt-1 opacity-75">Kerja bagus, Pak/Bu Guru!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection