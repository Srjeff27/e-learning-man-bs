@extends('layouts.teacher')

@section('title', 'Detail Pertemuan ' . $session->session_number . ' - ' . $classroom->name)
@section('page-title', 'Detail Absensi')

@push('styles')
    <style>
        .animate-enter {
            animation: enter 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes enter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
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
        {{-- Breadcrumb --}}
        <div class="animate-enter">
            <a href="{{ route('teacher.attendance.index', $classroom) }}"
                class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                <div
                    class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-300 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                Kembali ke Daftar Pertemuan
            </a>
        </div>

        {{-- Header --}}
        <div class="animate-enter bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-6 text-white">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-sm font-bold">Pertemuan
                            {{ $session->session_number }}</span>
                        <span class="text-emerald-100">{{ $session->date->translatedFormat('l, d F Y') }}</span>
                    </div>
                    <h1 class="text-2xl font-bold">{{ $session->topic }}</h1>
                    <p class="text-emerald-100 mt-1">{{ $classroom->name }}</p>
                </div>
                <a href="{{ route('teacher.attendance.take', [$classroom, $session]) }}"
                    class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl text-white font-semibold flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Absensi
                </a>
            </div>
        </div>

        {{-- Summary Stats --}}
        @php $summary = $session->summary; @endphp
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 animate-enter" style="animation-delay: 0.1s;">
            <div class="glass-card rounded-xl p-4 text-center">
                <p class="text-2xl font-bold text-slate-800 dark:text-white">{{ $students->count() }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Total Siswa</p>
            </div>
            <div class="glass-card rounded-xl p-4 text-center bg-green-50/50 dark:bg-green-900/20">
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $summary['hadir'] }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Hadir</p>
            </div>
            <div class="glass-card rounded-xl p-4 text-center bg-blue-50/50 dark:bg-blue-900/20">
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $summary['izin'] }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Izin</p>
            </div>
            <div class="glass-card rounded-xl p-4 text-center bg-yellow-50/50 dark:bg-yellow-900/20">
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $summary['sakit'] }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Sakit</p>
            </div>
            <div class="glass-card rounded-xl p-4 text-center bg-red-50/50 dark:bg-red-900/20">
                <p class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $summary['alpha'] }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Alpha</p>
            </div>
        </div>

        {{-- Attendance List --}}
        <div class="glass-card rounded-2xl overflow-hidden animate-enter" style="animation-delay: 0.2s;">
            <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700/50">
                <h2 class="font-bold text-lg text-slate-800 dark:text-white">Daftar Kehadiran</h2>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                @forelse($students as $index => $student)
                    @php
                        $attendance = $attendances->get($student->id);
                        $status = $attendance?->status ?? '-';
                        $statusData = \App\Models\Attendance::STATUSES[$status] ?? ['label' => 'Belum Absen', 'color' => 'gray', 'icon' => '-'];
                    @endphp
                    <div class="p-4 md:p-5 hover:bg-white/60 dark:hover:bg-slate-800/50 transition-colors">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-400 font-medium text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 dark:text-white">{{ $student->name }}</p>
                                    @if($attendance?->notes)
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $attendance->notes }}</p>
                                    @endif
                                </div>
                            </div>
                            <span
                                class="px-3 py-1.5 rounded-lg text-sm font-bold
                                    {{ $status === 'hadir' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                    {{ $status === 'izin' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                    {{ $status === 'sakit' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                    {{ $status === 'alpha' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : '' }}
                                    {{ $status === '-' ? 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400' : '' }}">
                                {{ $statusData['label'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-slate-500 dark:text-slate-400">
                        Belum ada siswa terdaftar.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection