@extends('layouts.admin')

@section('title', 'Kelola Kalender')
@section('page-title', 'Kelola Kalender')
@section('page-subtitle', 'Kelola jadwal dan event sekolah')

@section('content')
    <div class="mb-8 animate-fade-in">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Jadwal Akademik</h2>
                <p class="text-slate-600 dark:text-slate-400">Total <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $events->total() }}</span> event ditemukan</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-300"></div>
                    <a href="{{ route('admin.calendar.create') }}"
                        class="relative inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Event Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($upcomingEvents->count() > 0)
        <div class="mb-8 animate-slide-up">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">Event Mendatang</h3>
                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ $upcomingEvents->count() }} event dalam 30 hari ke depan</p>
                </div>
                <svg class="w-6 h-6 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($upcomingEvents as $upcoming)
                    <div class="glass-card rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 backdrop-blur-xl hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 group hover:-translate-y-1"
                         style="border-left: 4px solid {{ $upcoming->color }}">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">{{ $upcoming->title }}</h4>
                                @if($upcoming->description)
                                    <p class="text-sm text-slate-600 dark:text-slate-400 mt-2 line-clamp-2">{{ $upcoming->description }}</p>
                                @endif
                            </div>
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center ml-4" style="background-color: {{ $upcoming->color }}20">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $upcoming->color }}"></div>
                            </div>
                        </div>
                        
                        <div class="space-y-3">
                            <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="font-medium">{{ $upcoming->event_date->format('d M Y') }}</span>
                                @if(!$upcoming->is_all_day)
                                    <span class="mx-2">•</span>
                                    <span>{{ $upcoming->event_date->format('H:i') }}</span>
                                @endif
                            </div>
                            
                            @if($upcoming->location)
                                <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="truncate">{{ $upcoming->location }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center justify-between mt-6 pt-4 border-t border-slate-100 dark:border-slate-700/30">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-slate-100 to-slate-50 dark:from-slate-800 dark:to-slate-700 text-slate-700 dark:text-slate-300">
                                {{ $upcoming->category ?? 'Umum' }}
                            </span>
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $upcoming->event_date->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div class="glass-card rounded-2xl overflow-hidden border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-2xl shadow-blue-500/5 animate-slide-up">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50/80 to-cyan-50/50 dark:from-slate-800/80 dark:to-slate-900/50">
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                EVENT
                            </div>
                        </th>
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                TANGGAL
                            </div>
                        </th>
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            SEMESTER
                        </th>
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            KATEGORI
                        </th>
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            LOKASI
                        </th>
                        <th class="px-8 py-5 text-right text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            AKSI
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-700/30">
                    @forelse($events as $event)
                        <tr class="group hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-white/50 dark:hover:from-slate-800/50 dark:hover:to-slate-900/30 transition-all duration-300 hover:shadow-inner">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: {{ $event->color }}20">
                                            <div class="w-4 h-4 rounded-full" style="background-color: {{ $event->color }}"></div>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 line-clamp-2">
                                            {{ $event->title }}
                                        </p>
                                        @if($event->description)
                                            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 line-clamp-1">
                                                {{ $event->description }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="space-y-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">
                                        {{ $event->event_date->format('d M Y') }}
                                    </p>
                                    @if(!$event->is_all_day)
                                        <p class="text-sm text-slate-600 dark:text-slate-400 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $event->event_date->format('H:i') }}
                                        </p>
                                    @else
                                        <span class="text-xs px-2 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                            Sepanjang Hari
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="space-y-1">
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $event->academic_year ?? '-' }}</p>
                                    @if($event->semester)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $event->semester === 'ganjil' ? 'bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/30 dark:to-cyan-900/30 dark:text-blue-300' : 'bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-700 dark:from-emerald-900/30 dark:to-green-900/30 dark:text-emerald-300' }}">
                                            Semester {{ ucfirst($event->semester) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/30 dark:to-cyan-900/30 dark:text-blue-300 shadow-sm">
                                    {{ $event->category ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                @if($event->location)
                                    <div class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        </svg>
                                        <span class="truncate max-w-[120px]">{{ $event->location }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-slate-400 dark:text-slate-500">-</span>
                                @endif
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.calendar.edit', $event) }}"
                                        class="relative p-2.5 rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300 group/edit">
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-cyan-500/10 rounded-xl opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300"></div>
                                        <svg class="relative w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.calendar.destroy', $event) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="relative p-2.5 rounded-xl bg-gradient-to-br from-red-50 to-pink-50 dark:from-red-900/30 dark:to-pink-900/20 shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300 group/delete">
                                            <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-pink-500/10 rounded-xl opacity-0 group-hover/delete:opacity-100 transition-opacity duration-300"></div>
                                            <svg class="relative w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-16 text-center">
                                <div class="max-w-md mx-auto">
                                    <div class="relative">
                                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-3xl blur-xl"></div>
                                        <div class="relative bg-gradient-to-br from-white/80 to-slate-50/50 dark:from-slate-900/80 dark:to-slate-800/50 rounded-2xl p-8">
                                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-xl">
                                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum ada event</h3>
                                            <p class="text-slate-600 dark:text-slate-400 mb-6">Mulai tambahkan jadwal akademik pertama Anda</p>
                                            <a href="{{ route('admin.calendar.create') }}"
                                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Buat Event Pertama
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($events->hasPages())
            <div class="px-8 py-6 border-t border-slate-200/50 dark:border-slate-700/30 bg-gradient-to-r from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Menampilkan {{ $events->firstItem() }} - {{ $events->lastItem() }} dari {{ $events->total() }} event
                    </p>
                    <div class="flex items-center space-x-2">
                        {{ $events->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="md:hidden mt-6">
        @foreach($events as $event)
            <div class="glass-card rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-xl shadow-blue-500/5 mb-6 animate-slide-up">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1 mr-4">
                        <div class="flex items-center mb-2">
                            <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ $event->color }}"></div>
                            <h3 class="font-bold text-slate-900 dark:text-white">{{ $event->title }}</h3>
                        </div>
                        @if($event->description)
                            <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">{{ $event->description }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Tanggal</p>
                            <p class="font-medium text-slate-900 dark:text-white">{{ $event->event_date->format('d M Y') }}</p>
                            @if(!$event->is_all_day)
                                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $event->event_date->format('H:i') }}</p>
                            @endif
                        </div>
                        
                        <div class="space-y-1">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Kategori</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/30 dark:to-cyan-900/30 dark:text-blue-300">
                                {{ $event->category ?? 'Umum' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($event->location)
                        <div class="space-y-1">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Lokasi</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400">{{ $event->location }}</p>
                        </div>
                    @endif
                    
                    <div class="space-y-1">
                        <p class="text-xs text-slate-500 dark:text-slate-400">Semester</p>
                        <div class="flex items-center space-x-3">
                            <span class="font-medium text-slate-900 dark:text-white">{{ $event->academic_year ?? '-' }}</span>
                            @if($event->semester)
                                <span class="text-sm px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                    {{ ucfirst($event->semester) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-end space-x-3 mt-6 pt-4 border-t border-slate-100 dark:border-slate-700/30">
                    <a href="{{ route('admin.calendar.edit', $event) }}"
                        class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                        <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                    
                    <form action="{{ route('admin.calendar.destroy', $event) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
        
        @if($events->hasPages())
            <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6 mt-6">
                {{ $events->links('vendor.pagination.simple-tailwind') }}
            </div>
        @endif
    </div>
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
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .shadow-glow {
        box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.5);
    }
    
    .dark .shadow-glow {
        box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.3);
    }
</style>
@endpush