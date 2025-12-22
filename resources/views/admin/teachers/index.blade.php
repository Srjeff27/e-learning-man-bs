@extends('layouts.admin')

@section('title', 'Kelola Guru & Staff')
@section('page-title', 'Kelola Guru & Staff')
@section('page-subtitle', 'Kelola data guru dan staff pendukung sekolah')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6 bg-gradient-to-r from-blue-600 to-cyan-600">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Daftar Guru & Staff</h2>
                    <p class="text-blue-100">Kelola semua guru dan staff pendukung sekolah</p>
                </div>
                <a href="{{ route('admin.teachers.create') }}"
                    class="inline-flex items-center px-5 py-3 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition-all shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Guru/Staff
                </a>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="glass-card rounded-xl p-4">
            <form method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, NIP, atau bidang..."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <select name="subject"
                        class="w-full md:w-48 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Bidang</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ request('subject') == $subject ? 'selected' : '' }}>{{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
                @if(request('search') || request('subject'))
                    <a href="{{ route('admin.teachers.index') }}"
                        class="px-6 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-semibold rounded-xl hover:bg-slate-300 dark:hover:bg-slate-600 transition-all">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="glass-card rounded-xl p-4 text-center">
                <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $teachers->total() }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">Total Guru/Staff</div>
            </div>
            <div class="glass-card rounded-xl p-4 text-center">
                <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">
                    {{ $teachers->where('is_active', true)->count() }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">Aktif</div>
            </div>
            <div class="glass-card rounded-xl p-4 text-center">
                <div class="text-3xl font-bold text-amber-600 dark:text-amber-400">{{ $subjects->count() }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">Bidang</div>
            </div>
            <div class="glass-card rounded-xl p-4 text-center">
                <div class="text-3xl font-bold text-violet-600 dark:text-violet-400">
                    {{ $teachers->whereNotNull('photo')->count() }}</div>
                <div class="text-sm text-slate-500 dark:text-slate-400">Dengan Foto</div>
            </div>
        </div>

        <!-- Teachers Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($teachers as $teacher)
                <div class="glass-card rounded-2xl overflow-hidden group hover:shadow-xl transition-all duration-300">
                    <!-- Photo -->
                    <div class="relative h-48 bg-gradient-to-br from-blue-500 to-cyan-500">
                        @if($teacher->photo)
                            <img src="{{ Storage::url($teacher->photo) }}" class="w-full h-full object-cover"
                                alt="{{ $teacher->full_name }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            @if($teacher->is_active)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-emerald-500 text-white">Aktif</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-slate-500 text-white">Nonaktif</span>
                            @endif
                        </div>

                        <!-- Subject Badge -->
                        @if($teacher->subject_specialty)
                            <div class="absolute bottom-3 left-3">
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-white/90 text-blue-600">{{ $teacher->subject_specialty }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 dark:text-white mb-1 truncate">{{ $teacher->full_name }}</h3>
                        @if($teacher->nip)
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">NIP: {{ $teacher->nip }}</p>
                        @else
                            <p class="text-sm text-slate-500 dark:text-slate-400 mb-3">-</p>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('admin.teachers.edit', $teacher) }}"
                                class="flex-1 px-3 py-2 text-center text-sm font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('admin.teachers.toggle-active', $teacher) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="w-full px-3 py-2 text-center text-sm font-medium {{ $teacher->is_active ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' : 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' }} rounded-lg hover:opacity-80 transition-colors">
                                    {{ $teacher->is_active ? 'Nonaktif' : 'Aktif' }}
                                </button>
                            </form>
                            <form action="{{ route('admin.teachers.destroy', $teacher) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus guru/staff ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-2 text-sm font-medium bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-slate-700 dark:text-slate-300 mb-2">Belum ada data guru/staff</h3>
                    <p class="text-slate-500 dark:text-slate-400 mb-4">Mulai dengan menambahkan guru atau staff baru</p>
                    <a href="{{ route('admin.teachers.create') }}"
                        class="inline-flex items-center px-5 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Guru/Staff
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($teachers->hasPages())
            <div class="glass-card rounded-xl p-4">
                {{ $teachers->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection