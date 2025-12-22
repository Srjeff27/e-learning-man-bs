@extends('layouts.student')

@section('title', 'Kelas Saya')

@section('content')
    <div class="animate-fade-in">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Kelas Saya</h1>
            <p class="text-slate-600 dark:text-slate-400">Kelola dan ikuti kelas pembelajaran Anda</p>
        </div>

        <!-- Join Class Form -->
        <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6 mb-8 shadow-xl shadow-blue-500/5 animate-slide-up">
            <div class="flex items-center mb-6">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center mr-3 shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 dark:text-white">Gabung Kelas Baru</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Masukkan kode kelas dari guru Anda</p>
                </div>
            </div>
            
            <form action="{{ route('student.classrooms.join') }}" method="POST" class="relative group">
                @csrf
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-20 group-hover:opacity-30 transition duration-300"></div>
                <div class="relative flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <input 
                                type="text" 
                                name="code" 
                                placeholder="Masukkan kode kelas (6 karakter)" 
                                class="w-full pl-12 pr-4 py-3.5 bg-white/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300 uppercase placeholder:normal-case"
                                maxlength="6" 
                                required
                                style="text-transform: uppercase;"
                            >
                        </div>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <button type="submit" 
                            class="relative inline-flex items-center justify-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Gabung Kelas
                    </button>
                </div>
            </form>
        </div>

        @if($classrooms->isEmpty())
            <!-- Empty State -->
            <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-12 text-center animate-fade-in">
                <div class="relative max-w-md mx-auto">
                    <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-3xl blur-xl"></div>
                    <div class="relative">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-2xl">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">Belum ada kelas</h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-6">Bergabunglah dengan kelas menggunakan kode yang diberikan oleh guru Anda</p>
                        <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 rounded-xl text-blue-600 dark:text-blue-400 text-sm font-semibold">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Minta kode kelas kepada guru Anda
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Classroom Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($classrooms as $classroom)
                    <a href="{{ route('student.classrooms.show', $classroom) }}" 
                       class="glass-card rounded-2xl overflow-hidden border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-xl shadow-blue-500/5 hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-500 group hover:-translate-y-2 animate-slide-up">
                        
                        <div class="relative h-40 overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500 via-blue-600 to-cyan-500 transform group-hover:scale-110 group-hover:rotate-2 transition-all duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                            </div>
                            
                            <div class="relative h-full flex flex-col justify-between p-6">
                                <div class="flex items-center justify-between">
                                    <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg">
                                        <span class="text-white text-xl font-bold">{{ substr($classroom->name, 0, 2) }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="px-3 py-1 text-xs font-semibold bg-white/20 backdrop-blur-sm rounded-full text-white border border-white/30">
                                            {{ $classroom->subject ? strtoupper(substr($classroom->subject, 0, 3)) : 'UMUM' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2 line-clamp-1">{{ $classroom->name }}</h3>
                                    <div class="flex items-center text-white/80">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 14l9-5-9-5-9 5 9 5z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                        </svg>
                                        <span class="text-sm truncate">{{ $classroom->subject ?? 'Mata Pelajaran' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-6 bg-gradient-to-b from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $classroom->teacher->name ?? 'Guru' }}</span>
                                </div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $classroom->created_at->format('d M Y') }}
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700/30">
                                <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>{{ $classroom->students_count ?? 0 }} Siswa</span>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/30 dark:to-cyan-900/30 dark:text-blue-300 font-semibold">
                                    Kode: {{ $classroom->code }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Mobile View for Classrooms -->
    @if(!$classrooms->isEmpty())
        <div class="sm:hidden mt-6">
            @foreach($classrooms as $classroom)
                <a href="{{ route('student.classrooms.show', $classroom) }}" 
                   class="glass-card rounded-2xl overflow-hidden border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-xl shadow-blue-500/5 mb-6 group">
                    
                    <div class="relative h-32">
                        <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                        </div>
                        
                        <div class="relative h-full p-5">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-10 h-10 rounded-xl bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <span class="text-white font-bold">{{ substr($classroom->name, 0, 2) }}</span>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold bg-white/20 backdrop-blur-sm rounded-full text-white">
                                    {{ $classroom->subject ? strtoupper(substr($classroom->subject, 0, 3)) : 'UMUM' }}
                                </span>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-bold text-white mb-1 line-clamp-1">{{ $classroom->name }}</h3>
                                <p class="text-sm text-white/80 truncate">{{ $classroom->subject ?? 'Mata Pelajaran' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-5">
                        <div class="flex items-center text-sm text-slate-600 dark:text-slate-400 mb-4">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $classroom->teacher->name ?? 'Guru' }}
                        </div>
                        
                        <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700/30">
                            <div class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ $classroom->students_count ?? 0 }} Siswa
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                                Kode: {{ $classroom->code }}
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection

@push('styles')
<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
    
    .animate-slide-up {
        animation: slide-up 0.5s ease-out;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.7);
    }
    
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .shadow-glow {
        box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.5);
    }
    
    .dark .shadow-glow {
        box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.3);
    }
    
    input::placeholder {
        text-transform: none !important;
    }
</style>
@endpush