@extends('layouts.teacher')

@section('title', 'Monitor Ujian')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
            <div class="flex items-center gap-4 w-full md:w-auto">
                <a href="{{ route('teacher.exams.index') }}"
                    class="group flex items-center gap-2 px-4 py-2 bg-slate-100 dark:bg-slate-700 rounded-xl hover:bg-emerald-100 hover:text-emerald-600 transition-all text-slate-500 dark:text-slate-300">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                    <span class="font-bold text-sm">Kembali</span>
                </a>
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-slate-800 dark:text-white">{{ $exam->title }}</h2>
                    <div class="flex items-center gap-2">
                        <span class="text-xs px-2 py-1 rounded bg-emerald-100 text-emerald-600 font-bold animate-pulse">
                            Status: Berlangsung
                        </span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">
                            Kelas: {{ $exam->classroom->name }}
                        </span>
                    </div>
                </div>
            </div>

            @if($exam->is_active)
                <form action="{{ route('teacher.exams.stop', $exam) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghentikan ujian? Siswa tidak akan bisa mengerjakan lagi.');">
                    @csrf
                    <button type="submit"
                        class="px-6 py-2 bg-red-500 text-white rounded-xl shadow-lg shadow-red-500/30 hover:bg-red-600 transition-all font-bold text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                        </svg>
                        Hentikan Ujian
                    </button>
                </form>
            @else
                <div class="px-4 py-2 bg-slate-200 text-slate-500 rounded-xl font-bold text-sm">
                    Ujian Telah Dihentikan
                </div>
            @endif
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Timer Card -->
            <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 p-6 rounded-2xl shadow-lg text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <p class="text-indigo-100 text-sm font-medium mb-1">Sisa Waktu Ujian</p>
                <p class="text-3xl font-bold font-mono" id="exam-timer">--:--:--</p>
            </div>

            <!-- Participants Card -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden">
                 <div class="absolute top-0 right-0 p-4 opacity-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Total Partisipan</p>
                <p class="text-3xl font-bold text-slate-800 dark:text-white">{{ $attempts->count() }}</p>
            </div>

            <!-- Finished Card -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-2xl border border-emerald-200 dark:border-emerald-900/30 shadow-sm relative overflow-hidden">
                 <div class="absolute top-0 right-0 p-4 opacity-5 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                </div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Selesai Mengerjakan</p>
                <p class="text-3xl font-bold text-emerald-600">{{ $attempts->whereNotNull('submitted_at')->count() }}</p>
            </div>

            <!-- Active Card -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-2xl border border-yellow-200 dark:border-yellow-900/30 shadow-sm relative overflow-hidden">
                 <div class="absolute top-0 right-0 p-4 opacity-5 text-yellow-600">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium mb-1">Sedang Mengerjakan</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $attempts->whereNull('submitted_at')->count() }}</p>
            </div>
        </div>

        <!-- Attempts Table -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Status Siswa (Realtime)</h3>
                </div>
                <div class="flex items-center gap-2">
                    <span id="last-updated" class="text-xs text-slate-400 font-mono">Updating...</span>
                    <button onclick="fetchData()" class="p-2 text-slate-500 hover:text-emerald-500 transition-colors bg-white dark:bg-slate-700 rounded-lg border border-slate-200 dark:border-slate-600 shadow-sm"
                        title="Force Refresh">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                            <path d="M3 3v5h5" />
                            <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
                            <path d="M16 21h5v-5" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 text-xs uppercase tracking-wider font-bold">
                            <th class="p-4">Nama Siswa</th>
                            <th class="p-4">Waktu</th>
                            <th class="p-4 text-center">B / S</th>
                            <th class="p-4 text-center">Nilai</th>
                            <th class="p-4">Status & Pelanggaran</th>
                        </tr>
                    </thead>
                    <tbody id="monitor-table-body"
                        class="divide-y divide-slate-100 dark:divide-slate-700 text-slate-600 dark:text-slate-300">
                        {{-- Initial Load from Server (Optional, JS will overwrite) --}}
                        <tr id="loading-row">
                            <td colspan="5" class="p-8 text-center text-slate-400 animate-pulse">Memuat data realtime...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchData();
            // Poll every 5 seconds
            setInterval(fetchData, 5000);
            startTimer();
        });

        // Backend start_time passed to JS
        const startTime = new Date("{{ $exam->start_time ?? now() }}").getTime();
        const durationMinutes = {{ $exam->duration_minutes }};
        const endTime = startTime + (durationMinutes * 60 * 1000);

        function startTimer() {
            const timerElement = document.getElementById('exam-timer');
            
            function update() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    timerElement.textContent = "00:00:00";
                    timerElement.classList.add('text-red-200');
                    // Optional: auto-stop on frontend visual only
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                timerElement.textContent = 
                    (hours < 10 ? "0" + hours : hours) + ":" +
                    (minutes < 10 ? "0" + minutes : minutes) + ":" +
                    (seconds < 10 ? "0" + seconds : seconds);
            }

            setInterval(update, 1000);
            update(); // initial call
        }


        function fetchData() {
            fetch('{{ route("teacher.exams.monitor-data", $exam) }}')
                .then(response => response.json())
                .then(data => {
                    updateTable(data.attempts);
                    updateStats(data.summary);
                    document.getElementById('last-updated').textContent = new Date().toLocaleTimeString();
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function updateTable(attempts) {
            const tbody = document.getElementById('monitor-table-body');
            tbody.innerHTML = '';

            if (attempts.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="p-8 text-center text-slate-400 italic">Belum ada aktivitas siswa.</td></tr>`;
                return;
            }

            attempts.forEach(attempt => {
                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors border-b border-slate-50 dark:border-slate-800 last:border-0";

                // Status Badge
                let statusBadge = '';
                if (attempt.status === 'terminated') {
                    statusBadge = `<span class="px-2 py-1 bg-red-100 text-red-600 rounded text-[10px] font-bold uppercase tracking-wide">Dihentikan</span>`;
                } else if (attempt.is_finished) {
                    statusBadge = `<span class="px-2 py-1 bg-emerald-100 text-emerald-600 rounded text-[10px] font-bold uppercase tracking-wide">Selesai</span>`;
                } else {
                    statusBadge = `<span class="px-2 py-1 bg-yellow-100 text-yellow-600 rounded text-[10px] font-bold uppercase tracking-wide animate-pulse">Mengerjakan</span>`;
                }

                let violationBadge = '';
                if (attempt.violation_count > 0) {
                    violationBadge = `<span class="ml-2 px-2 py-1 bg-orange-100 text-orange-600 rounded text-[10px] font-bold uppercase tracking-wide">${attempt.violation_count} Pelanggaran</span>`;
                }

                // Correct/Wrong format
                const correctWrong = attempt.is_finished ?
                    `<div class="flex items-center justify-center gap-2 font-mono text-sm"><span class="text-emerald-500 font-bold">${attempt.correct}</span><span class="text-slate-300">/</span><span class="text-red-500 font-bold">${attempt.wrong}</span></div>` :
                    `<div class="text-center text-slate-300">-</div>`;

                // Calculate CSS class for Score (Optional)
                let scoreClass = 'font-bold font-mono';
                if (attempt.score >= 75) scoreClass += ' text-emerald-600';
                else if (attempt.score > 0) scoreClass += ' text-slate-800 dark:text-white';
                else scoreClass += ' text-slate-400';

                tr.innerHTML = `
                            <td class="p-4 font-medium text-slate-800 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-xs font-bold text-slate-500">
                                        ${attempt.user_name.charAt(0)}
                                    </div>
                                    ${attempt.user_name}
                                </div>
                            </td>
                            <td class="p-4 text-xs text-slate-500">
                                <div class="flex flex-col gap-1">
                                    <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> ${attempt.started_at}</span>
                                    <span class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> ${attempt.submitted_at}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center">${correctWrong}</td>
                            <td class="p-4 text-center ${scoreClass} text-lg">${attempt.score}</td>
                            <td class="p-4">
                                <div class="flex items-center">
                                    ${statusBadge}
                                    ${violationBadge}
                                </div>
                            </td>
                        `;
                tbody.appendChild(tr);
            });
        }

        function updateStats(summary) {
            // Logic to update stats cards... needs IDs on cards to do this dynamically
            // For now, simpler to just reload page or use JS to select by index if needed.
            // But usually this view is just for monitoring the table. 
            // If user wants live stats, we should add IDs to the stats elements.
        }
    </script>
@endsection