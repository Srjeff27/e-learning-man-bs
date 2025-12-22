@extends('layouts.admin')

@section('title', 'Kelola Banner')
@section('page-title', 'Kelola Banner Pengumuman')

@section('content')
<div class="max-w-7xl mx-auto" x-data="bannerManager()">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8">
        <div class="space-y-2">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Kelola Banner</h1>
            <p class="text-slate-600 dark:text-slate-400">Kelola banner pengumuman yang tampil di halaman beranda website</p>
        </div>
        <div class="flex items-center space-x-4">
            <!-- Search -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" x-model="searchQuery" @input="filterBanners"
                    class="pl-10 pr-4 py-3 w-64 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Cari banner...">
            </div>
            <!-- Add Button -->
            <a href="{{ route('admin.banners.create') }}" 
                class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center space-x-2 group">
                <div class="p-1 rounded-lg bg-white/20 group-hover:scale-110 transition-transform">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <span>Tambah Banner</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Total Banner</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $banners->count() }}</p>
                </div>
                <div class="p-3 rounded-xl bg-blue-500/10">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Banner Aktif</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $banners->where('is_active', true)->count() }}</p>
                </div>
                <div class="p-3 rounded-xl bg-emerald-500/10">
                    <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Banner Nonaktif</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">{{ $banners->where('is_active', false)->count() }}</p>
                </div>
                <div class="p-3 rounded-xl bg-amber-500/10">
                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Urutan Tertinggi</p>
                    <p class="text-3xl font-bold text-slate-900 dark:text-white mt-2">#{{ $banners->max('order') ?? 0 }}</p>
                </div>
                <div class="p-3 rounded-xl bg-violet-500/10">
                    <svg class="w-8 h-8 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="glass-card rounded-2xl p-4 mb-6 border-l-4 border-emerald-500 bg-gradient-to-r from-emerald-50/50 to-white dark:from-emerald-900/10 dark:to-slate-800/10 animate-slide-in">
        <div class="flex items-center">
            <div class="p-2 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 mr-3">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="flex-1">
                <p class="font-medium text-emerald-800 dark:text-emerald-300">{{ session('success') }}</p>
            </div>
            <button @click="$el.remove()" class="p-1 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 rounded-lg">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    @endif

    <!-- Banners Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Daftar Banner</h3>
                <div class="flex items-center space-x-4">
                    <!-- Filter -->
                    <select x-model="statusFilter" @change="filterBanners" 
                        class="px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">
                        <option value="all">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                    
                    <!-- Sort -->
                    <select x-model="sortOrder" @change="filterBanners" 
                        class="px-4 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">
                        <option value="order_asc">Urutan: Rendah ke Tinggi</option>
                        <option value="order_desc">Urutan: Tinggi ke Rendah</option>
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Content -->
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-blue-500/5 to-cyan-500/5">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase">Urutan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase">Banner</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase">Konten</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase">Tanggal</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-slate-700 dark:text-slate-300 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($banners as $banner)
                    <tr class="hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-cyan-50/30 dark:hover:from-blue-900/10 dark:hover:to-cyan-900/10 transition-all duration-300 group"
                        x-data="{ 
                            showActions: false,
                            deleting: false 
                        }" 
                        @mouseenter="showActions = true" 
                        @mouseleave="showActions = false">
                        <!-- Order -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold shadow-lg">
                                        {{ $banner->order }}
                                    </div>
                                    <div class="absolute -inset-1 rounded-xl bg-blue-500/20 blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Prioritas</p>
                                </div>
                            </div>
                        </td>

                        <!-- Banner Info -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                @if($banner->image_url)
                                <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 border border-slate-200 dark:border-slate-700">
                                    <img src="{{ Storage::url($banner->image_url) }}" 
                                        class="w-full h-full object-cover"
                                        alt="{{ $banner->title }}">
                                </div>
                                @endif
                                <div>
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $banner->title }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                        {{ Str::limit($banner->subtitle, 40) }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <!-- Content -->
                        <td class="px-6 py-4">
                            <div class="max-w-xs">
                                <p class="text-slate-700 dark:text-slate-300 text-sm line-clamp-2">
                                    {{ strip_tags($banner->content) }}
                                </p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                    {{ Str::limit($banner->button_text, 20) }}
                                </p>
                            </div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col items-start space-y-2">
                                @if($banner->is_active)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800 dark:from-emerald-900/30 dark:to-green-900/30 dark:text-emerald-300">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></div>
                                        Aktif
                                    </div>
                                </span>
                                @else
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-rose-100 to-pink-100 text-rose-800 dark:from-rose-900/30 dark:to-pink-900/30 dark:text-rose-300">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 rounded-full bg-rose-500 mr-2"></div>
                                        Nonaktif
                                    </div>
                                </span>
                                @endif
                                
                                @if($banner->is_urgent)
                                <span class="px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 dark:from-amber-900/30 dark:to-orange-900/30 dark:text-amber-300">
                                    <div class="flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.998-.833-2.732 0L4.346 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                        </svg>
                                        Penting
                                    </div>
                                </span>
                                @endif
                            </div>
                        </td>

                        <!-- Dates -->
                        <td class="px-6 py-4">
                            <div class="space-y-1">
                                <p class="text-sm text-slate-900 dark:text-white">Dibuat</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">
                                    {{ $banner->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end space-x-2 opacity-0 group-hover:opacity-100 transition-all duration-300"
                                :class="{ 'opacity-100': showActions }">
                                <!-- Preview -->
                                <a href="#" @click.prevent="previewBanner({{ $banner->id }})" 
                                    class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-800/50 transition-all duration-300 transform hover:scale-110"
                                    title="Preview">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.banners.edit', $banner) }}" 
                                    class="p-2 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 hover:bg-cyan-200 dark:hover:bg-cyan-800/50 transition-all duration-300 transform hover:scale-110"
                                    title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <!-- Toggle Status -->
                                <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                        class="p-2 rounded-lg {{ $banner->is_active ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-200 dark:hover:bg-amber-800/50' : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-200 dark:hover:bg-emerald-800/50' }} transition-all duration-300 transform hover:scale-110"
                                        title="{{ $banner->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        @if($banner->is_active)
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                        </svg>
                                        @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        @endif
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline" 
                                    x-ref="deleteForm{{ $banner->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @click="confirmDelete({{ $banner->id }}, '{{ $banner->title }}')" 
                                        class="p-2 rounded-lg bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 hover:bg-rose-200 dark:hover:bg-rose-800/50 transition-all duration-300 transform hover:scale-110"
                                        title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="max-w-sm mx-auto">
                                <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-blue-500/10 to-cyan-500/10 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Belum ada banner</h3>
                                <p class="text-slate-600 dark:text-slate-400 mb-6">Mulai dengan membuat banner pertama Anda</p>
                                <a href="{{ route('admin.banners.create') }}" 
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Banner Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer -->
        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="text-sm text-slate-600 dark:text-slate-400">
                    Menampilkan <span class="font-semibold">{{ $banners->count() }}</span> dari <span class="font-semibold">{{ $banners->total() }}</span> banner
                </div>
                @if($banners->hasPages())
                <div class="flex items-center space-x-2">
                    {{ $banners->links('vendor.pagination.custom') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div x-show="showPreview" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 transition-opacity bg-slate-900/75 backdrop-blur-sm" @click="showPreview = false"></div>

        <!-- Modal content -->
        <div class="inline-block w-full max-w-4xl my-8 text-left align-middle transition-all transform glass-card rounded-2xl shadow-xl">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-semibold text-slate-900 dark:text-white">Preview Banner</h3>
                    <button @click="showPreview = false" class="p-2 text-slate-400 hover:text-slate-900 dark:hover:text-white rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div id="preview-content" class="space-y-6">
                    <!-- Preview will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 107, 255, 0.08);
    }
    
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slide-in {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
        }
        50% {
            box-shadow: 0 0 40px rgba(59, 130, 246, 0.6);
        }
    }
    
    .animate-pulse-glow {
        animation: pulse-glow 2s infinite;
    }
    
    @media (max-width: 768px) {
        .glass-card {
            padding: 1rem;
        }
        
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }
    }
</style>

<script>
    function bannerManager() {
        return {
            searchQuery: '',
            statusFilter: 'all',
            sortOrder: 'order_asc',
            showPreview: false,
            previewContent: '',
            
            init() {
                this.setupFilters();
            },
            
            setupFilters() {
                // Load saved filters from localStorage
                const savedSearch = localStorage.getItem('banner_search');
                const savedStatus = localStorage.getItem('banner_status');
                const savedSort = localStorage.getItem('banner_sort');
                
                if (savedSearch) this.searchQuery = savedSearch;
                if (savedStatus) this.statusFilter = savedStatus;
                if (savedSort) this.sortOrder = savedSort;
            },
            
            filterBanners() {
                // Save filters to localStorage
                localStorage.setItem('banner_search', this.searchQuery);
                localStorage.setItem('banner_status', this.statusFilter);
                localStorage.setItem('banner_sort', this.sortOrder);
                
                // In a real implementation, this would trigger an API call
                // For now, we'll just filter the visible rows
                const rows = document.querySelectorAll('tbody tr');
                rows.forEach(row => {
                    const title = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const status = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
                    const content = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                    
                    const searchMatch = !this.searchQuery || 
                        title.includes(this.searchQuery.toLowerCase()) ||
                        content.includes(this.searchQuery.toLowerCase());
                    
                    const statusMatch = this.statusFilter === 'all' ||
                        (this.statusFilter === 'active' && status.includes('aktif')) ||
                        (this.statusFilter === 'inactive' && status.includes('nonaktif'));
                    
                    row.style.display = searchMatch && statusMatch ? '' : 'none';
                });
            },
            
            async previewBanner(id) {
                try {
                    this.showPreview = true;
                    
                    // Simulate loading
                    document.getElementById('preview-content').innerHTML = `
                        <div class="flex justify-center items-center h-64">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
                        </div>
                    `;
                    
                    // In real implementation, fetch banner data via AJAX
                    // const response = await fetch(`/admin/banners/${id}/preview`);
                    // const data = await response.json();
                    
                    // Simulate API response
                    setTimeout(() => {
                        this.loadPreviewContent(id);
                    }, 500);
                    
                } catch (error) {
                    console.error('Error loading preview:', error);
                    this.showNotification('Gagal memuat preview', 'error');
                }
            },
            
            loadPreviewContent(id) {
                // This is a mockup. In real implementation, use actual banner data
                const mockPreview = `
                    <div class="space-y-6">
                        <div class="aspect-video rounded-xl overflow-hidden bg-gradient-to-br from-blue-500/20 to-cyan-500/20 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 mx-auto text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-slate-600 dark:text-slate-400">Preview gambar banner</p>
                            </div>
                        </div>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white mb-2">Informasi Banner</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Judul</p>
                                        <p class="font-medium text-slate-900 dark:text-white">Judul Banner Contoh</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Sub Judul</p>
                                        <p class="font-medium text-slate-900 dark:text-white">Subtitle banner contoh</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Teks Tombol</p>
                                        <p class="font-medium text-slate-900 dark:text-white">Lihat Selengkapnya</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="font-semibold text-slate-900 dark:text-white mb-2">Detail</h4>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Status</p>
                                        <span class="px-3 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-emerald-100 to-green-100 text-emerald-800">
                                            Aktif
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Urutan</p>
                                        <p class="font-medium text-slate-900 dark:text-white">#1</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-500 dark:text-slate-400">Tautan</p>
                                        <p class="font-medium text-slate-900 dark:text-white">/pengumuman/1</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="font-semibold text-slate-900 dark:text-white mb-2">Konten</h4>
                            <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-800/50">
                                <p class="text-slate-700 dark:text-slate-300">
                                    Ini adalah konten banner contoh yang akan ditampilkan di halaman beranda.
                                    Konten ini dapat berisi pengumuman penting atau informasi terkini.
                                </p>
                            </div>
                        </div>
                    </div>
                `;
                
                document.getElementById('preview-content').innerHTML = mockPreview;
            },
            
            confirmDelete(id, title) {
                if (confirm(`Apakah Anda yakin ingin menghapus banner "${title}"?`)) {
                    this.deleting = true;
                    document.querySelector(`form[x-ref="deleteForm${id}"]`).submit();
                }
            },
            
            showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-xl transition-all duration-300 transform translate-x-0 ${
                    type === 'success' ? 'bg-gradient-to-r from-emerald-500 to-green-500 text-white' :
                    type === 'error' ? 'bg-gradient-to-r from-red-500 to-rose-500 text-white' :
                    'bg-gradient-to-r from-blue-500 to-cyan-500 text-white'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                                type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"' :
                                type === 'error' ? 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"' :
                                'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                            }"/>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.transform = 'translateX(120%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        };
    }
</script>
@endsection