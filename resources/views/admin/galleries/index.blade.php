@extends('layouts.admin')

@section('title', 'Kelola Galeri')
@section('page-title', 'Kelola Galeri')
@section('page-subtitle', 'Daftar semua foto dan video galeri')

@section('content')
    <div class="mb-8 animate-fade-in">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Koleksi Galeri</h2>
                <p class="text-slate-600 dark:text-slate-400">Total <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $galleries->total() }}</span> item multimedia</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-300"></div>
                    <a href="{{ route('admin.galleries.create') }}"
                        class="relative inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Item Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($galleries as $item)
            <div class="glass-card rounded-2xl overflow-hidden border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-xl shadow-blue-500/5 hover:shadow-2xl hover:shadow-blue-500/20 transition-all duration-500 group hover:-translate-y-2 animate-slide-up">
                <div class="relative aspect-square overflow-hidden">
                    @if($item->type === 'photo')
                        <img src="{{ Storage::url($item->file_path) }}"
                            class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:rotate-1">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/0 via-transparent to-transparent group-hover:from-black/40 group-hover:via-black/20 group-hover:to-transparent transition-all duration-500"></div>
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-600 via-blue-500 to-cyan-500 flex items-center justify-center">
                            <div class="relative">
                                <div class="absolute inset-0 bg-white/20 rounded-full animate-ping"></div>
                                <div class="relative w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-between p-5">
                        <div class="flex justify-between items-start">
                            @if($item->is_featured)
                                <div class="relative">
                                    <div class="absolute -inset-1 bg-gradient-to-r from-amber-500 to-yellow-400 rounded-full blur opacity-70"></div>
                                    <span class="relative px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-amber-500 to-yellow-400 text-white rounded-full shadow-lg">
                                        <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        FEATURED
                                    </span>
                                </div>
                            @endif
                            
                            <div class="flex items-center space-x-2">
                                <span class="px-3 py-1.5 text-xs font-semibold bg-white/20 backdrop-blur-sm rounded-full text-white border border-white/30">
                                    {{ strtoupper($item->type) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-center space-x-4">
                            <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                class="relative p-3 rounded-xl bg-gradient-to-br from-white/20 to-white/10 backdrop-blur-sm hover:from-white/30 hover:to-white/20 transition-all duration-300 group/view">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/30 to-cyan-500/20 rounded-xl opacity-0 group-hover/view:opacity-100 transition-opacity duration-300"></div>
                                <svg class="relative w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            
                            <a href="{{ route('admin.galleries.edit', $item) }}"
                                class="relative p-3 rounded-xl bg-gradient-to-br from-white/20 to-white/10 backdrop-blur-sm hover:from-white/30 hover:to-white/20 transition-all duration-300 group/edit">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/30 to-cyan-500/20 rounded-xl opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300"></div>
                                <svg class="relative w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            
                            <form action="{{ route('admin.galleries.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="relative p-3 rounded-xl bg-gradient-to-br from-red-500/60 to-pink-500/40 backdrop-blur-sm hover:from-red-500/70 hover:to-pink-500/50 transition-all duration-300 group/delete">
                                    <div class="absolute inset-0 bg-gradient-to-r from-red-500/40 to-pink-500/30 rounded-xl opacity-0 group-hover/delete:opacity-100 transition-opacity duration-300"></div>
                                    <svg class="relative w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 text-xs font-semibold bg-gradient-to-r from-blue-600/90 to-cyan-500/90 text-white rounded-full shadow-lg backdrop-blur-sm">
                            {{ $item->category ?? 'UMUM' }}
                        </span>
                    </div>
                </div>
                
                <div class="p-5 bg-gradient-to-b from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="font-bold text-slate-900 dark:text-white line-clamp-1 flex-1 mr-2">{{ $item->title }}</h3>
                        <span class="text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap">
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2 mb-4">
                        {{ $item->description ?: 'Tidak ada deskripsi' }}
                    </p>
                    
                    <div class="flex items-center justify-between pt-3 border-t border-slate-200/50 dark:border-slate-700/30">
                        <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $item->created_at->diffForHumans() }}
                        </div>
                        <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $item->views ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full animate-fade-in">
                <div class="relative max-w-2xl mx-auto">
                    <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-3xl blur-xl"></div>
                    <div class="relative glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-12 text-center">
                        <div class="w-24 h-24 mx-auto mb-8 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-3xl flex items-center justify-center shadow-2xl">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Galeri Masih Kosong</h3>
                        <p class="text-slate-600 dark:text-slate-400 mb-8 max-w-md mx-auto">
                            Mulai tambahkan foto dan video untuk memperkaya konten galeri akademik Anda
                        </p>
                        <a href="{{ route('admin.galleries.create') }}"
                            class="inline-flex items-center px-8 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Item Pertama
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="mt-8 animate-fade-in">
            <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Menampilkan <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $galleries->firstItem() }}</span> - 
                        <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $galleries->lastItem() }}</span> dari 
                        <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $galleries->total() }}</span> item
                    </p>
                    <div class="flex items-center">
                        {{ $galleries->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="md:hidden mt-6">
        @foreach($galleries as $item)
            <div class="glass-card rounded-2xl overflow-hidden border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-xl shadow-blue-500/5 mb-6 animate-slide-up">
                <div class="relative aspect-video">
                    @if($item->type === 'photo')
                        <img src="{{ Storage::url($item->file_path) }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-600 to-cyan-500 flex items-center justify-center">
                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    @endif
                    
                    <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
                        <span class="px-3 py-1.5 text-xs font-semibold bg-gradient-to-r from-blue-600/90 to-cyan-500/90 text-white rounded-full shadow-lg">
                            {{ strtoupper($item->type) }}
                        </span>
                        @if($item->is_featured)
                            <span class="px-3 py-1.5 text-xs font-bold bg-gradient-to-r from-amber-500 to-yellow-400 text-white rounded-full shadow-lg">
                                FEATURED
                            </span>
                        @endif
                    </div>
                </div>
                
                <div class="p-5">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1 mr-3">
                            <h3 class="font-bold text-slate-900 dark:text-white mb-1">{{ $item->title }}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item->category ?? 'Umum' }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            
                            <a href="{{ route('admin.galleries.edit', $item) }}"
                                class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <p class="text-sm text-slate-600 dark:text-slate-400 mb-4 line-clamp-2">
                        {{ $item->description ?: 'Tidak ada deskripsi' }}
                    </p>
                    
                    <div class="flex items-center justify-between pt-3 border-t border-slate-200/50 dark:border-slate-700/30">
                        <span class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $item->created_at->format('d M Y') }}
                        </span>
                        <span class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            {{ $item->views ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if($galleries->hasPages())
            <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6 mt-6">
                {{ $galleries->links('vendor.pagination.simple-tailwind') }}
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
    
    .aspect-square {
        aspect-ratio: 1 / 1;
    }
    
    .aspect-video {
        aspect-ratio: 16 / 9;
    }
    
    .shadow-glow {
        box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.5);
    }
    
    .dark .shadow-glow {
        box-shadow: 0 10px 40px -10px rgba(59, 130, 246, 0.3);
    }
</style>
@endpush