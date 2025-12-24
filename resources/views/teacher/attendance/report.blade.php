@extends('layouts.teacher')

@section('title', 'Rekap Absensi - ' . $classroom->name)
@section('page-title', 'Rekap Absensi')

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
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Rekap Absensi</h1>
                    <p class="text-emerald-100">{{ $classroom->name }} • {{ $sessions->count() }} Pertemuan</p>
                </div>
                <a href="{{ route('teacher.attendance.export', $classroom) }}" 
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-white/20 hover:bg-white/30 backdrop-blur text-white font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Export CSV
                </a>
            </div>
        </div>

        {{-- Report Table --}}
        <div class="glass-card rounded-2xl overflow-hidden animate-enter" style="animation-delay: 0.1s;">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-800/80">
                            <th
                                class="px-4 py-3 text-left text-xs font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider sticky left-0 bg-slate-50 dark:bg-slate-800 z-10">
                                Nama Siswa</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-bold text-green-600 dark:text-green-400 uppercase">
                                Hadir</th>
                            <th class="px-3 py-3 text-center text-xs font-bold text-blue-600 dark:text-blue-400 uppercase">
                                Izin</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-bold text-yellow-600 dark:text-yellow-400 uppercase">
                                Sakit</th>
                            <th class="px-3 py-3 text-center text-xs font-bold text-red-600 dark:text-red-400 uppercase">
                                Alpha</th>
                            <th
                                class="px-3 py-3 text-center text-xs font-bold text-slate-600 dark:text-slate-300 uppercase">
                                Total</th>
                            <th
                                class="px-4 py-3 text-center text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase">
                                % Hadir</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($students as $index => $student)
                            @php
                                $data = $summary[$student->id] ?? ['hadir' => 0, 'izin' => 0, 'sakit' => 0, 'alpha' => 0, 'total' => 0];
                                $percentage = $data['total'] > 0 ? round(($data['hadir'] / $data['total']) * 100) : 0;
                            @endphp
                            <tr class="hover:bg-white/70 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-4 py-3 sticky left-0 bg-white dark:bg-slate-900 z-10">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="w-6 h-6 rounded-md bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-medium text-slate-500">{{ $index + 1 }}</span>
                                        <span class="font-medium text-slate-800 dark:text-white">{{ $student->name }}</span>
                                    </div>
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 font-bold text-sm">{{ $data['hadir'] }}</span>
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 font-bold text-sm">{{ $data['izin'] }}</span>
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 font-bold text-sm">{{ $data['sakit'] }}</span>
                                </td>
                                <td class="px-3 py-3 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 font-bold text-sm">{{ $data['alpha'] }}</span>
                                </td>
                                <td class="px-3 py-3 text-center font-bold text-slate-700 dark:text-slate-300">
                                    {{ $data['total'] }}</td>
                                <td class="px-4 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-16 h-2 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full
                                                    {{ $percentage >= 80 ? 'bg-green-500' : ($percentage >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                                style="width: {{ $percentage }}%"></div>
                                        </div>
                                        <span
                                            class="text-sm font-bold 
                                                {{ $percentage >= 80 ? 'text-green-600 dark:text-green-400' : ($percentage >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                            {{ $percentage }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                    Belum ada data absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Legend --}}
        <div class="flex flex-wrap gap-4 text-sm text-slate-600 dark:text-slate-400 animate-enter"
            style="animation-delay: 0.2s;">
            <div class="flex items-center gap-2">
                <div class="w-4 h-2 bg-green-500 rounded-full"></div>
                <span>≥ 80% = Baik</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-2 bg-yellow-500 rounded-full"></div>
                <span>60-79% = Cukup</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-2 bg-red-500 rounded-full"></div>
                <span>
                    < 60%=Perlu Perhatian</span>
            </div>
        </div>
    </div>
@endsection