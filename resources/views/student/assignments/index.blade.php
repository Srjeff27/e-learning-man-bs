@extends('layouts.student')

@section('title', 'Tugas')
@section('page-title', 'Semua Tugas')

@section('content')
    <div x-data="{ tab: 'all' }" class="min-h-screen p-4 md:p-6 space-y-8 animate-fade-in-up">
        
        {{-- Header Section with Glass Effect --}}
        <div class="relative overflow-hidden rounded-3xl bg-white/40 dark:bg-slate-900/40 backdrop-blur-xl border border-white/50 dark:border-slate-700/50 shadow-lg p-6 md:p-8">
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-blue-500/20 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 rounded-full bg-cyan-500/20 blur-3xl"></div>
            
            <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="space-y-2">
                    <h1 class="text-3xl md:text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-blue-700 via-blue-600 to-cyan-500 dark:from-blue-400 dark:via-cyan-400 dark:to-white">
                        Daftar Tugas
                    </h1>
                    <p class="text-slate-600 dark:text-slate-300 font-medium text-sm md:text-base">
                        Pantau progres akademik dan kelola tenggat waktu Anda.
                    </p>
                </div>

                {{-- Stats Cards (Glass Pills) --}}
                <div class="flex flex-wrap gap-3 md:gap-4">
                    <div class="flex-1 min-w-[120px] bg-white/60 dark:bg-slate-800/60 backdrop-blur-md rounded-2xl p-4 border border-white/50 dark:border-slate-700 shadow-sm transition hover:scale-105 duration-300">
                        <div class="flex flex-col items-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1">Total</span>
                            <span class="text-2xl font-black text-slate-800 dark:text-white">{{ $assignments->count() }}</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-[120px] bg-white/60 dark:bg-slate-800/60 backdrop-blur-md rounded-2xl p-4 border border-white/50 dark:border-slate-700 shadow-sm transition hover:scale-105 duration-300">
                        <div class="flex flex-col items-center">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-1">Dinilai</span>
                            <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $graded->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Control Section --}}
        <div class="space-y-6">
            {{-- Filter Tabs (Scrollable on Mobile) --}}
            <div class="sticky top-4 z-30">
                <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide bg-white/30 dark:bg-slate-900/30 backdrop-blur-lg p-2 rounded-2xl border border-white/40 dark:border-slate-700 shadow-sm">
                    @foreach([
                        ['id' => 'all', 'label' => 'Semua', 'count' => $assignments->count(), 'icon' => 'M4 6h16M4 10h16M4 14h16M4 18h16'],
                        ['id' => 'pending', 'label' => 'Belum', 'count' => $pending->count(), 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['id' => 'submitted', 'label' => 'Selesai', 'count' => $submitted->count(), 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['id' => 'graded', 'label' => 'Dinilai', 'count' => $graded->count(), 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2']
                    ] as $item)
                        <button @click="tab = '{{ $item['id'] }}'"
                            :class="tab === '{{ $item['id'] }}' ? 
                            'bg-blue-600 text-white shadow-lg shadow-blue-500/30 ring-1 ring-blue-500' : 
                            'text-slate-600 dark:text-slate-300 hover:bg-white/50 dark:hover:bg-slate-800/50'"
                            class="flex items-center space-x-2 px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 whitespace-nowrap group">
                            <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}" />
                            </svg>
                            <span>{{ $item['label'] }}</span>
                            <span :class="tab === '{{ $item['id'] }}' ? 'bg-white/20 text-white' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-400'"
                                class="px-2 py-0.5 rounded-lg text-xs font-extrabold ml-2 transition-colors">
                                {{ $item['count'] }}
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Grid Content Area --}}
            <div class="relative min-h-[400px]">
                
                {{-- Helper for Empty State --}}
                @php
                    $emptyStates = [
                        'all' => ['title' => 'Belum ada tugas', 'desc' => 'Guru belum memposting tugas baru.', 'color' => 'blue'],
                        'pending' => ['title' => 'Tugas Selesai!', 'desc' => 'Tidak ada tugas yang harus dikerjakan.', 'color' => 'emerald'],
                        'submitted' => ['title' => 'Belum mengumpulkan', 'desc' => 'Anda belum mengumpulkan tugas apapun.', 'color' => 'indigo'],
                        'graded' => ['title' => 'Belum dinilai', 'desc' => 'Nilai akan muncul setelah diperiksa guru.', 'color' => 'amber'],
                    ];
                @endphp

                @foreach(['all' => $assignments, 'pending' => $pending, 'submitted' => $submitted, 'graded' => $graded] as $key => $collection)
                    <div x-show="tab === '{{ $key }}'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6"
                         x-cloak>
                        
                        @forelse($collection as $assignment)
                            {{-- Wrapper to ensure height consistency --}}
                            <div class="h-full transform transition-all duration-300 hover:-translate-y-1 hover:shadow-xl rounded-2xl">
                                @include('student.assignments._card', ['assignment' => $assignment])
                            </div>
                        @empty
                            <div class="col-span-full flex flex-col items-center justify-center py-16 text-center">
                                <div class="relative mb-6">
                                    <div class="absolute inset-0 bg-{{ $emptyStates[$key]['color'] }}-500/20 blur-2xl rounded-full"></div>
                                    <div class="relative bg-white/50 dark:bg-slate-800/50 backdrop-blur-xl p-6 rounded-3xl border border-white/40 dark:border-slate-700 shadow-xl">
                                        <svg class="w-16 h-16 text-{{ $emptyStates[$key]['color'] }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">{{ $emptyStates[$key]['title'] }}</h3>
                                <p class="text-slate-500 dark:text-slate-400 max-w-sm">{{ $emptyStates[$key]['desc'] }}</p>
                            </div>
                        @endforelse
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up { animation: fade-in-up 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
    </style>
@endsection