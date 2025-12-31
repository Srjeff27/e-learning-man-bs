@extends('layouts.teacher')

@section('title', 'Monitor Ujian')

@section('content')
    <div class="space-y-8 animate-fade-in-up">
        <!-- Header -->
        <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl p-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-indigo-500/5 blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('teacher.exams.index') }}"
                        class="group flex items-center justify-center h-12 w-12 bg-slate-50 dark:bg-slate-700/50 rounded-full hover:bg-emerald-50 dark:hover:bg-slate-700 transition-all text-slate-500 hover:text-emerald-600 border border-slate-200 dark:border-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
                    </a>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">{{ $exam->title }}</h2>
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold uppercase tracking-wider animate-pulse border border-emerald-200">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full inline-block mr-1"></span> Live
                            </span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 font-medium flex items-center gap-2">
                            <span>{{ $exam->classroom->name }}</span>
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span>{{ $exam->duration_minutes }} Menit</span>
                        </p>
                    </div>
                </div>

                @if($exam->is_active)
                    <form action="{{ route('teacher.exams.stop', $exam) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghentikan ujian? Siswa tidak akan bisa mengerjakan lagi.');">
                        @csrf
                        <button type="submit"
                            class="group relative overflow-hidden px-6 py-3 bg-red-500 text-white rounded-2xl shadow-lg shadow-red-500/30 hover:bg-red-600 transition-all font-bold text-sm">
                            <span class="relative z-10 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/></svg>
                                Hentikan Ujian
                            </span>
                        </button>
                    </form>
                @else
                    <div class="px-6 py-3 bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-300 rounded-2xl font-bold text-sm border border-slate-200 dark:border-slate-600 flex items-center gap-2 cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        Ujian Dihentikan
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Timer Card -->
            <div class="bg-gradient-to-br from-indigo-600 to-blue-700 p-6 rounded-3xl shadow-xl shadow-indigo-500/20 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-indigo-100 text-sm font-bold uppercase tracking-wider mb-2">Sisa Waktu</p>
                    <p class="text-4xl font-black font-mono tracking-tight" id="exam-timer">--:--:--</p>
                </div>
            </div>

            <!-- Participants Card -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                 <div class="absolute -right-6 -top-6 w-24 h-24 bg-slate-100 dark:bg-slate-700 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-wider">Partisipan</p>
                        <div class="p-2 bg-slate-100 dark:bg-slate-700 text-slate-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-black text-slate-800 dark:text-white">{{ $attempts->count() }}</p>
                </div>
            </div>

            <!-- Active Card -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-3xl border border-yellow-200 dark:border-yellow-900/30 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                 <div class="absolute -right-6 -top-6 w-24 h-24 bg-yellow-50 dark:bg-yellow-900/20 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-yellow-600/80 text-sm font-bold uppercase tracking-wider">Sedang Mengerjakan</p>
                        <div class="p-2 bg-yellow-100 text-yellow-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-black text-yellow-500">{{ $attempts->whereNull('submitted_at')->count() }}</p>
                </div>
            </div>

            <!-- Finished Card -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-3xl border border-emerald-200 dark:border-emerald-900/30 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                 <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/20 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-emerald-600/80 text-sm font-bold uppercase tracking-wider">Selesai</p>
                        <div class="p-2 bg-emerald-100 text-emerald-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-black text-emerald-500">{{ $attempts->whereNotNull('submitted_at')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Attempts Table -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 bg-white dark:bg-slate-700 rounded-xl shadow-sm border border-slate-200 dark:border-slate-600 flex items-center justify-center text-emerald-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white leading-none">Live Status Siswa</h3>
                        <p class="text-xs text-slate-400 mt-1 font-mono">Last Update: <span id="last-updated">...</span></p>
                    </div>
                </div>
                <button onclick="fetchData()" class="p-2.5 bg-white dark:bg-slate-700 text-slate-400 hover:text-emerald-500 hover:border-emerald-200 border border-slate-200 dark:border-slate-600 rounded-xl transition-all shadow-sm" title="Refresh Data">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 21h5v-5"/></svg>
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="p-6 first:pl-8">Siswa</th>
                            <th class="p-6">Progress Waktu</th>
                            <th class="p-6 text-center">Skor Sementara</th>
                            <th class="p-6 text-center">Status</th>
                            <th class="p-6 text-right last:pr-8">Pelanggaran</th>
                        </tr>
                    </thead>
                    <tbody id="monitor-table-body" class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        <tr id="loading-row">
                            <td colspan="5" class="p-8 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400 animate-pulse">
                                    <div class="h-12 w-12 bg-slate-200 dark:bg-slate-700 rounded-full mb-3"></div>
                                    <div class="h-4 w-32 bg-slate-200 dark:bg-slate-700 rounded mb-2"></div>
                                    <span class="text-xs">Menghubungkan ke server...</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetchData();
            // Poll every 3 seconds for faster updates
            setInterval(fetchData, 3000);
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
                    timerElement.classList.add('opacity-50');
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
                    document.getElementById('last-updated').textContent = new Date().toLocaleTimeString();
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function updateTable(attempts) {
            const tbody = document.getElementById('monitor-table-body');
            tbody.innerHTML = '';

            if (attempts.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="p-12 text-center text-slate-400 italic">Belum ada aktivitas siswa.</td></tr>`;
                return;
            }

            attempts.forEach(attempt => {
                const tr = document.createElement('tr');
                tr.className = "group hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors";

                // Status Badge Logic
                let statusBadge = '';
                let statusClass = '';
                
                if (attempt.status === 'terminated') {
                    statusBadge = 'Dihentikan';
                    statusClass = 'bg-red-100 text-red-600 border-red-200';
                } else if (attempt.is_finished) {
                    statusBadge = 'Selesai';
                    statusClass = 'bg-emerald-100 text-emerald-600 border-emerald-200';
                } else {
                    statusBadge = 'Mengerjakan';
                    statusClass = 'bg-yellow-100 text-yellow-600 border-yellow-200 animate-pulse';
                }

                // Violation Badge
                let violationBadge = '';
                if (attempt.violation_count > 0) {
                    violationBadge = `<span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-50 text-orange-600 border border-orange-200 rounded-full text-xs font-bold">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        ${attempt.violation_count}
                    </span>`;
                } else {
                    violationBadge = `<span class="text-slate-300 text-xs font-medium px-3 py-1 bg-slate-50 rounded-full">Aman</span>`;
                }

                // Score Display
                const scoreDisplay = attempt.is_finished ? 
                    `<div class="flex flex-col items-center">
                        <span class="text-2xl font-black ${attempt.score >= 75 ? 'text-emerald-500' : 'text-slate-700'}">${attempt.score}</span>
                        <div class="flex gap-2 text-xs font-bold mt-1">
                            <span class="text-emerald-600 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> ${attempt.correct}</span>
                            <span class="text-slate-300">|</span>
                            <span class="text-red-500 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> ${attempt.wrong}</span>
                        </div>
                    </div>` : 
                    `<span class="text-slate-300 font-mono text-xl">--</span>`;

                tr.innerHTML = `
                    <td class="p-6 first:pl-8">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-500/20">
                                ${attempt.user_name.charAt(0)}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-white capitalize">${attempt.user_name}</p>
                                <p class="text-xs text-slate-500 mt-0.5 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    Mulai: ${attempt.started_at}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="p-6">
                        <div class="flex flex-col gap-1">
                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-emerald-500 h-full rounded-full transition-all duration-500" style="width: ${attempt.is_finished ? '100%' : '50%'}"></div>
                            </div>
                           <span class="text-xs text-slate-400 font-medium text-right">${attempt.is_finished ? 'Selesai' : 'Sedang Berjalan'}</span>
                        </div>
                    </td>
                    <td class="p-6 text-center">
                        ${scoreDisplay}
                    </td>
                    <td class="p-6 text-center">
                        <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold border ${statusClass}">
                            ${statusBadge}
                        </span>
                    </td>
                    <td class="p-6 text-right last:pr-8">
                        ${violationBadge}
                    </td>
                `;
                tbody.appendChild(tr);
            });
        }
    </script>
@endsection