@extends('layouts.student')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    <div class="space-y-8 animate-fade-in">
        {{-- Welcome Card --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-green-600 p-8 text-white shadow-xl shadow-emerald-500/20">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-64 w-64 rounded-full bg-black/10 blur-3xl"></div>

            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-3">
                        <h2 class="text-3xl md:text-3xl font-bold tracking-tight">Selamat datang, <span
                                class="text-emerald-100">{{ auth()->user()->name }}</span>! 👋</h2>
                        <p class="text-emerald-50 text-lg opacity-90 max-w-2xl">Lanjutkan perjalanan belajar Anda menuju
                            prestasi
                            gemilang bersama MAN Bengkulu Selatan.</p>
                    </div>
                </div>
                <div class="mt-6 pt-6 border-t border-white/20">
                    <p class="text-emerald-50 opacity-80 flex items-center text-sm font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="font-semibold mr-1">Hari ini:</span> {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div
                class="glass-card p-6 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Kelas Terdaftar</p>
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

            <div
                class="glass-card p-6 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Tugas Pending</p>
                    <p class="text-3xl font-bold text-orange-500 mt-1">{{ $stats['assignments_pending'] }}</p>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-500 to-amber-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div
                class="glass-card p-6 flex items-center justify-between group hover:scale-[1.02] transition-transform duration-300">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Tugas Selesai</p>
                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">
                        {{ $stats['assignments_completed'] }}</p>
                </div>
                <div
                    class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center text-white shadow-lg shadow-green-500/30 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-8 animate-slide-up">
            {{-- Upcoming Assignments --}}
            <div class="glass-card overflow-hidden h-full flex flex-col">
                <div
                    class="p-6 border-b border-slate-200/50 dark:border-slate-700/50 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tugas Mendatang
                    </h3>
                    <a href="{{ route('student.assignments.index') }}"
                        class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                        Lihat Semua
                    </a>
                </div>
                <div class="p-4 flex-1">
                    @forelse($upcomingAssignments as $assignment)
                        <a href="{{ route('student.assignments.show', [$assignment->classroom_id, $assignment]) }}"
                            class="group block p-4 rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-300 mb-2 last:mb-0">
                            <div class="flex items-center justify-between">
                                <div class="space-y-1">
                                    <p
                                        class="font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                                        {{ $assignment->title }}
                                    </p>
                                    <div class="flex items-center space-x-3 text-sm text-slate-500 dark:text-slate-400">
                                        <span>{{ $assignment->classroom->name ?? 'Kelas' }}</span>
                                        @if($assignment->due_date)
                                            <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-600"></span>
                                            <span>
                                                Tenggat: {{ $assignment->due_date->format('d M') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if($assignment->due_date)
                                        <span
                                            class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $assignment->due_date->isPast() ? 'bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400' : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' }}">
                                            {{ $assignment->due_date->isPast() ? 'Terlambat' : 'Aktif' }}
                                        </span>
                                    @endif
                                </div>
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
                            <p class="font-medium">Tidak ada tugas mendatang</p>
                            <p class="text-sm mt-1 opacity-75">Santai sejenak! ☕</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- My Classes --}}
            <div class="glass-card overflow-hidden h-full flex flex-col">
                <div
                    class="p-6 border-b border-slate-200/50 dark:border-slate-700/50 flex items-center justify-between bg-slate-50/50 dark:bg-slate-800/50">
                    <h3 class="font-bold text-lg text-slate-800 dark:text-white flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Kelas Saya
                    </h3>
                    <a href="{{ route('student.classrooms.index') }}"
                        class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                        Lihat Semua
                    </a>
                </div>
                <div class="p-4 flex-1">
                    @forelse($classrooms->take(4) as $classroom)
                        <a href="{{ route('student.classrooms.show', $classroom) }}"
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
                                            {{ $classroom->name }}
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">
                                            {{ $classroom->teacher->name ?? 'Guru' }}</p>
                                    </div>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
                                    {{ $classroom->subject ?? 'Mapel' }}
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
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <p class="mb-2">Belum ada kelas</p>
                            <a href="{{ route('student.classrooms.index') }}"
                                class="text-emerald-600 font-semibold hover:underline">Gabung Kelas</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection