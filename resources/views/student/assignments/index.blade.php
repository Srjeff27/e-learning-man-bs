@extends('layouts.student')

@section('title', 'Tugas')
@section('page-title', 'Semua Tugas')

@section('content')
    <div class="space-y-6 animate-fade-in">
        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8">
            <div class="space-y-2">
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Tugas</h1>
                <p class="text-slate-600 dark:text-slate-400">Kelola dan kerjakan semua tugas dari kelas Anda</p>
            </div>
            
            <div class="flex items-center space-x-3">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-300"></div>
                    <div class="relative glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl px-6 py-3">
                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-slate-900 dark:text-white">{{ $assignments->count() }}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-400">Total Tugas</p>
                            </div>
                            <div class="h-8 w-px bg-slate-200 dark:bg-slate-700"></div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $graded->count() }}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-400">Telah Dinilai</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-2" 
             x-data="{ tab: 'all' }">
            <div class="flex flex-wrap gap-2">
                <button @click="tab = 'all'"
                    :class="tab === 'all' ? 
                    'bg-gradient-to-r from-blue-500 to-cyan-400 text-white shadow-lg' : 
                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 text-slate-700 dark:text-slate-300 hover:bg-white/80 dark:hover:bg-slate-800/50'"
                    class="relative px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 hover:shadow-md group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-300"></div>
                    <span class="relative flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Semua ({{ $assignments->count() }})
                    </span>
                </button>
                
                <button @click="tab = 'pending'"
                    :class="tab === 'pending' ? 
                    'bg-gradient-to-r from-amber-500 to-orange-400 text-white shadow-lg' : 
                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 text-slate-700 dark:text-slate-300 hover:bg-white/80 dark:hover:bg-slate-800/50'"
                    class="relative px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 hover:shadow-md group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-orange-400 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-300"></div>
                    <span class="relative flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Belum Dikerjakan ({{ $pending->count() }})
                    </span>
                </button>
                
                <button @click="tab = 'submitted'"
                    :class="tab === 'submitted' ? 
                    'bg-gradient-to-r from-blue-500 to-indigo-400 text-white shadow-lg' : 
                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 text-slate-700 dark:text-slate-300 hover:bg-white/80 dark:hover:bg-slate-800/50'"
                    class="relative px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 hover:shadow-md group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-400 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-300"></div>
                    <span class="relative flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Dikumpulkan ({{ $submitted->count() }})
                    </span>
                </button>
                
                <button @click="tab = 'graded'"
                    :class="tab === 'graded' ? 
                    'bg-gradient-to-r from-emerald-500 to-green-400 text-white shadow-lg' : 
                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 text-slate-700 dark:text-slate-300 hover:bg-white/80 dark:hover:bg-slate-800/50'"
                    class="relative px-5 py-2.5 rounded-xl font-semibold text-sm transition-all duration-300 hover:shadow-md group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-emerald-500 to-green-400 rounded-2xl blur opacity-0 group-hover:opacity-20 transition duration-300"></div>
                    <span class="relative flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Dinilai ({{ $graded->count() }})
                    </span>
                </button>
            </div>

            {{-- All Assignments --}}
            <div x-show="tab === 'all'" class="mt-6 space-y-4">
                @forelse($assignments as $assignment)
                    @include('student.assignments._card', ['assignment' => $assignment])
                @empty
                    <div class="text-center py-12 animate-fade-in">
                        <div class="max-w-md mx-auto">
                            <div class="relative">
                                <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-3xl blur-xl"></div>
                                <div class="relative bg-gradient-to-br from-white/80 to-slate-50/50 dark:from-slate-900/80 dark:to-slate-800/50 rounded-2xl p-8">
                                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-xl">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum ada tugas</h3>
                                    <p class="text-slate-600 dark:text-slate-400">Guru belum menambahkan tugas untuk kelas Anda</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pending Assignments --}}
            <div x-show="tab === 'pending'" x-cloak class="mt-6 space-y-4">
                @forelse($pending as $assignment)
                    @include('student.assignments._card', ['assignment' => $assignment])
                @empty
                    <div class="text-center py-12 animate-fade-in">
                        <div class="max-w-md mx-auto">
                            <div class="relative">
                                <div class="absolute -inset-4 bg-gradient-to-r from-emerald-500/10 to-green-500/10 rounded-3xl blur-xl"></div>
                                <div class="relative bg-gradient-to-br from-white/80 to-slate-50/50 dark:from-slate-900/80 dark:to-slate-800/50 rounded-2xl p-8">
                                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-emerald-500 to-green-400 rounded-2xl flex items-center justify-center shadow-xl">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Semua tugas selesai! 🎉</h3>
                                    <p class="text-slate-600 dark:text-slate-400 mb-4">Anda telah menyelesaikan semua tugas yang diberikan</p>
                                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/20 rounded-xl text-emerald-700 dark:text-emerald-300 text-sm font-semibold">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Pertahankan performa Anda!
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Submitted Assignments --}}
            <div x-show="tab === 'submitted'" x-cloak class="mt-6 space-y-4">
                @forelse($submitted as $assignment)
                    @include('student.assignments._card', ['assignment' => $assignment])
                @empty
                    <div class="text-center py-12 animate-fade-in">
                        <div class="max-w-md mx-auto">
                            <div class="relative">
                                <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/10 to-indigo-500/10 rounded-3xl blur-xl"></div>
                                <div class="relative bg-gradient-to-br from-white/80 to-slate-50/50 dark:from-slate-900/80 dark:to-slate-800/50 rounded-2xl p-8">
                                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-indigo-400 rounded-2xl flex items-center justify-center shadow-xl">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Tidak ada tugas yang menunggu</h3>
                                    <p class="text-slate-600 dark:text-slate-400">Semua tugas yang dikumpulkan telah diproses</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Graded Assignments --}}
            <div x-show="tab === 'graded'" x-cloak class="mt-6 space-y-4">
                @forelse($graded as $assignment)
                    @include('student.assignments._card', ['assignment' => $assignment])
                @empty
                    <div class="text-center py-12 animate-fade-in">
                        <div class="max-w-md mx-auto">
                            <div class="relative">
                                <div class="absolute -inset-4 bg-gradient-to-r from-amber-500/10 to-yellow-500/10 rounded-3xl blur-xl"></div>
                                <div class="relative bg-gradient-to-br from-white/80 to-slate-50/50 dark:from-slate-900/80 dark:to-slate-800/50 rounded-2xl p-8">
                                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-amber-500 to-yellow-400 rounded-2xl flex items-center justify-center shadow-xl">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum ada tugas yang dinilai</h3>
                                    <p class="text-slate-600 dark:text-slate-400 mb-4">Nilai akan muncul di sini setelah tugas diperiksa</p>
                                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/30 dark:to-yellow-900/20 rounded-xl text-amber-700 dark:text-amber-300 text-sm font-semibold">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Tunggu hasil penilaian
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Mobile Filter Tabs --}}
    <div class="md:hidden mt-6">
        <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-4 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-900 dark:text-white">Filter Tugas</h3>
                <span class="text-sm text-slate-600 dark:text-slate-400">{{ $assignments->count() }} total</span>
            </div>
            
            <div class="grid grid-cols-2 gap-2">
                <button @click="tab = 'all'" x-data x-on:click="tab = 'all'"
                    :class="tab === 'all' ? 
                    'bg-gradient-to-r from-blue-500 to-cyan-400 text-white shadow-lg' : 
                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 text-slate-700 dark:text-slate-300'"
                    class="relative px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300">
                    <span class="relative flex flex-col items-center">
                        <span class="text-lg font-bold">{{ $assignments->count() }}</span>
                        <span class="text-xs mt-1">Semua</span>
                    </span>
                </button>
                
                <button @click="tab = 'pending'" x-data x-on:click="tab = 'pending'"
                    :class="tab === 'pending' ? 
                    'bg-gradient-to-r from-amber-500 to-orange-400 text-white shadow-lg' : 
                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 text-slate-700 dark:text-slate-300'"
                    class="relative px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300">
                    <span class="relative flex flex-col items-center">
                        <span class="text-lg font-bold">{{ $pending->count() }}</span>
                        <span class="text-xs mt-1">Belum</span>
                    </span>
                </button>
                
                <button @click="tab = 'submitted'" x-data x-on:click="tab = 'submitted'"
                    :class="tab === 'submitted' ? 
                    'bg-gradient-to-r from-blue-500 to-indigo-400 text-white shadow-lg' : 
                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 text-slate-700 dark:text-slate-300'"
                    class="relative px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300">
                    <span class="relative flex flex-col items-center">
                        <span class="text-lg font-bold">{{ $submitted->count() }}</span>
                        <span class="text-xs mt-1">Dikumpulkan</span>
                    </span>
                </button>
                
                <button @click="tab = 'graded'" x-data x-on:click="tab = 'graded'"
                    :class="tab === 'graded' ? 
                    'bg-gradient-to-r from-emerald-500 to-green-400 text-white shadow-lg' : 
                    'bg-gradient-to-br from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30 text-slate-700 dark:text-slate-300'"
                    class="relative px-4 py-3 rounded-xl font-semibold text-sm transition-all duration-300">
                    <span class="relative flex flex-col items-center">
                        <span class="text-lg font-bold">{{ $graded->count() }}</span>
                        <span class="text-xs mt-1">Dinilai</span>
                    </span>
                </button>
            </div>
        </div>

        {{-- Mobile Content --}}
        <div x-show="tab === 'all'" class="space-y-4">
            @forelse($assignments as $assignment)
                @include('student.assignments._card', ['assignment' => $assignment])
            @empty
                <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Belum ada tugas</h3>
                    <p class="text-slate-600 dark:text-slate-400">Guru belum menambahkan tugas</p>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
        
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animate-fade-in {
            animation: fade-in 0.6s ease-out;
        }
        
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .dark .glass-card {
            background: rgba(15, 23, 42, 0.7);
        }
    </style>
@endsection