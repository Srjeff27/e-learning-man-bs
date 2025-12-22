@extends('layouts.admin')

@section('title', 'Kelola Pesan')
@section('page-title', 'Kelola Pesan')
@section('page-subtitle', 'Daftar pesan dari pengunjung website')

@section('content')
    <div class="mb-8 animate-fade-in">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="space-y-2">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Kotak Masuk</h2>
                <p class="text-slate-600 dark:text-slate-400">Kelola komunikasi dari pengunjung website</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-300"></div>
                    <div class="relative glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl px-6 py-4">
                        <div class="flex items-center">
                            <div class="relative mr-4">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-xl animate-pulse"></div>
                                <div class="relative w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-slate-900 dark:text-white">{{ $unreadCount }}</p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Pesan belum dibaca</p>
                            </div>
                        </div>
                    </div>
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                PENGGIRIM
                            </div>
                        </th>
                        <th class="px-8 py-5 text-left text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                PESAN
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
                            STATUS
                        </th>
                        <th class="px-8 py-5 text-right text-sm font-bold text-slate-700 dark:text-slate-300 tracking-wide">
                            AKSI
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50 dark:divide-slate-700/30">
                    @forelse($contacts as $contact)
                        <tr class="group hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-white/50 dark:hover:from-slate-800/50 dark:hover:to-slate-900/30 transition-all duration-300 hover:shadow-inner relative {{ !$contact->is_read ? 'bg-gradient-to-r from-blue-50/60 to-cyan-50/40 dark:from-blue-900/20 dark:to-cyan-900/10' : '' }}">
                            @if(!$contact->is_read)
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-500 to-cyan-400"></div>
                            @endif
                            
                            <td class="px-8 py-5">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                            <span class="text-white font-bold text-lg">
                                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                                            </span>
                                        </div>
                                        @if(!$contact->is_read)
                                            <div class="absolute -top-1 -right-1">
                                                <div class="relative">
                                                    <div class="absolute inset-0 bg-blue-500 rounded-full animate-ping"></div>
                                                    <div class="relative w-3 h-3 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-300 {{ !$contact->is_read ? 'font-extrabold' : '' }}">
                                            {{ $contact->name }}
                                        </p>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 truncate mt-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            {{ $contact->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="space-y-2">
                                    <p class="font-semibold text-slate-900 dark:text-white {{ !$contact->is_read ? 'font-bold' : '' }} line-clamp-2">
                                        {{ $contact->subject }}
                                    </p>
                                    <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                                        {{ $contact->message }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="space-y-1">
                                    <p class="font-semibold text-slate-900 dark:text-white">
                                        {{ $contact->created_at->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $contact->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="relative">
                                    @if($contact->is_read)
                                        <div class="absolute inset-0 bg-gradient-to-r from-slate-500/5 to-slate-400/5 rounded-lg blur-sm"></div>
                                        <span class="relative inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-gradient-to-r from-slate-50 to-slate-100 text-slate-700 dark:from-slate-800 dark:to-slate-900 dark:text-slate-300">
                                            <svg class="w-3 h-3 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Dibaca
                                        </span>
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/10 to-cyan-500/5 rounded-lg blur-sm group-hover:blur-md transition-all duration-300"></div>
                                        <span class="relative inline-flex items-center px-4 py-2 rounded-lg text-sm font-semibold bg-gradient-to-r from-blue-50 to-cyan-50 text-blue-700 dark:from-blue-900/40 dark:to-cyan-900/40 dark:text-blue-300">
                                            <span class="w-2 h-2 rounded-full bg-gradient-to-br from-blue-500 to-cyan-400 mr-2 animate-pulse"></span>
                                            Baru
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex items-center justify-end space-x-3">
                                    <a href="{{ route('admin.contacts.show', $contact) }}"
                                        class="relative p-2.5 rounded-xl bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/30 dark:to-cyan-900/20 shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300 group/view"
                                        title="Lihat Detail">
                                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500/20 to-cyan-500/10 rounded-xl opacity-0 group-hover/view:opacity-100 transition-opacity duration-300"></div>
                                        <svg class="relative w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    
                                    @if(!$contact->is_read)
                                        <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="relative p-2.5 rounded-xl bg-gradient-to-br from-emerald-50 to-green-50 dark:from-emerald-900/30 dark:to-green-900/20 shadow-md hover:shadow-xl hover:scale-110 transition-all duration-300 group/read"
                                                title="Tandai Dibaca">
                                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/20 to-green-500/10 rounded-xl opacity-0 group-hover/read:opacity-100 transition-opacity duration-300"></div>
                                                <svg class="relative w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
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
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Kotak Masuk Kosong</h3>
                                            <p class="text-slate-600 dark:text-slate-400 mb-6">Belum ada pesan yang masuk</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($contacts->hasPages())
            <div class="px-8 py-6 border-t border-slate-200/50 dark:border-slate-700/30 bg-gradient-to-r from-white/50 to-slate-50/30 dark:from-slate-900/50 dark:to-slate-800/30">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-600 dark:text-slate-400">
                        Menampilkan {{ $contacts->firstItem() }} - {{ $contacts->lastItem() }} dari {{ $contacts->total() }} pesan
                    </p>
                    <div class="flex items-center space-x-2">
                        {{ $contacts->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="md:hidden mt-6">
        @foreach($contacts as $contact)
            <div class="glass-card rounded-2xl p-6 border border-white/20 dark:border-slate-700/50 backdrop-blur-xl shadow-xl shadow-blue-500/5 mb-6 animate-slide-up relative {{ !$contact->is_read ? 'bg-gradient-to-r from-blue-50/60 to-cyan-50/40 dark:from-blue-900/20 dark:to-cyan-900/10' : '' }}">
                @if(!$contact->is_read)
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-blue-500 to-cyan-400 rounded-l-2xl"></div>
                @endif
                
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-400 flex items-center justify-center shadow-lg">
                                <span class="text-white font-bold">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </span>
                            </div>
                            @if(!$contact->is_read)
                                <div class="absolute -top-1 -right-1">
                                    <div class="relative">
                                        <div class="absolute inset-0 bg-blue-500 rounded-full animate-ping"></div>
                                        <div class="relative w-2 h-2 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-full"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-slate-900 dark:text-white">{{ $contact->name }}</h3>
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $contact->email }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        @if(!$contact->is_read)
                            <form action="{{ route('admin.contacts.mark-read', $contact) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route('admin.contacts.show', $contact) }}"
                            class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="space-y-3 mb-4">
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-white mb-1">{{ $contact->subject }}</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400 line-clamp-2">
                            {{ $contact->message }}
                        </p>
                    </div>
                    
                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-700/30">
                        <div class="text-sm text-slate-500 dark:text-slate-400">
                            {{ $contact->created_at->format('d M Y, H:i') }}
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $contact->is_read ? 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' : 'bg-gradient-to-r from-blue-100 to-cyan-100 text-blue-700 dark:from-blue-900/40 dark:to-cyan-900/40 dark:text-blue-300' }}">
                            {{ $contact->is_read ? 'Dibaca' : 'Baru' }}
                        </span>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if($contacts->hasPages())
            <div class="glass-card rounded-2xl border border-white/20 dark:border-slate-700/50 backdrop-blur-xl p-6 mt-6">
                {{ $contacts->links('vendor.pagination.simple-tailwind') }}
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
</style>
@endpush