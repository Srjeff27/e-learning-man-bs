@extends('layouts.teacher')

@section('title', 'Absensi Kelas')
@section('page-title', 'Absensi Kelas')

@push('styles')
    <style>
        .animate-enter {
            animation: enter 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        @keyframes enter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        .dark .glass-card {
            background: rgba(20, 30, 25, 0.65);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
@endpush

@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="animate-enter">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white">
                <h2 class="text-2xl font-bold mb-2">Absensi Kelas 📋</h2>
                <p class="text-emerald-100">Kelola kehadiran siswa di setiap pertemuan kelas Anda.</p>
            </div>
        </div>

        {{-- Classrooms Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 animate-enter delay-100">
            @forelse($classrooms as $classroom)
                <a href="{{ route('teacher.attendance.index', $classroom) }}"
                    class="glass-card rounded-2xl p-6 hover:-translate-y-1 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-start gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                            {{ strtoupper(substr($classroom->subject ?? $classroom->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3
                                class="font-bold text-slate-800 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors truncate">
                                {{ $classroom->name }}
                            </h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400 truncate">
                                {{ $classroom->subject ?? 'Mata Pelajaran' }}</p>
                        </div>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-3">
                        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-3 text-center">
                            <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $classroom->students_count }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Siswa</p>
                        </div>
                        <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-3 text-center">
                            <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                                {{ $classroom->attendance_sessions_count }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Pertemuan</p>
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-between text-xs text-slate-400">
                        <span>{{ $classroom->grade }} • {{ $classroom->semester }}</span>
                        <span class="text-emerald-600 font-semibold group-hover:underline">Lihat →</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full glass-card rounded-2xl p-12 text-center">
                    <div
                        class="w-20 h-20 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white mb-2">Belum Ada Kelas</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-4">Buat kelas terlebih dahulu untuk mulai mengabsen.</p>
                    <a href="{{ route('teacher.classrooms.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white rounded-xl font-semibold hover:bg-emerald-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Kelas
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection