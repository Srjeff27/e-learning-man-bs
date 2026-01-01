@extends('layouts.teacher')

@section('title', 'Kelola Ujian')

@section('content')
    <div class="space-y-8 animate-fade-in-up">
        <!-- Header Section with Glass Card -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 p-8 text-white shadow-2xl shadow-emerald-500/30">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-64 w-64 rounded-full bg-teal-400/20 blur-3xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight mb-2">Kelola Ujian</h2>
                    <p class="text-emerald-100/90 text-lg font-light">Buat, kelola, dan pantau ujian siswa dengan mudah.</p>
                </div>
                <a href="{{ route('teacher.exams.create') }}"
                    class="group relative inline-flex items-center gap-2 px-6 py-3 bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl hover:bg-white/30 transition-all duration-300 shadow-lg font-bold text-white overflow-hidden">
                    <div class="absolute inset-0 bg-white/10 translate-y-full group-hover:translate-y-0 transition-transform duration-300"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                    <span class="relative z-10">Buat Ujian Baru</span>
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="animate-fade-in p-4 bg-emerald-100/80 backdrop-blur-md text-emerald-700 rounded-2xl border border-emerald-200/50 shadow-sm flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-600"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Exam List Card -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl border border-white/40 dark:border-slate-700/50 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 bg-gradient-to-r from-slate-50/50 to-transparent dark:from-slate-800/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white">Daftar Ujian</h3>
                </div>
            </div>
            
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-700/30 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="p-6 first:pl-8">Judul & Kelas</th>
                            <th class="p-6">Durasi</th>
                            <th class="p-6">Sisa Waktu</th>
                            <th class="p-6">Status</th>
                            <th class="p-6 text-right last:pr-8">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($exams as $exam)
                            <tr class="group hover:bg-emerald-50/30 dark:hover:bg-slate-700/30 transition-all duration-300">
                                <td class="p-6 first:pl-8">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-800 dark:text-white text-lg group-hover:text-emerald-600 transition-colors">{{ $exam->title }}</span>
                                        <div class="flex items-center gap-2 mt-1 text-slate-500 text-xs font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v14"/><polyline points="17 9 12 13 7 9"/></svg>
                                            {{ $exam->classroom->name ?? 'Semua Kelas' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-2 text-slate-600 dark:text-slate-300 font-medium bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-full w-fit text-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ $exam->duration_minutes }} Menit
                                    </div>
                                </td>
                                <td class="p-6 font-mono font-bold text-lg">
                                    @if($exam->is_active)
                                        @php
                                            $endTime = \Carbon\Carbon::parse($exam->start_time)->addMinutes($exam->duration_minutes);
                                        @endphp
                                        <span class="exam-countdown text-emerald-600 bg-emerald-100/50 dark:bg-emerald-900/30 px-3 py-1 rounded-lg border border-emerald-200 dark:border-emerald-800" data-end="{{ $endTime->timestamp * 1000 }}">
                                            ...
                                        </span>
                                    @else
                                        <span class="text-slate-300 text-2xl">-</span>
                                    @endif
                                </td>
                                <td class="p-6">
                                    @if($exam->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100/80 text-emerald-700 rounded-full text-xs font-bold ring-2 ring-emerald-500/20 animate-pulse">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Berlangsung
                                        </span>
                                    @elseif($exam->end_time)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-600 rounded-full text-xs font-bold border border-slate-200">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 text-slate-500 rounded-full text-xs font-bold border border-slate-200 border-dashed">
                                            Belum Dimulai
                                        </span>
                                    @endif
                                </td>
                                <td class="p-6 text-right last:pr-8">
                                    <div class="flex justify-end items-center gap-2">
                                        {{-- Soal (Detail) --}}
                                        <a href="{{ route('teacher.exams.show', $exam) }}"
                                            class="p-2 bg-white text-slate-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl border border-slate-200 hover:border-indigo-200 transition-all shadow-sm tooltip" title="Lihat Soal">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                        </a>

                                        {{-- Riwayat --}}
                                        <a href="{{ route('teacher.exams.history', $exam) }}"
                                            class="p-2 bg-white text-slate-500 hover:bg-amber-50 hover:text-amber-600 rounded-xl border border-slate-200 hover:border-amber-200 transition-all shadow-sm tooltip" title="Riwayat Hasil">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><path d="M12 7v5l4 2"/></svg>
                                        </a>

                                        {{-- Mulai / Monitor --}}
                                        @if(!$exam->is_active)
                                            <form action="{{ route('teacher.exams.start', $exam) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl shadow-lg shadow-emerald-500/20 transition-all font-bold text-sm transform hover:-translate-y-0.5" title="Mulai Ujian">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="5 3 19 12 5 21 5 3"/></svg>
                                                    Mulai
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('teacher.exams.monitor', $exam) }}"
                                                class="flex items-center gap-2 px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-500/30 transition-all font-bold text-sm transform hover:-translate-y-0.5 animate-pulse" title="Monitor Ujian">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12h5"/><path d="M17 12h5"/><path d="M7 12l5-10 5 10"/><path d="M12 12v10"/></svg>
                                                Monitor
                                            </a>
                                        @endif

                                        {{-- Hapus --}}
                                        @if($exam->attempts()->exists())
                                            <button type="button" disabled
                                                class="ml-2 p-2 bg-slate-100 text-slate-300 rounded-xl border border-slate-200 cursor-not-allowed tooltip" title="Tidak dapat dihapus karena sudah ada data hasil">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                            </button>
                                        @else
                                            <form action="{{ route('teacher.exams.destroy', $exam) }}" method="POST"
                                                onsubmit="return confirm('Hapus ujian ini? Data nilai akan hilang permanen.');" class="ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-white text-slate-400 hover:bg-red-50 hover:text-red-500 rounded-xl border border-slate-200 hover:border-red-200 transition-all shadow-sm tooltip" title="Hapus Ujian">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-slate-400">
                                        <div class="h-24 w-24 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                                        </div>
                                        <p class="text-lg font-medium text-slate-500">Belum ada ujian yang dibuat</p>
                                        <p class="text-sm text-slate-400 mt-1">Buat ujian baru untuk memulai sesi.</p>
                                        <a href="{{ route('teacher.exams.create') }}" class="mt-4 px-6 py-2 bg-emerald-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition-all">
                                            + Buat Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden space-y-4 p-4">
                @forelse($exams as $exam)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl p-5 border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden">
                        
                        <!-- Top Row: Badge & Menu -->
                        <div class="flex justify-between items-start mb-3">
                            @if($exam->is_active)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-100/80 text-emerald-700 rounded-full text-xs font-bold ring-2 ring-emerald-500/20 animate-pulse">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Berlangsung
                                </span>
                                @php
                                    $endTime = \Carbon\Carbon::parse($exam->start_time)->addMinutes($exam->duration_minutes);
                                @endphp
                                <span class="exam-countdown font-mono font-bold text-emerald-600" data-end="{{ $endTime->timestamp * 1000 }}">...</span>
                            @elseif($exam->end_time)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold border border-slate-200">
                                    Selesai
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-bold border border-slate-200 border-dashed">
                                    Belum Dimulai
                                </span>
                            @endif
                        </div>

                        <!-- Content -->
                        <h3 class="font-bold text-slate-800 dark:text-white text-lg mb-1">{{ $exam->title }}</h3>
                        <div class="flex items-center gap-3 text-xs text-slate-500 mb-4">
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18"/><path d="M5 21V7a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v14"/><polyline points="17 9 12 13 7 9"/></svg>
                                {{ $exam->classroom->name ?? 'Semua Kelas' }}
                            </span>
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $exam->duration_minutes }} Menit
                            </span>
                        </div>

                        <!-- Action Grid -->
                        <div class="grid grid-cols-4 gap-2 pt-4 border-t border-slate-100 dark:border-slate-700">
                            {{-- Mulai/Monitor (Primary) --}}
                            <div class="col-span-2">
                                @if(!$exam->is_active)
                                    <form action="{{ route('teacher.exams.start', $exam) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit"
                                            class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-emerald-500 text-white rounded-xl shadow-lg shadow-emerald-500/20 font-bold text-sm">
                                            Mulai
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('teacher.exams.monitor', $exam) }}"
                                        class="w-full flex items-center justify-center gap-2 px-3 py-2 bg-indigo-500 text-white rounded-xl shadow-lg shadow-indigo-500/20 font-bold text-sm animate-pulse">
                                        Monitor
                                    </a>
                                @endif
                            </div>

                            {{-- View --}}
                            <a href="{{ route('teacher.exams.show', $exam) }}"
                                class="flex items-center justify-center p-2 bg-slate-50 text-slate-600 rounded-xl border border-slate-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            </a>

                            {{-- Delete --}}
                            @if($exam->attempts()->exists())
                                <button type="button" disabled
                                    class="flex items-center justify-center p-2 bg-slate-100 text-slate-300 rounded-xl border border-slate-200 cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            @else
                                <form action="{{ route('teacher.exams.destroy', $exam) }}" method="POST"
                                    onsubmit="return confirm('Hapus ujian ini? Data nilai akan hilang permanen.');" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full flex items-center justify-center p-2 bg-red-50 text-red-500 rounded-xl border border-red-100 hover:bg-red-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center bg-white dark:bg-slate-800 rounded-2xl border-2 border-dashed border-slate-200 dark:border-slate-700">
                        <p class="text-slate-500">Belum ada ujian.</p>
                        <a href="{{ route('teacher.exams.create') }}" class="text-emerald-500 font-bold block mt-2">+ Buat Baru</a>
                    </div>
                @endforelse
            </div>
            
            @if($exams->hasPages())
                <div class="p-6 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/30">
                    {{ $exams->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setInterval(updateCountdowns, 1000);
            updateCountdowns();
        });

        function updateCountdowns() {
            const now = new Date().getTime();
            document.querySelectorAll('.exam-countdown').forEach(el => {
                const endTime = parseInt(el.getAttribute('data-end'));
                const distance = endTime - now;

                if (distance < 0) {
                    el.textContent = "00:00:00";
                    el.className = "text-sm text-slate-400 font-mono";
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                el.textContent = 
                    (hours < 10 ? "0" + hours : hours) + ":" +
                    (minutes < 10 ? "0" + minutes : minutes) + ":" +
                    (seconds < 10 ? "0" + seconds : seconds);
            });
        }
    </script>
    @endpush
@endsection