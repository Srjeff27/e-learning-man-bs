@extends('layouts.teacher')

@section('title', 'Kelas Saya')
@section('page-title', 'Kelas Saya')

@section('content')
    <div class="space-y-8 animate-fade-in">
        {{-- Header & Action --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Kelas</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">Kelola kelas dan materi pembelajaran Anda</p>
            </div>

            <a href="{{ route('teacher.classrooms.create') }}"
                class="px-6 py-3 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Buat Kelas Baru
            </a>
        </div>

        @if($classrooms->isEmpty())
            <div class="glass-card p-12 text-center rounded-3xl border-dashed border-2 border-slate-300 dark:border-slate-700">
                <div
                    class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-6 animate-float">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum ada kelas</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-md mx-auto">Mulai perjalanan mengajar Anda dengan
                    membuat kelas pertama. Anda dapat membagikan kode kelas kepada siswa nanti.</p>
                <a href="{{ route('teacher.classrooms.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold rounded-xl hover:bg-slate-800 dark:hover:bg-slate-100 transition-colors">
                    Mulai Buat Kelas
                </a>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($classrooms as $classroom)
                    <div class="group relative">
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-3xl blur opacity-25 group-hover:opacity-40 transition-opacity duration-300 -z-10">
                        </div>

                        <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                            class="glass-card block h-full overflow-hidden hover:-translate-y-2 transition-transform duration-300">
                            {{-- Card Header --}}
                            <div class="h-32 bg-gradient-to-br from-emerald-500 to-teal-600 p-6 relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                                <div class="relative z-10">
                                    <h3
                                        class="text-xl font-bold text-white mb-1 line-clamp-1 group-hover:underline decoration-white/30 underline-offset-4">
                                        {{ $classroom->name }}</h3>
                                    <p class="text-emerald-100 text-sm font-medium line-clamp-1">
                                        {{ $classroom->subject ?? 'Mata Pelajaran Umum' }}</p>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-5">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <span>{{ $classroom->students_count }} Siswa</span>
                                    </div>
                                    <span
                                        class="px-2.5 py-1 rounded-lg text-xs font-bold font-mono tracking-wide {{ $classroom->status === 'active' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                                        {{ $classroom->code }}
                                    </span>
                                </div>

                                <div
                                    class="pt-4 border-t border-slate-100 dark:border-slate-700/50 flex items-center justify-between">
                                    <span
                                        class="text-xs font-semibold uppercase tracking-wider text-slate-400 border border-slate-200 dark:border-slate-700 px-2 py-1 rounded block">
                                        {{ $classroom->status === 'active' ? 'AKTIF' : 'ARSIP' }}
                                    </span>

                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center text-slate-400 group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection