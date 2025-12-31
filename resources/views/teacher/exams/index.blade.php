@extends('layouts.teacher')

@section('title', 'Kelola Ujian')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola Ujian</h2>
                <p class="text-slate-500 dark:text-slate-400">Buat dan kelola ujian untuk kelas Anda.</p>
            </div>
            <a href="{{ route('teacher.exams.create') }}"
                class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-xl shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all duration-300 font-medium">
                + Buat Ujian Baru
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-100 text-emerald-700 rounded-xl border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <!-- Exam List -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Daftar Ujian</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 text-sm uppercase tracking-wider">
                            <th class="p-4 font-semibold">Judul</th>
                            <th class="p-4 font-semibold">Kelas</th>
                            <th class="p-4 font-semibold">Durasi</th>
                            <th class="p-4 font-semibold">Sisa Waktu</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700 text-slate-600 dark:text-slate-300">
                        @forelse($exams as $exam)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="p-4 font-medium text-slate-800 dark:text-white">{{ $exam->title }}</td>
                                <td class="p-4">{{ $exam->classroom->name ?? '-' }}</td>
                                <td class="p-4">{{ $exam->duration_minutes }} Menit</td>
                                <td class="p-4 font-mono font-bold text-slate-600 dark:text-slate-300">
                                    @if($exam->is_active)
                                        @php
                                            $endTime = \Carbon\Carbon::parse($exam->start_time)->addMinutes($exam->duration_minutes);
                                        @endphp
                                        <span class="exam-countdown text-indigo-600" data-end="{{ $endTime->timestamp * 1000 }}">
                                            Menghitung...
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($exam->is_active)
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-600 rounded-lg text-xs font-bold animate-pulse">
                                            Sedang Berlangsung
                                        </span>
                                    @elseif($exam->end_time)
                                        <span class="px-2 py-1 bg-red-100 text-red-600 rounded-lg text-xs font-bold">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded-lg text-xs font-bold border border-slate-200">
                                            Belum Dimulai
                                        </span>
                                    @endif
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <div class="flex justify-end gap-2 items-center">
                                        {{-- Soal (Detail) --}}
                                        <a href="{{ route('teacher.exams.show', $exam) }}"
                                            class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-colors text-xs font-bold">
                                            Soal
                                        </a>

                                        {{-- Riwayat --}}
                                        <a href="{{ route('teacher.exams.history', $exam) }}"
                                            class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg hover:bg-slate-200 transition-colors text-xs font-bold">
                                            Riwayat
                                        </a>

                                        {{-- Mulai / Monitor --}}
                                        @if(!$exam->is_active)
                                            <form action="{{ route('teacher.exams.start', $exam) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-emerald-100 text-emerald-600 rounded-lg hover:bg-emerald-200 transition-colors text-xs font-bold">
                                                    Mulai Ujian
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('teacher.exams.monitor', $exam) }}"
                                                class="px-3 py-1.5 bg-indigo-100 text-indigo-600 rounded-lg hover:bg-indigo-200 transition-colors text-xs font-bold animate-pulse">
                                                Monitor Ujian
                                            </a>
                                        @endif

                                        {{-- Hapus --}}
                                        <form action="{{ route('teacher.exams.destroy', $exam) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus ujian ini? Data nilai siswa juga akan terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition-colors text-xs font-bold">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">Belum ada ujian yang dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-4">
                {{ $exams->links() }}
            </div>
        </div>
    </div>

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
                    el.classList.replace('text-indigo-600', 'text-red-500');
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
@endsection