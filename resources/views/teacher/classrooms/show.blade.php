@extends('layouts.teacher')

@section('title', $classroom->name)

@push('styles')
<style>
    /* Animasi Masuk */
    .animate-enter { animation: enter 0.6s ease-out forwards; opacity: 0; transform: translateY(20px); }
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }
    @keyframes enter { to { opacity: 1; transform: translateY(0); } }

    /* Efek Glassmorphism Keren */
    .glass-card {
        background: rgba(255, 255, 255, 0.65); /* Sedikit lebih transparan untuk kesan glossy */
        backdrop-filter: blur(16px) saturate(180%); /* Blur lebih kuat dan saturasi tinggi */
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1); /* Shadow halus berwarna */
    }
    .dark .glass-card {
        background: rgba(20, 30, 25, 0.65); /* Latar belakang gelap kehijauan */
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
    }
    
    /* Tambahan efek glossy pada hover */
    .glass-card:hover {
        border-color: rgba(16, 185, 129, 0.3); /* Emerald border on hover */
        box-shadow: 0 10px 40px 0 rgba(16, 185, 129, 0.15); /* Greenish shadow */
    }
</style>
@endpush

@section('content')
{{-- Main Container: Mengubah selection color menjadi emerald --}}
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-500 pb-12 font-sans selection:bg-emerald-500 selection:text-white">
    
    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <a href="{{ route('teacher.classrooms.index') }}" class="animate-enter inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200 group">
            {{-- Ubah border hover jadi emerald --}}
            <div class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-300 dark:group-hover:border-emerald-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </div>
            Kembali ke Daftar Kelas
        </a>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        
        {{-- Hero Section: Gradasi Hijau Glossy --}}
        <div class="animate-enter relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-emerald-600 via-green-600 to-teal-700 shadow-2xl shadow-emerald-900/20 dark:shadow-emerald-900/10 mb-8 ring-1 ring-white/10">
            {{-- Decorative Blobs diubah warnanya --}}
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-white/10 rounded-full blur-[80px] -mr-32 -mt-32 mix-blend-overlay"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-lime-400/20 rounded-full blur-[60px] -ml-20 -mb-20 mix-blend-overlay"></div>

            <div class="relative z-10 p-8 md:p-12">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-bold text-white border border-white/20 shadow-sm">
                                {{ $classroom->academic_year ?? '2025/2026' }}
                            </span>
                            {{-- Status badges sudah menggunakan warna amber/emerald, jadi aman --}}
                            <span class="px-3 py-1 rounded-full {{ $classroom->status === 'active' ? 'bg-emerald-500/20 text-emerald-50 border-emerald-400/30' : 'bg-amber-500/20 text-amber-50 border-amber-400/30' }} backdrop-blur-md text-xs font-bold border shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full {{ $classroom->status === 'active' ? 'bg-emerald-400' : 'bg-amber-400' }} inline-block mr-1.5 animate-pulse"></span>
                                {{ $classroom->status === 'active' ? 'Active Class' : 'Archived' }}
                            </span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-white mb-3 drop-shadow-sm">{{ $classroom->name }}</h1>
                        {{-- Teks deskripsi diubah jadi emerald-100 --}}
                        <p class="text-emerald-100 text-lg font-medium tracking-wide">{{ $classroom->subject }} • Grade {{ $classroom->grade }}</p>
                    </div>

                    <div class="flex items-center gap-4">
                        {{-- Clickable Code Card --}}
                        <button onclick="openQRModal();" class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 text-center min-w-[120px] shadow-lg group hover:bg-white/20 hover:scale-105 transition-all cursor-pointer relative">
                            <span class="block text-[10px] text-emerald-100 uppercase tracking-widest font-bold mb-1">Kode Kelas</span>
                            <span class="block text-3xl font-mono font-black text-white tracking-widest group-hover:scale-105 transition-transform">{{ $classroom->code }}</span>
                            <span class="absolute -bottom-1 -right-1 w-6 h-6 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white text-xs border border-white/30 shadow-lg">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h2M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            </span>
                        </button>
                        
                        {{-- Edit Button --}}
                        <a href="{{ route('teacher.classrooms.edit', $classroom) }}" class="p-4 rounded-2xl bg-white/90 dark:bg-slate-900/90 text-emerald-600 dark:text-emerald-400 hover:scale-105 transition-all shadow-xl hover:shadow-2xl hover:bg-white backdrop-blur-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Grid: Palet Warna Hijau/Teal --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 animate-enter delay-100">
            @foreach([
                ['label' => 'Total Siswa', 'value' => $classroom->students->count(), 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z', 'color' => 'emerald'],
                ['label' => 'Materi', 'value' => $classroom->materials->count(), 'icon' => 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', 'color' => 'teal'],
                ['label' => 'Tugas', 'value' => $assignments->count(), 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', 'color' => 'green'],
                ['label' => 'Pengumuman', 'value' => $classroom->announcements->count(), 'icon' => 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z', 'color' => 'cyan'],
            ] as $stat)
            {{-- Menggunakan class glass-card yang baru --}}
            <div class="glass-card rounded-2xl p-5 hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">{{ $stat['label'] }}</p>
                        <p class="text-3xl font-black text-slate-800 dark:text-white mt-1">{{ $stat['value'] }}</p>
                    </div>
                    {{-- Update warna icon background dan text --}}
                    <div class="p-3 bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/30 rounded-xl text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/></svg>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="grid lg:grid-cols-12 gap-8 animate-enter delay-200">
            
            {{-- Main Column --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Actions Toolbar: Tombol Utama jadi Emerald --}}
                <div class="flex flex-wrap gap-3 p-1">
                    <a href="{{ route('teacher.materials.create', $classroom) }}" class="flex-1 sm:flex-none justify-center inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 text-white rounded-xl font-bold transition-all shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Upload Materi
                    </a>
                    {{-- Tombol sekunder menggunakan glass-card dan icon warna teal/green --}}
                    <a href="{{ route('teacher.assignments.create', $classroom) }}" class="flex-1 sm:flex-none justify-center inline-flex items-center px-6 py-3 glass-card hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-xl font-bold transition-all">
                        <svg class="w-5 h-5 mr-2 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Buat Tugas
                    </a>
                    <a href="{{ route('teacher.classrooms.members', $classroom) }}" class="flex-1 sm:flex-none justify-center inline-flex items-center px-6 py-3 glass-card hover:bg-white dark:hover:bg-slate-800 text-slate-700 dark:text-slate-200 rounded-xl font-bold transition-all">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Kelola Siswa
                    </a>
                </div>

                {{-- Assignments List (Tugas) --}}
                <div class="glass-card rounded-3xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 backdrop-blur-md flex justify-between items-center">
                        <h2 class="font-bold text-xl text-slate-800 dark:text-white flex items-center gap-3">
                            {{-- Indikator Pulse jadi Emerald --}}
                            <span class="flex h-3 w-3 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            Tugas Terbaru
                        </h2>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800 bg-white/40 dark:bg-slate-900/40">
                        @forelse($assignments as $assignment)
                        <a href="{{ route('teacher.assignments.show', [$classroom, $assignment]) }}" class="block p-6 hover:bg-white/80 dark:hover:bg-slate-800/80 transition-all duration-300 group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-5">
                                    {{-- Icon Box jadi Emerald --}}
                                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 shadow-sm border border-emerald-100 dark:border-emerald-900/30">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <div>
                                        {{-- Hover text jadi emerald --}}
                                        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $assignment->title }}</h3>
                                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1 flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span class="{{ $assignment->due_date && $assignment->due_date->isPast() ? 'text-red-500 dark:text-red-400' : '' }}">
                                                {{ $assignment->due_date ? $assignment->due_date->format('d M Y, H:i') : 'No Deadline' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    {{-- Badge jadi emerald --}}
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 shadow-sm">
                                        {{ $assignment->submissions()->submitted()->count() }} / {{ $classroom->students->count() }}
                                    </span>
                                    <div class="text-xs text-slate-400 mt-1.5 font-medium">Submitted</div>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="p-12 text-center">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 mb-4 font-medium">Belum ada tugas yang dibuat.</p>
                            <a href="{{ route('teacher.assignments.create', $classroom) }}" class="text-emerald-600 dark:text-emerald-400 font-bold hover:underline">Buat tugas pertama</a>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Materials List (Materi) --}}
                <div class="glass-card rounded-3xl overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 backdrop-blur-md flex justify-between items-center">
                        <h2 class="font-bold text-xl text-slate-800 dark:text-white flex items-center gap-3">
                            {{-- Indikator bar jadi Teal --}}
                            <span class="w-1.5 h-6 bg-teal-500 rounded-full"></span>
                            Materi Pembelajaran
                        </h2>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800 bg-white/40 dark:bg-slate-900/40">
                        @forelse($classroom->materials as $material)
                        <div class="p-6 hover:bg-white/80 dark:hover:bg-slate-800/80 transition-all duration-300 group flex items-center justify-between">
                            <div class="flex items-center gap-5">
                                {{-- Icon Box jadi Teal --}}
                                <div class="w-14 h-14 rounded-2xl bg-teal-50 dark:bg-teal-900/20 text-teal-600 dark:text-teal-400 flex items-center justify-center flex-shrink-0 group-hover:scale-110 group-hover:-rotate-3 transition-transform duration-300 shadow-sm border border-teal-100 dark:border-teal-900/30">
                                    @if($material->type === 'video')
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    @else
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    {{-- Hover text jadi Teal --}}
                                    <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">{{ $material->title }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Diposting {{ $material->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            {{-- Edit button hover jadi Teal --}}
                            <a href="{{ route('teacher.materials.edit', [$classroom, $material]) }}" class="p-2.5 text-slate-400 dark:text-slate-500 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-teal-50 dark:hover:bg-teal-900/30 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                        </div>
                        @empty
                        <div class="p-12 text-center">
                            <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 dark:border-slate-700">
                                <svg class="w-10 h-10 text-slate-300 dark:text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 mb-4 font-medium">Belum ada materi pembelajaran.</p>
                            <a href="{{ route('teacher.materials.create', $classroom) }}" class="text-teal-600 dark:text-teal-400 font-bold hover:underline">Upload materi pertama</a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            
            {{-- Right Sidebar --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Students Card --}}
                <div class="glass-card rounded-3xl p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-bold text-slate-800 dark:text-white">Siswa Terdaftar</h3>
                        {{-- Badge count jadi emerald --}}
                        <span class="px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-xs font-bold ring-1 ring-emerald-100 dark:ring-emerald-800 shadow-sm">{{ $classroom->students->count() }}</span>
                    </div>
                    <div class="space-y-4">
                        @forelse($classroom->students->take(5) as $student)
                        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-slate-200 to-slate-100 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center text-slate-600 dark:text-slate-300 font-bold text-sm ring-2 ring-white dark:ring-slate-700 shadow-sm">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ $student->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">Siswa Aktif</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-sm text-slate-500 dark:text-slate-400 text-center py-4 italic">Belum ada siswa.</p>
                        @endforelse
                    </div>
                    @if($classroom->students->count() > 5)
                    {{-- Link view all jadi emerald --}}
                    <a href="{{ route('teacher.classrooms.members', $classroom) }}" class="block mt-6 text-center text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 py-3 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 transition-colors">
                        Lihat Semua Siswa
                    </a>
                    @endif
                </div>

                {{-- Danger Zone (Tetap Merah/Amber untuk semantik) --}}
                <div class="relative overflow-hidden glass-card rounded-3xl p-6 border-red-100 dark:border-red-900/30">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-500/5 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
                    <h3 class="font-bold text-red-600 dark:text-red-400 mb-5 relative z-10 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Pengaturan Kelas
                    </h3>
                    
                    <div class="space-y-3 relative z-10">
                        <form action="{{ route('teacher.classrooms.archive', $classroom) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full group flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-amber-200 dark:border-amber-800/50 bg-amber-50 dark:bg-amber-900/10 text-amber-700 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/20 transition-all text-sm font-bold">
                                @if($classroom->status === 'archived')
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Aktifkan Kembali
                                @else
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                                    Arsipkan Kelas
                                @endif
                            </button>
                        </form>

                        <button onclick="openDeleteModal();" type="button" class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl border border-red-200 dark:border-red-800/50 bg-red-50 dark:bg-red-900/10 text-red-700 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/20 transition-all text-sm font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Hapus Permanen
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Fullscreen QR Code Modal - Placed at root level --}}
<div id="qrModal" class="hidden fixed inset-0 z-[99999] flex flex-col items-center justify-center backdrop-blur-xl" 
    style="background: rgba(15, 23, 42, 0.85);">
    
    {{-- Close Button with Animation --}}
    <button id="closeQrModal" class="absolute top-6 right-6 w-14 h-14 rounded-full bg-white/10 hover:bg-red-500/80 text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 backdrop-blur-md border border-white/20 shadow-lg hover:shadow-red-500/30 group">
        <svg class="w-7 h-7 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    
    {{-- Content Container with Animation --}}
    <div id="qrModalContent" class="relative z-10 text-center px-6 transform transition-all duration-500">
        {{-- QR Code Container --}}
        <div class="bg-white p-8 rounded-3xl shadow-2xl mb-8 inline-block transform hover:scale-105 transition-transform duration-300" style="box-shadow: 0 0 100px rgba(16, 185, 129, 0.4), 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <div id="qrcode-container" class="flex justify-center items-center" style="min-width: 280px; min-height: 280px;">
                {{-- QR Code will be generated here --}}
                <div class="animate-pulse">
                    <svg class="w-16 h-16 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h2M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
            </div>
        </div>
        
        {{-- Class Name --}}
        <h2 class="text-3xl md:text-4xl font-black text-white mb-3 tracking-tight drop-shadow-lg">{{ $classroom->name }}</h2>
        
        {{-- Subject --}}
        <p class="text-emerald-400 text-lg mb-8 font-medium">{{ $classroom->subject }}</p>
        
        {{-- Class Code Display --}}
        <div class="inline-flex items-center gap-4 bg-white/10 backdrop-blur-md rounded-2xl px-8 py-4 border border-white/20 shadow-xl">
            <div class="text-center">
                <p class="text-xs text-white/60 uppercase tracking-widest font-bold mb-1">Kode Kelas</p>
                <p class="text-4xl md:text-5xl font-mono font-black text-white tracking-[0.3em]">{{ $classroom->code }}</p>
            </div>
            <button onclick="navigator.clipboard.writeText('{{ $classroom->code }}'); this.querySelector('svg').classList.add('text-emerald-400'); this.querySelector('.copy-text').textContent = 'Tersalin!'; setTimeout(() => { this.querySelector('svg').classList.remove('text-emerald-400'); this.querySelector('.copy-text').textContent = 'Salin'; }, 2000)" 
                class="p-3 rounded-xl bg-white/10 hover:bg-emerald-500/30 text-white transition-all duration-300 hover:scale-110 border border-white/20 flex flex-col items-center gap-1">
                <svg class="w-6 h-6 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <span class="copy-text text-[10px] uppercase tracking-wider font-bold">Salin</span>
            </button>
        </div>
        
        {{-- Instruction --}}
        <p class="text-white/50 text-sm mt-8 max-w-md mx-auto">Scan QR code atau masukkan kode di atas untuk bergabung ke kelas ini</p>
    </div>
</div>

{{-- Fullscreen Delete Modal - Placed at root level --}}
<div id="deleteModal" class="hidden fixed inset-0 z-[99999] flex flex-col items-center justify-center backdrop-blur-xl" 
    style="background: rgba(15, 23, 42, 0.85);">
    
    {{-- Close Button with Animation --}}
    <button id="closeDeleteModal" class="absolute top-6 right-6 w-14 h-14 rounded-full bg-white/10 hover:bg-red-500/80 text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 backdrop-blur-md border border-white/20 shadow-lg hover:shadow-red-500/30 group">
        <svg class="w-7 h-7 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    
    {{-- Content Container with Animation --}}
    <div id="deleteModalContent" class="relative z-10 text-center px-6 transform transition-all duration-500">
        {{-- Delete Icon --}}
        <div class="w-28 h-28 bg-gradient-to-br from-red-500 to-rose-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-2xl" style="box-shadow: 0 0 80px rgba(239, 68, 68, 0.5);">
            <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
        
        {{-- Title --}}
        <h2 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight drop-shadow-lg">Hapus Kelas?</h2>
        
        {{-- Description --}}
        <p class="text-white/70 text-lg mb-10 max-w-md mx-auto leading-relaxed">Tindakan ini tidak dapat dibatalkan. Semua materi, tugas, dan data siswa akan dihapus permanen.</p>
        
        {{-- Action Buttons --}}
        <div class="flex items-center justify-center gap-4">
            <button onclick="closeDeleteModal();" type="button" class="px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold transition-all duration-300 hover:scale-105 border border-white/20 backdrop-blur-md min-w-[140px]">
                Batal
            </button>
            <form action="{{ route('teacher.classrooms.destroy', $classroom) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white font-bold transition-all duration-300 shadow-xl hover:shadow-red-500/50 hover:scale-105 min-w-[180px]">
                    Hapus Permanen
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
<script>
// Generate QR Code when modal opens
let qrGenerated = false;

function generateQRCode() {
    if (qrGenerated) return;
    
    const container = document.getElementById('qrcode-container');
    if (container) {
        // Create QR Code with higher quality
        const qr = qrcode(0, 'H'); // 'H' for High error correction
        qr.addData('{{ $classroom->code }}');
        qr.make();
        
        // Create larger image (cell size 10)
        container.innerHTML = qr.createImgTag(10, 0);
        
        // Style the generated image for fullscreen display
        const qrImg = container.querySelector('img');
        if (qrImg) {
            qrImg.style.borderRadius = '16px';
            qrImg.style.width = '280px';
            qrImg.style.height = '280px';
            qrImg.style.imageRendering = 'pixelated';
        }
        
        qrGenerated = true;
    }
}

// Open modal with animation
function openQRModal() {
    const modal = document.getElementById('qrModal');
    const content = document.getElementById('qrModalContent');
    
    modal.classList.remove('hidden');
    modal.style.opacity = '0';
    content.style.transform = 'scale(0.8) translateY(20px)';
    content.style.opacity = '0';
    
    // Animate in
    requestAnimationFrame(() => {
        modal.style.transition = 'opacity 0.3s ease-out';
        modal.style.opacity = '1';
        content.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
        content.style.transform = 'scale(1) translateY(0)';
        content.style.opacity = '1';
    });
    
    generateQRCode();
}

// Close modal with animation
function closeQRModal() {
    const modal = document.getElementById('qrModal');
    const content = document.getElementById('qrModalContent');
    
    content.style.transition = 'all 0.2s ease-in';
    content.style.transform = 'scale(0.9) translateY(10px)';
    content.style.opacity = '0';
    
    modal.style.transition = 'opacity 0.25s ease-in';
    modal.style.opacity = '0';
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 250);
}

// Open delete modal with animation
function openDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('deleteModalContent');
    
    modal.classList.remove('hidden');
    modal.style.opacity = '0';
    content.style.transform = 'scale(0.8) translateY(20px)';
    content.style.opacity = '0';
    
    // Animate in
    requestAnimationFrame(() => {
        modal.style.transition = 'opacity 0.3s ease-out';
        modal.style.opacity = '1';
        content.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
        content.style.transform = 'scale(1) translateY(0)';
        content.style.opacity = '1';
    });
}

// Close delete modal with animation
function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const content = document.getElementById('deleteModalContent');
    
    content.style.transition = 'all 0.2s ease-in';
    content.style.transform = 'scale(0.9) translateY(10px)';
    content.style.opacity = '0';
    
    modal.style.transition = 'opacity 0.25s ease-in';
    modal.style.opacity = '0';
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 250);
}

// Initialize event listeners when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // QR Modal - Close button click handler
    const closeQrBtn = document.getElementById('closeQrModal');
    if (closeQrBtn) {
        closeQrBtn.addEventListener('click', closeQRModal);
    }
    
    // QR Modal - Click on backdrop to close
    const qrModal = document.getElementById('qrModal');
    if (qrModal) {
        qrModal.addEventListener('click', function(e) {
            if (e.target === qrModal) {
                closeQRModal();
            }
        });
    }
    
    // Delete Modal - Close button click handler
    const closeDeleteBtn = document.getElementById('closeDeleteModal');
    if (closeDeleteBtn) {
        closeDeleteBtn.addEventListener('click', closeDeleteModal);
    }
    
    // Delete Modal - Click on backdrop to close
    const deleteModal = document.getElementById('deleteModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });
    }
});

// Close modals with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const qrModal = document.getElementById('qrModal');
        if (qrModal && !qrModal.classList.contains('hidden')) {
            closeQRModal();
        }
        
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal && !deleteModal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});
</script>
@endpush