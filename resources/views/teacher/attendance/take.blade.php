@extends('layouts.teacher')

@section('title', 'Absensi Pertemuan ' . $session->session_number . ' - ' . $classroom->name)
@section('page-title', 'Isi Absensi')

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

        .status-btn {
            transition: all 0.2s ease;
        }

        .status-btn:hover {
            transform: scale(1.1);
        }

        .status-btn.active {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
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
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2 text-center">
                    <p class="text-3xl font-bold">{{ $students->count() }}</p>
                    <p class="text-xs text-emerald-100">Siswa</p>
                </div>
            </div>
        </div>

        {{-- Attendance Form --}}
        <form action="{{ route('teacher.attendance.store', [$classroom, $session]) }}" method="POST" class="animate-enter"
            style="animation-delay: 0.1s;">
            @csrf

            <div class="glass-card rounded-2xl overflow-hidden">
                {{-- Status Legend --}}
                <div
                    class="px-6 py-4 bg-slate-50/50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700/50 flex flex-wrap items-center gap-4 justify-between">
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-300">Klik tombol untuk mengubah status
                        kehadiran</p>
                    <div class="flex items-center gap-3 text-sm">
                        @foreach(\App\Models\Attendance::STATUSES as $key => $data)
                            <div class="flex items-center gap-1">
                                <span
                                    class="w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold
                                        {{ $key === 'hadir' ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400' : '' }}
                                        {{ $key === 'izin' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                                        {{ $key === 'sakit' ? 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                                        {{ $key === 'alpha' ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' : '' }}">
                                    {{ $data['icon'] }}
                                </span>
                                <span class="text-slate-500 dark:text-slate-400">{{ $data['label'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="divide-y divide-slate-100 dark:divide-slate-700/50">
                    @forelse($students as $index => $student)
                        @php
                            $attendance = $attendances->get($student->id);
                            $status = $attendance?->status ?? 'hadir';
                            $notes = $attendance?->notes ?? '';
                        @endphp
                        <div class="p-4 md:p-6 hover:bg-white/60 dark:hover:bg-slate-800/50 transition-colors"
                            x-data="{ status: '{{ $status }}', notes: '{{ $notes }}' }">
                            <div class="flex flex-col md:flex-row md:items-center gap-4">
                                {{-- Student Info --}}
                                <div class="flex items-center gap-3 min-w-0 md:w-1/3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-200 to-slate-100 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold text-sm shrink-0">
                                        {{ $index + 1 }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-800 dark:text-white truncate">{{ $student->name }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $student->email }}</p>
                                    </div>
                                </div>

                                {{-- Status Buttons --}}
                                <div class="flex items-center gap-2 md:w-1/3 justify-center">
                                    @foreach(\App\Models\Attendance::STATUSES as $key => $data)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}][status]" value="{{ $key }}"
                                                x-model="status" class="sr-only">
                                            <span
                                                class="status-btn inline-flex items-center justify-center w-11 h-11 rounded-xl border-2 text-lg font-bold
                                                        {{ $key === 'hadir' ? 'border-green-200 dark:border-green-800 text-green-600 dark:text-green-400' : '' }}
                                                        {{ $key === 'izin' ? 'border-blue-200 dark:border-blue-800 text-blue-600 dark:text-blue-400' : '' }}
                                                        {{ $key === 'sakit' ? 'border-yellow-200 dark:border-yellow-800 text-yellow-600 dark:text-yellow-400' : '' }}
                                                        {{ $key === 'alpha' ? 'border-red-200 dark:border-red-800 text-red-600 dark:text-red-400' : '' }}"
                                                :class="{
                                                            'active {{ $key === 'hadir' ? 'bg-green-100 dark:bg-green-900/30 border-green-500' : '' }}': status === '{{ $key }}',
                                                            'active {{ $key === 'izin' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500' : '' }}': status === '{{ $key }}',
                                                            'active {{ $key === 'sakit' ? 'bg-yellow-100 dark:bg-yellow-900/30 border-yellow-500' : '' }}': status === '{{ $key }}',
                                                            'active {{ $key === 'alpha' ? 'bg-red-100 dark:bg-red-900/30 border-red-500' : '' }}': status === '{{ $key }}'
                                                        }">
                                                {{ $data['icon'] }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>

                                {{-- Notes --}}
                                <div class="md:w-1/3">
                                    <input type="text" name="attendance[{{ $student->id }}][notes]" x-model="notes"
                                        class="w-full px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:border-emerald-500 focus:ring-0 outline-none transition-colors"
                                        placeholder="Keterangan (opsional)">
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <p class="text-slate-500 dark:text-slate-400">Belum ada siswa terdaftar di kelas ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            @if($students->isNotEmpty())
                <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3 animate-enter" style="animation-delay: 0.2s;">
                    <a href="{{ route('teacher.attendance.index', $classroom) }}"
                        class="px-6 py-3.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3.5 rounded-xl text-white font-bold bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Simpan Absensi
                    </button>
                </div>
            @endif
        </form>
    </div>
@endsection