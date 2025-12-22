@extends('layouts.admin')

@section('title', 'Kelola Berita')
@section('page-title', 'Kelola Berita')
@section('page-subtitle', 'Daftar semua berita dan artikel')

@section('content')
    <div class="mb-8 animate-fade-in">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Daftar Berita</h2>
                <p class="text-slate-600 dark:text-slate-400">Total <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $news->total() }}</span> berita ditemukan</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-300"></div>
                    <a href="{{ route('admin.news.create') }}"
                        class="relative inline-flex items-center px-6 py-3.5 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-2xl hover:shadow-blue-500/40 transition-all duration-300 transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Buat Berita Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-2xl overflow-hidden border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-2xl shadow-blue-500/5 animate-slide-up">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-50/80 to-cyan-50/50 dark:from-slate-800/80 dark:to-slate-900/50">
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                JUDUL BERITA
                            </div>
                        </th>
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            KATEGORI
                        </th>
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            STATUS
                        </th>
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                TANGGAL
                            </div>
                        </th>
                        <th class="px-8 py-5 text-right text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            AKSI
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-700/30">
                    @forelse($news as $item)
                        <tr class="group hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-white/50 dark:hover:from-slate-800/50 dark:hover:to-slate-900/30 transition-all duration-300 hover:shadow-inner">
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        @if($item->featured_image)
                                            <img src="{{ Storage::url($item->featured_image) }}"
                                                class="w-14 h-14 rounded-xl object-cover shadow-lg group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
                                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="absolute -bottom-1 -right-1 w-6 h-6 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-full flex items-center justify-center">
                                            <span class="text-xs font-bold text-white">{{ $item->views ?? 0 }}</span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 line-clamp-2">
                                            {{ $item->title }}
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                            {{ Str::limit(strip_tags($item->content), 60) }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/30 dark:to-cyan-900/30 dark:text-blue-300 shadow-sm">
                                    {{ $item->category ?? 'Umum' }}
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="relative">
                                    <div class="absolute inset-0 bg-gradient-to-r {{ $item->is_published ? 'from-emerald-500/10 to-green-500/5' : 'from-amber-500/10 to-yellow-500/5' }} rounded-lg blur-sm group-hover:blur-md transition-all duration-300"></div>
                                    <span class="relative inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold {{ $item->is_published ? 'bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-700 dark:from-emerald-900/40 dark:to-green-900/40 dark:text-emerald-300' : 'bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-700 dark:from-amber-900/40 dark:to-yellow-900/40 dark:text-amber-300' }}">
                                        <span class="w-2 h-2 rounded-full {{ $item->is_published ? 'bg-emerald-500' : 'bg-amber-500' }} mr-2 animate-pulse"></span>
                                        {{ $item->is_published ? 'Dipublikasikan' : 'Draft' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="space-y-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">
                                        {{ $item->created_at->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $item->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-end space-x-3">
                                    <form action="{{ route('admin.news.toggle', $item) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                            class="relative p-2.5 rounded-xl bg-gradient-to-br from-slate-100 to-white dark:from-slate-800 dark:to-slate-900 shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300 group/toggle"
                                            title="{{ $item->is_published ? 'Sembunyikan' : 'Publikasikan' }}">
                                            <div class="absolute inset-0 bg-gradient-to-r {{ $item->is_published ? 'from-emerald-500/20 to-green-500/10' : 'from-amber-500/20 to-yellow-500/10' }} rounded-xl opacity-0 group-hover/toggle:opacity-100 transition-opacity duration-300"></div>
                                            <svg class="relative w-5 h-5 {{ $item->is_published ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </button>
                                    </form>
                                    
                                    <a href="{{ route('admin.news.edit', $item) }}"
                                        class="relative p-2.5 rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300 group/edit">
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-cyan-500/10 rounded-xl opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300"></div>
                                        <svg class="relative w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
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
                            <td colspan="5" class="px-8 py-16 text-center">
                                <div class="max-w-md mx-auto">
                                    <div class="relative">
                                        <div class="absolute -inset-4 bg-gradient-to-r from-blue-500/10 to-cyan-500/10 rounded-3xl blur-xl"></div>
                                        <div class="relative bg-gradient-to-br from-white/80 to-slate-50/50 dark:from-slate-900/80 dark:to-slate-800/50 rounded-2xl p-8">
                                            <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center shadow-xl">
                                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum ada berita</h3>
                                            <p class="text-slate-600 dark:text-slate-400 mb-6">Mulai buat berita pertama Anda</p>
                                            <a href="{{ route('admin.news.create') }}"
                                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                                Buat Berita Pertama
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
        
        @if($news->hasPages())
            <div class="px-8 py-6 border-t border-slate-200/50 dark:border-slate-700/30 bg-gradient-to-r from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Menampilkan {{ $news->firstItem() }} - {{ $news->lastItem() }} dari {{ $news->total() }} berita
                    </p>
                    <div class="flex items-center space-x-2">
                        {{ $news->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="md:hidden mt-6 space-y-4">
        @foreach($news as $item)
            <div class="glass-card rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-xl shadow-blue-500/5 animate-fade-in">
                <div class="flex items-start space-x-4 mb-4">
                    <div class="relative">
                        @if($item->featured_image)
                            <img src="{{ Storage::url($item->featured_image) }}"
                                class="w-16 h-16 rounded-xl object-cover shadow-lg">
                        @else
                            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-slate-900 dark:text-white line-clamp-2">{{ $item->title }}</h3>
                        <div class="flex items-center space-x-3 mt-2">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/30 dark:to-cyan-900/30 dark:text-blue-300">
                                {{ $item->category ?? 'Umum' }}
                            </span>
                            <span class="flex items-center text-sm text-slate-600 dark:text-slate-400">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $item->views ?? 0 }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-slate-700/50">
                    <div class="space-y-1">
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold {{ $item->is_published ? 'bg-gradient-to-r from-emerald-50 to-green-50 text-emerald-700 dark:from-emerald-900/40 dark:to-green-900/40 dark:text-emerald-300' : 'bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-700 dark:from-amber-900/40 dark:to-yellow-900/40 dark:text-amber-300' }}">
                                <span class="w-2 h-2 rounded-full {{ $item->is_published ? 'bg-emerald-500' : 'bg-amber-500' }} mr-2"></span>
                                {{ $item->is_published ? 'Dipublikasikan' : 'Draft' }}
                            </span>
                        </div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $item->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <form action="{{ route('admin.news.toggle', $item) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                                <svg class="w-5 h-5 {{ $item->is_published ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.news.edit', $item) }}"
                            class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if($news->hasPages())
            <div class="glass-card rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 backdrop-blur-xl">
                {{ $news->links() }}
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
    
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -15px rgba(59, 130, 246, 0.4);
    }
</style>
@endpush