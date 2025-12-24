@extends('layouts.teacher')

@section('title', 'Anggota Kelas')

@push('styles')
<style>
    .animate-enter { animation: enter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes enter { to { opacity: 1; transform: translateY(0); } }
    
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.1);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
    }
    
    .glass-header {
        background: rgba(255, 255, 255, 0.5);
        border-bottom: 1px solid rgba(16, 185, 129, 0.1);
    }
    .dark .glass-header {
        background: rgba(15, 23, 42, 0.4);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .table-row-hover:hover {
        background-color: rgba(255, 255, 255, 0.6);
    }
    .dark .table-row-hover:hover {
        background-color: rgba(30, 41, 59, 0.6);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-500 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden font-sans">
    
    {{-- Ambient Background --}}
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-teal-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen pointer-events-none"></div>

    <div class="max-w-5xl mx-auto relative z-10">
        
        {{-- Navigation --}}
        <div class="mb-8 animate-enter flex justify-between items-center">
            <a href="{{ route('teacher.classrooms.show', $classroom) }}" class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                <div class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-400 dark:group-hover:border-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke {{ $classroom->name }}
            </a>
        </div>

        <div class="glass-panel rounded-[2rem] overflow-hidden animate-enter" style="animation-delay: 0.1s;">
            
            {{-- Card Header --}}
            <div class="p-6 md:p-8 border-b border-slate-200/60 dark:border-slate-700/60 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                        Anggota Kelas
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-xs font-bold border border-emerald-200 dark:border-emerald-800">
                            {{ $members->count() }} Siswa
                        </span>
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Daftar siswa yang tergabung dalam {{ $classroom->name }}</p>
                </div>

                {{-- Class Code Badge --}}
                <div class="relative group overflow-hidden rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50/50 dark:bg-emerald-900/10 px-5 py-3 transition-all hover:bg-emerald-100/50 dark:hover:bg-emerald-900/20">
                    <div class="flex items-center gap-4">
                        <div>
                            <p class="text-[10px] font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">Kode Kelas</p>
                            <p class="text-xl font-mono font-black text-slate-800 dark:text-white tracking-widest">{{ $classroom->code }}</p>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ $classroom->code }}')" class="p-2 bg-white dark:bg-slate-800 rounded-lg text-emerald-500 hover:text-emerald-700 transition-colors shadow-sm" title="Salin Kode">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Table Content --}}
            <div class="overflow-x-auto">
                @if($members->count() > 0)
                    <table class="w-full">
                        <thead class="glass-header">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Siswa</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">Kontak</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden sm:table-cell">Tanggal Bergabung</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach($members as $index => $member)
                                <tr class="table-row-hover transition-colors duration-200 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white text-sm font-bold shadow-md ring-2 ring-white dark:ring-slate-800">
                                                    {{ substr($member->name, 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $member->name }}</div>
                                                <div class="text-xs text-slate-500 dark:text-slate-400 md:hidden">{{ $member->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                        <div class="text-sm text-slate-600 dark:text-slate-300 font-medium">{{ $member->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                            {{ $member->pivot->joined_at ? \Carbon\Carbon::parse($member->pivot->joined_at)->format('d M Y') : $member->pivot->created_at->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <form action="{{ route('teacher.classrooms.remove-member', [$classroom, $member]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan {{ $member->name }} dari kelas ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 transition-all" title="Keluarkan Siswa">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    {{-- Empty State --}}
                    <div class="text-center py-20 px-6">
                        <div class="w-24 h-24 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-6 border border-slate-100 dark:border-slate-700 shadow-inner">
                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum Ada Anggota</h3>
                        <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-sm mx-auto">Kelas ini masih sepi. Bagikan kode kelas kepada siswa agar mereka dapat bergabung.</p>
                        
                        <div class="inline-flex items-center gap-3 px-6 py-4 rounded-2xl border border-dashed border-emerald-300 dark:border-emerald-700 bg-emerald-50/50 dark:bg-emerald-900/10">
                            <span class="text-sm font-medium text-slate-500 dark:text-slate-400">Kode Kelas:</span>
                            <span class="text-2xl font-mono font-black text-emerald-600 dark:text-emerald-400 tracking-wider">{{ $classroom->code }}</span>
                        </div>
                    </div>
                @endif
            </div>
            
            {{-- Footer Pagination if needed --}}
            @if(isset($members) && method_exists($members, 'links') && $members->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-white/30 dark:bg-slate-900/30">
                    {{ $members->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection