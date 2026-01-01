@extends('layouts.student')

@section('title', 'Daftar Ujian')

@section('content')
    <div class="space-y-8 animate-fade-in-up">
        <!-- Header -->
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-500 to-teal-600 p-8 text-white shadow-2xl shadow-emerald-500/30">
            <div class="absolute top-0 right-0 -mt-10 -mr-10 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 h-64 w-64 rounded-full bg-teal-400/20 blur-3xl"></div>

            <div class="relative z-10">
                <h2 class="text-3xl font-extrabold tracking-tight mb-2">Ujian Tersedia</h2>
                <p class="text-emerald-100/90 text-lg font-light">Kerjakan ujian dengan jujur dan teliti.</p>
            </div>
        </div>

        @if(session('error'))
            <div
                class="p-4 bg-red-100/80 backdrop-blur-md text-red-700 rounded-2xl border border-red-200/50 shadow-sm flex items-center gap-3 animate-shake">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Exam Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @forelse($exams as $exam)
                @php
                    // Check if already attempted
                    $attempt = $exam->attempts()->where('user_id', auth()->id())->first();
                    $isFinished = $attempt && $attempt->submitted_at;
                    $isOngoing = $attempt && !$attempt->submitted_at;
                @endphp

                <div
                    class="group relative bg-white dark:bg-slate-800 rounded-2xl md:rounded-3xl border border-slate-200 dark:border-slate-700 p-5 md:p-6 shadow-sm hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col h-full">

                    @if($isFinished)
                        <div
                            class="absolute top-4 right-4 px-2 py-1 md:px-3 md:py-1 bg-emerald-100 text-emerald-600 rounded-full text-[10px] md:text-xs font-bold border border-emerald-200">
                            Selesai
                        </div>
                    @elseif($isOngoing)
                        <div
                            class="absolute top-4 right-4 px-2 py-1 md:px-3 md:py-1 bg-yellow-100 text-yellow-600 rounded-full text-[10px] md:text-xs font-bold border border-yellow-200 animate-pulse">
                            Sedang Dikerjakan
                        </div>
                    @endif

                    <!-- Decor -->
                    <div
                        class="w-10 h-10 md:w-12 md:h-12 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl md:rounded-2xl flex items-center justify-center text-emerald-500 mb-3 md:mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                            <polyline points="14 2 14 8 20 8" />
                            <path d="M12 13v6" />
                            <path d="M12 18l-3-3" />
                            <path d="M12 18l3-3" />
                        </svg>
                    </div>

                    <h3
                        class="text-lg md:text-xl font-bold text-slate-800 dark:text-white mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                        {{ $exam->title }}
                    </h3>

                    <div
                        class="flex items-center gap-2 md:gap-3 text-slate-500 dark:text-slate-400 text-xs md:text-sm mb-3 md:mb-4">
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                            {{ $exam->classroom->name }}
                        </span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            {{ $exam->duration_minutes }} Menit
                        </span>
                    </div>

                    <p class="text-slate-400 dark:text-slate-500 text-xs md:text-sm mb-5 md:mb-6 line-clamp-2">
                        {{ $exam->description ?? 'Tidak ada deskripsi tambahan.' }}
                    </p>

                    <div class="mt-auto">
                        @if($isFinished)
                            <a href="{{ route('student.exams.result', $exam) }}"
                                class="flex items-center justify-center gap-2 w-full py-2.5 md:py-3 bg-emerald-100 text-emerald-600 rounded-xl font-bold hover:bg-emerald-200 transition-colors text-sm md:text-base">
                                Lihat Hasil
                            </a>
                        @elseif($isOngoing)
                            <a href="{{ route('student.exams.take', $exam) }}"
                                class="flex items-center justify-center gap-2 w-full py-2.5 md:py-3 bg-yellow-400 text-yellow-900 rounded-xl font-bold hover:bg-yellow-500 transition-colors shadow-lg shadow-yellow-400/20 text-sm md:text-base">
                                Lanjutkan Ujian
                            </a>
                        @else
                            <form action="{{ route('student.exams.start-attempt', $exam) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center justify-center gap-2 w-full py-2.5 md:py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-xl font-bold hover:bg-slate-700 dark:hover:bg-slate-200 transition-colors shadow-lg text-sm md:text-base">
                                    Mulai Kerjakan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div
                    class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-10 md:py-12 px-6 rounded-3xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700 border-dashed">
                    <div class="inline-flex p-4 bg-white dark:bg-slate-700/50 rounded-full mb-4 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="text-slate-300">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg>
                    </div>
                    <p class="text-slate-500 font-medium">Tidak ada ujian aktif saat ini.</p>
                    <p class="text-slate-400 text-sm">Cek kembali nanti atau hubungi guru Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection