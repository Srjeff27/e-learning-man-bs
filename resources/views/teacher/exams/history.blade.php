@extends('layouts.teacher')

@section('title', 'Riwayat Ujian')

@section('content')
    <div class="space-y-8 animate-fade-in-up">
        <!-- Header -->
        <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl p-8">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-amber-500/5 blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('teacher.exams.index') }}"
                        class="group flex items-center justify-center h-12 w-12 bg-slate-50 dark:bg-slate-700/50 rounded-full hover:bg-emerald-50 dark:hover:bg-slate-700 transition-all text-slate-500 hover:text-emerald-600 border border-slate-200 dark:border-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="group-hover:-translate-x-1 transition-transform"><path d="m15 18-6-6 6-6"/></svg>
                    </a>
                    <div>
                        <div class="flex items-center gap-3 mb-1">
                            <h2 class="text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight">{{ $exam->title }}</h2>
                            <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-full text-xs font-bold uppercase tracking-wider border border-slate-200">
                                Riwayat
                            </span>
                        </div>
                        <p class="text-slate-500 dark:text-slate-400 font-medium flex items-center gap-2">
                            <span>{{ $exam->classroom->name }}</span>
                            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            <span>{{ $exam->questions->count() }} Soal</span>
                        </p>
                    </div>
                </div>

                <div class="px-6 py-3 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 rounded-2xl font-bold text-sm border border-amber-200 dark:border-amber-800 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v5h5"/><path d="M3.05 13A9 9 0 1 0 6 5.3L3 8"/><path d="M12 7v5l4 2"/></svg>
                    Data Riwayat Permanen
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Avg Score Card -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-6 rounded-3xl shadow-xl shadow-emerald-500/20 text-white relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                     <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4.5 16.5c2.04-2.43 4.23-4 5.73-4 .94 0 1.75.15 2.58 1.05 1.58 1.7 3.28 2.52 5.16.82L21.5 11.5"/></svg>
                </div>
                <div class="relative z-10">
                    <p class="text-emerald-100 text-sm font-bold uppercase tracking-wider mb-2">Rata-rata Nilai</p>
                    <p class="text-4xl font-black tracking-tight">
                        {{ $attempts->count() > 0 ? round($attempts->avg('score'), 1) : 0 }}
                    </p>
                </div>
            </div>

            <!-- Participants Card -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                 <div class="absolute -right-6 -top-6 w-24 h-24 bg-slate-100 dark:bg-slate-700 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-slate-500 dark:text-slate-400 text-sm font-bold uppercase tracking-wider">Total Siswa</p>
                        <div class="p-2 bg-slate-100 dark:bg-slate-700 text-slate-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-black text-slate-800 dark:text-white">{{ $attempts->count() }}</p>
                </div>
            </div>

            <!-- High Score -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-3xl border border-blue-200 dark:border-blue-900/30 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                 <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-50 dark:bg-blue-900/20 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-blue-600/80 text-sm font-bold uppercase tracking-wider">Nilai Tertinggi</p>
                        <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-black text-blue-500">{{ $attempts->max('score') ?? 0 }}</p>
                </div>
            </div>

            <!-- Low Score -->
            <div class="bg-white/80 dark:bg-slate-800/80 p-6 rounded-3xl border border-red-200 dark:border-red-900/30 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                 <div class="absolute -right-6 -top-6 w-24 h-24 bg-red-50 dark:bg-red-900/20 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <p class="text-red-600/80 text-sm font-bold uppercase tracking-wider">Nilai Terendah</p>
                        <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>
                        </div>
                    </div>
                    <p class="text-4xl font-black text-red-500">{{ $attempts->min('score') ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Attempts List -->
        <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl md:rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 overflow-hidden">
            <div class="p-5 md:p-6 border-b border-slate-100 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-800/50">
                <h3 class="text-base md:text-lg font-bold text-slate-800 dark:text-white">Detail Nilai Siswa</h3>
            </div>
            
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-wider">
                            <th class="p-6 first:pl-8">Siswa</th>
                            <th class="p-6">Waktu Pengerjaan</th>
                            <th class="p-6 text-center">Jawaban (B/S)</th>
                            <th class="p-6 text-center">Nilai Akhir</th>
                            <th class="p-6 text-center">Status</th>
                            <th class="p-6 text-right last:pr-8">Pelanggaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                        @forelse($attempts as $attempt)
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-700/20 transition-colors">
                                <td class="p-6 first:pl-8">
                                    <div class="flex items-center gap-4">
                                        <div class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold">
                                            {{ substr($attempt->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800 dark:text-white capitalize">{{ $attempt->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6">
                                    <div class="flex flex-col gap-1 text-sm">
                                        <span class="text-slate-500">Mulai: {{ \Carbon\Carbon::parse($attempt->started_at)->format('H:i') }}</span>
                                        <span class="text-slate-500">Selesai: {{ $attempt->submitted_at ? \Carbon\Carbon::parse($attempt->submitted_at)->format('H:i') : '-' }}</span>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="flex gap-2 text-sm font-bold">
                                            <span class="text-emerald-600 flex items-center gap-1">{{ $attempt->answers->where('is_correct', true)->count() }}</span>
                                            <span class="text-slate-300">/</span>
                                            <span class="text-red-500 flex items-center gap-1">{{ $attempt->answers->where('is_correct', false)->count() }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <span class="text-2xl font-black {{ $attempt->score >= 75 ? 'text-emerald-500' : 'text-slate-700' }}">{{ $attempt->score }}</span>
                                </td>
                                <td class="p-6 text-center">
                                    @if($attempt->status === 'terminated')
                                        <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold border bg-red-100 text-red-600 border-red-200">
                                            Dihentikan
                                        </span>
                                    @elseif($attempt->submitted_at)
                                        <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold border bg-emerald-100 text-emerald-600 border-emerald-200">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="inline-block px-3 py-1 rounded-lg text-xs font-bold border bg-slate-100 text-slate-600 border-slate-200">
                                            Tidak Tuntas
                                        </span>
                                    @endif
                                </td>
                                <td class="p-6 text-right last:pr-8">
                                    @if($attempt->violation_count > 0)
                                        <span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-50 text-orange-600 border border-orange-200 rounded-full text-xs font-bold">
                                            {{ $attempt->violation_count }}x
                                        </span>
                                    @else
                                        <span class="text-slate-300 text-xs font-medium px-3 py-1 bg-slate-50 rounded-full">Nihil</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-400 italic">Belum ada data riwayat ujian.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden p-4 space-y-4">
                @forelse($attempts as $attempt)
                    <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 p-4 space-y-4">
                         <!-- Student Info & Score -->
                         <div class="flex justify-between items-start">
                             <div class="flex items-center gap-3">
                                 <div class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 flex items-center justify-center font-bold text-sm shrink-0">
                                     {{ substr($attempt->user->name, 0, 1) }}
                                 </div>
                                 <div class="min-w-0">
                                     <p class="font-bold text-slate-800 dark:text-white capitalize truncate text-sm">{{ $attempt->user->name }}</p>
                                     <p class="text-xs text-slate-500 flex items-center gap-1.5 mt-0.5">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                         {{ \Carbon\Carbon::parse($attempt->started_at)->format('H:i') }} - 
                                         {{ $attempt->submitted_at ? \Carbon\Carbon::parse($attempt->submitted_at)->format('H:i') : '...' }}
                                     </p>
                                 </div>
                             </div>
                             <div class="text-right">
                                 <span class="block text-2xl font-black {{ $attempt->score >= 75 ? 'text-emerald-500' : 'text-slate-700' }} leading-none">{{ $attempt->score }}</span>
                                 <span class="text-[10px] uppercase font-bold text-slate-400">Nilai</span>
                             </div>
                         </div>
 
                         <!-- Stats & Status -->
                         <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-700/50">
                             <div class="flex items-center gap-4 text-xs font-bold">
                                 <span class="text-emerald-600 flex items-center gap-1">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                     {{ $attempt->answers->where('is_correct', true)->count() }}
                                 </span>
                                 <span class="text-red-500 flex items-center gap-1">
                                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                     {{ $attempt->answers->where('is_correct', false)->count() }}
                                 </span>
                                 @if($attempt->violation_count > 0)
                                     <span class="text-orange-500 flex items-center gap-1">
                                         <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M3.4 20.5 12 4l8.6 16.5H3.4z"/></svg>
                                         {{ $attempt->violation_count }}
                                     </span>
                                 @endif
                             </div>
 
                             <div>
                                 @if($attempt->status === 'terminated')
                                     <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold border bg-red-50 text-red-600 border-red-100 uppercase tracking-wide">
                                         Dihentikan
                                     </span>
                                 @elseif($attempt->submitted_at)
                                     <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold border bg-emerald-50 text-emerald-600 border-emerald-100 uppercase tracking-wide">
                                         Selesai
                                     </span>
                                 @else
                                     <span class="inline-block px-2.5 py-1 rounded-md text-[10px] font-bold border bg-slate-50 text-slate-600 border-slate-100 uppercase tracking-wide">
                                         Proses
                                     </span>
                                 @endif
                             </div>
                         </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-slate-400 italic text-sm">Belum ada data riwayat ujian.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection