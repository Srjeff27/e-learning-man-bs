@extends('layouts.teacher')

@section('title', 'Kelola Siswa')
@section('page-title', 'Kelola Siswa')

@push('styles')
    <style>
        .animate-enter {
            animation: enter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes enter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

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
            background: rgba(240, 253, 244, 0.5);
        }

        .dark .glass-header {
            background: rgba(6, 78, 59, 0.2);
        }

        /* Hide scrollbar for clean look */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Global Dropdown - positioned outside table */
        #globalDropdown {
            position: fixed;
            z-index: 99999;
            transform-origin: top right;
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        #globalDropdown.hidden {
            transform: scale(0.95);
            opacity: 0;
            pointer-events: none;
        }

        #globalDropdown:not(.hidden) {
            transform: scale(1);
            opacity: 1;
        }
    </style>
@endpush

@section('content')
    <div
        class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-500 py-8 px-4 sm:px-6 lg:px-8 relative overflow-hidden font-sans">

        {{-- Ambient Background --}}
        <div
            class="absolute top-0 left-1/4 w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-screen pointer-events-none animate-pulse">
        </div>
        <div
            class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-teal-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen pointer-events-none">
        </div>

        <div class="max-w-7xl mx-auto relative z-10 space-y-8">

            {{-- Header & Title --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 animate-enter">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Manajemen Siswa</h1>
                    <p class="text-slate-500 dark:text-slate-400 mt-1">Pantau dan kelola data siswa di seluruh kelas Anda.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Search Box --}}
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari siswa..."
                            class="w-48 md:w-64 px-4 py-2.5 pl-10 rounded-xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <span
                        class="px-4 py-2.5 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-sm font-bold border border-emerald-200 dark:border-emerald-800">
                        <span id="studentCount">{{ $students->count() }}</span> Siswa
                    </span>
                </div>
            </div>

            {{-- Filter Section --}}
            <div class="glass-panel rounded-2xl p-2 animate-enter" style="animation-delay: 0.1s;">
                <div class="flex items-center gap-3 overflow-x-auto no-scrollbar p-2">
                    <span class="text-sm font-semibold text-slate-500 dark:text-slate-400 whitespace-nowrap pl-2">Filter
                        Kelas:</span>

                    {{-- All Button --}}
                    <button onclick="filterByClassroom('all')" id="filter-all"
                        class="filter-btn px-5 py-2.5 rounded-xl text-sm font-bold bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow-lg shadow-emerald-500/30 transition-all hover:scale-105 whitespace-nowrap">
                        Semua
                    </button>

                    @foreach($classrooms as $classroom)
                        <button onclick="filterByClassroom('{{ $classroom->id }}')" id="filter-{{ $classroom->id }}"
                            class="filter-btn px-5 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 bg-white/50 dark:bg-slate-800/50 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 dark:hover:text-emerald-400 transition-all border border-transparent hover:border-emerald-200 dark:hover:border-emerald-800 whitespace-nowrap">
                            {{ $classroom->name }}
                            <span class="ml-1 text-xs opacity-70">({{ $classroom->students->count() }})</span>
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- Students Table --}}
            <div class="glass-panel rounded-[2rem] overflow-hidden animate-enter" style="animation-delay: 0.2s;">
                <div class="overflow-x-auto">
                    @if($students->count() > 0)
                        <table class="w-full">
                            <thead class="glass-header border-b border-emerald-100 dark:border-emerald-900/50">
                                <tr>
                                    <th
                                        class="px-6 py-5 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Siswa</th>
                                    <th
                                        class="px-6 py-5 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell">
                                        Kontak</th>
                                    <th
                                        class="px-6 py-5 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Kelas Terdaftar</th>
                                    <th
                                        class="px-6 py-5 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-5 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="studentsTableBody" class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($students as $index => $student)
                                    @php
                                        $studentClassrooms = $student->enrolledClassrooms->map(function ($c) {
                                            return ['id' => $c->id, 'name' => $c->name];
                                        })->toArray();
                                    @endphp
                                    <tr class="student-row group hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-colors duration-200"
                                        data-student-id="{{ $student->id }}" data-student-name="{{ $student->name }}"
                                        data-student-email="{{ $student->email }}"
                                        data-student-classrooms='@json($studentClassrooms)'
                                        data-name="{{ strtolower($student->name) }}" data-email="{{ strtolower($student->email) }}"
                                        data-classrooms="{{ $student->enrolledClassrooms->pluck('id')->join(',') }}">
                                        {{-- Kolom Nama & Avatar --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-11 w-11">
                                                    <div
                                                        class="h-11 w-11 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold shadow-md ring-2 ring-white dark:ring-slate-800 group-hover:scale-110 transition-transform duration-300">
                                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-bold text-slate-900 dark:text-white">
                                                        {{ $student->name }}</div>
                                                    <div class="text-xs text-slate-500 dark:text-slate-400 md:hidden">
                                                        {{ $student->email }}</div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- Kolom Email --}}
                                        <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                            <div class="text-sm text-slate-600 dark:text-slate-300 font-medium">
                                                {{ $student->email }}</div>
                                        </td>

                                        {{-- Kolom Kelas --}}
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($student->enrolledClassrooms as $classroom)
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-medium bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                                        {{ $classroom->name }}
                                                    </span>
                                                @endforeach
                                                @if($student->enrolledClassrooms->isEmpty())
                                                    <span class="text-xs text-slate-400 italic">Belum masuk kelas</span>
                                                @endif
                                            </div>
                                        </td>

                                        {{-- Kolom Status --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $student->is_active ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                                                <span
                                                    class="w-1.5 h-1.5 rounded-full mr-2 {{ $student->is_active ? 'bg-green-500' : 'bg-slate-500' }}"></span>
                                                {{ $student->is_active ? 'Aktif' : 'Nonaktif' }}
                                            </span>
                                        </td>

                                        {{-- Kolom Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <button onclick="openDropdown(event, this.closest('tr'))"
                                                class="action-btn text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors p-2 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-lg">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z">
                                                    </path>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- No Results Message --}}
                        <div id="noResults" class="hidden flex-col items-center justify-center py-16 px-4 text-center">
                            <div
                                class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <p class="text-slate-500 dark:text-slate-400 font-medium">Tidak ada siswa yang ditemukan.</p>
                            <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">Coba ubah kata kunci pencarian atau
                                filter.</p>
                        </div>
                    @else
                        {{-- Empty State --}}
                        <div class="flex flex-col items-center justify-center py-20 px-4 text-center">
                            <div
                                class="w-24 h-24 bg-gradient-to-tr from-emerald-50 to-teal-50 dark:from-slate-800 dark:to-slate-700 rounded-full flex items-center justify-center mb-6 shadow-inner ring-4 ring-white dark:ring-slate-800">
                                <svg class="w-10 h-10 text-emerald-300 dark:text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Belum Ada Siswa</h3>
                            <p class="text-slate-500 dark:text-slate-400 max-w-sm mx-auto">Siswa yang mendaftar di kelas Anda
                                akan muncul di sini secara otomatis.</p>
                        </div>
                    @endif
                </div>

                {{-- Footer / Pagination --}}
                @if($students->count() > 0)
                    <div
                        class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-white/30 dark:bg-slate-900/30 flex justify-between items-center text-xs text-slate-400">
                        <span>Menampilkan <span id="visibleCount">{{ $students->count() }}</span> dari {{ $students->count() }}
                            siswa</span>
                        <span class="text-slate-300 dark:text-slate-600">Data terbaru</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Global Dropdown Menu (positioned outside table to avoid overflow clipping) --}}
    <div id="globalDropdown"
        class="hidden w-52 rounded-xl bg-white dark:bg-slate-800 shadow-2xl border border-slate-200 dark:border-slate-700 overflow-hidden">
        <button onclick="openProfileModal()"
            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors text-left">
            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            Lihat Profil
        </button>
        <a href="#" id="dropdownGrades"
            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Lihat Nilai
        </a>
        <a href="#" id="dropdownAttendance"
            class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Riwayat Absensi
        </a>
        <hr class="border-slate-100 dark:border-slate-700">
        <button onclick="openRemoveModal()"
            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-left">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
            </svg>
            Keluarkan dari Kelas
        </button>
    </div>

    {{-- Profile Modal --}}
    <div id="profileModal"
        class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 backdrop-blur-xl transition-opacity opacity-0"
        style="background: rgba(15, 23, 42, 0.85);">
        <button onclick="closeProfileModal()"
            class="absolute top-6 right-6 w-14 h-14 rounded-full bg-white/10 hover:bg-red-500/80 text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 backdrop-blur-md border border-white/20 shadow-lg">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div id="profileModalContent"
            class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform scale-95 transition-all duration-300"
            style="box-shadow: 0 0 80px rgba(16, 185, 129, 0.2);">
            <div class="bg-gradient-to-br from-emerald-400 to-teal-600 p-8 text-center">
                <div id="profileAvatar"
                    class="w-20 h-20 mx-auto rounded-full bg-white/20 backdrop-blur flex items-center justify-center text-white text-3xl font-black shadow-lg ring-4 ring-white/30">
                </div>
                <h3 id="profileName" class="mt-4 text-2xl font-bold text-white"></h3>
                <p id="profileEmail" class="text-white/80 text-sm mt-1"></p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Kelas
                        Terdaftar</p>
                    <div id="profileClassrooms" class="flex flex-wrap gap-2"></div>
                </div>
                <div class="pt-4">
                    <button onclick="closeProfileModal()"
                        class="w-full px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold transition-colors">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Remove from Class Modal --}}
    <div id="removeModal"
        class="fixed inset-0 z-[99999] hidden items-center justify-center p-4 backdrop-blur-xl transition-opacity opacity-0"
        style="background: rgba(15, 23, 42, 0.85);">
        <button onclick="closeRemoveModal()"
            class="absolute top-6 right-6 w-14 h-14 rounded-full bg-white/10 hover:bg-red-500/80 text-white flex items-center justify-center transition-all duration-300 hover:scale-110 hover:rotate-90 backdrop-blur-md border border-white/20 shadow-lg">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div id="removeModalContent"
            class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl max-w-md w-full p-8 transform scale-95 transition-all duration-300"
            style="box-shadow: 0 0 80px rgba(239, 68, 68, 0.2);">
            <div class="text-center mb-6">
                <div
                    class="w-16 h-16 mx-auto rounded-full bg-red-100 dark:bg-red-900/20 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Keluarkan dari Kelas</h3>
                <p class="text-slate-500 dark:text-slate-400">Pilih kelas yang ingin dikeluarkan siswa <span
                        id="removeStudentName" class="font-bold text-slate-700 dark:text-slate-200"></span></p>
            </div>

            <div id="removeClassList" class="space-y-2 max-h-60 overflow-y-auto mb-6"></div>

            <div class="flex gap-3">
                <button onclick="closeRemoveModal()"
                    class="flex-1 px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentFilter = 'all';
        let activeStudentData = null;
        const globalDropdown = document.getElementById('globalDropdown');
        const profileModal = document.getElementById('profileModal');
        const profileModalContent = document.getElementById('profileModalContent');
        const removeModal = document.getElementById('removeModal');
        const removeModalContent = document.getElementById('removeModalContent');

        function openDropdown(event, row) {
            event.stopPropagation();
            const button = event.currentTarget;
            const rect = button.getBoundingClientRect();

            // Store student data
            activeStudentData = {
                id: row.dataset.studentId,
                name: row.dataset.studentName,
                email: row.dataset.studentEmail,
                classrooms: JSON.parse(row.dataset.studentClassrooms || '[]')
            };

            // Update dropdown links
            if (activeStudentData.classrooms.length > 0) {
                const firstClassroom = activeStudentData.classrooms[0];
                document.getElementById('dropdownGrades').href = `/teacher/reports/classroom/${firstClassroom.id}`;
                document.getElementById('dropdownAttendance').href = `/teacher/classrooms/${firstClassroom.id}/attendance`;
            } else {
                document.getElementById('dropdownGrades').href = '{{ route("teacher.reports.index") }}';
                document.getElementById('dropdownAttendance').href = '{{ route("teacher.attendance.classrooms") }}';
            }

            // Position the dropdown
            globalDropdown.style.top = (rect.bottom + 8) + 'px';
            globalDropdown.style.left = (rect.right - 208) + 'px'; // 208 = dropdown width (w-52)

            // Make sure dropdown doesn't go off-screen on the left
            if (rect.right - 208 < 8) {
                globalDropdown.style.left = '8px';
            }

            // Make sure dropdown doesn't go off-screen at the bottom
            const dropdownHeight = 200;
            if (rect.bottom + dropdownHeight > window.innerHeight) {
                globalDropdown.style.top = (rect.top - dropdownHeight - 8) + 'px';
            }

            // Show dropdown
            globalDropdown.classList.remove('hidden');
        }

        function closeDropdown() {
            globalDropdown.classList.add('hidden');
        }

        // Profile Modal
        function openProfileModal() {
            closeDropdown();
            if (!activeStudentData) return;

            document.getElementById('profileAvatar').textContent = activeStudentData.name.charAt(0).toUpperCase();
            document.getElementById('profileName').textContent = activeStudentData.name;
            document.getElementById('profileEmail').textContent = activeStudentData.email;

            const classroomsContainer = document.getElementById('profileClassrooms');
            classroomsContainer.innerHTML = '';

            if (activeStudentData.classrooms.length > 0) {
                activeStudentData.classrooms.forEach(c => {
                    classroomsContainer.innerHTML += `<span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-emerald-100 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">${c.name}</span>`;
                });
            } else {
                classroomsContainer.innerHTML = '<span class="text-sm text-slate-400 italic">Belum terdaftar di kelas manapun</span>';
            }

            profileModal.classList.remove('hidden');
            profileModal.classList.add('flex');
            requestAnimationFrame(() => {
                profileModal.classList.remove('opacity-0');
                profileModalContent.classList.remove('scale-95');
                profileModalContent.classList.add('scale-100');
            });
        }

        function closeProfileModal() {
            profileModal.classList.add('opacity-0');
            profileModalContent.classList.remove('scale-100');
            profileModalContent.classList.add('scale-95');
            setTimeout(() => {
                profileModal.classList.add('hidden');
                profileModal.classList.remove('flex');
            }, 300);
        }

        // Remove Modal
        function openRemoveModal() {
            closeDropdown();
            if (!activeStudentData) return;

            document.getElementById('removeStudentName').textContent = activeStudentData.name;

            const classList = document.getElementById('removeClassList');
            classList.innerHTML = '';

            if (activeStudentData.classrooms.length > 0) {
                activeStudentData.classrooms.forEach(c => {
                    classList.innerHTML += `
                        <form action="/teacher/classrooms/${c.id}/members/${activeStudentData.id}" method="POST" class="block" onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan siswa dari kelas ${c.name}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-between p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-red-300 dark:hover:border-red-700 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors group">
                                <span class="font-medium text-slate-700 dark:text-slate-200">${c.name}</span>
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    `;
                });
            } else {
                classList.innerHTML = '<p class="text-center text-slate-400 py-4">Siswa belum terdaftar di kelas manapun</p>';
            }

            removeModal.classList.remove('hidden');
            removeModal.classList.add('flex');
            requestAnimationFrame(() => {
                removeModal.classList.remove('opacity-0');
                removeModalContent.classList.remove('scale-95');
                removeModalContent.classList.add('scale-100');
            });
        }

        function closeRemoveModal() {
            removeModal.classList.add('opacity-0');
            removeModalContent.classList.remove('scale-100');
            removeModalContent.classList.add('scale-95');
            setTimeout(() => {
                removeModal.classList.add('hidden');
                removeModal.classList.remove('flex');
            }, 300);
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('#globalDropdown') && !e.target.closest('.action-btn')) {
                closeDropdown();
            }
        });

        // Close on scroll to prevent misalignment
        document.addEventListener('scroll', closeDropdown, true);

        function filterByClassroom(classroomId) {
            currentFilter = classroomId;
            const rows = document.querySelectorAll('.student-row');
            const filterBtns = document.querySelectorAll('.filter-btn');

            // Update button styles
            filterBtns.forEach(btn => {
                btn.classList.remove('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600', 'text-white', 'shadow-lg', 'shadow-emerald-500/30');
                btn.classList.add('bg-white/50', 'dark:bg-slate-800/50', 'text-slate-600', 'dark:text-slate-300');
            });

            const activeBtn = document.getElementById(`filter-${classroomId}`);
            if (activeBtn) {
                activeBtn.classList.remove('bg-white/50', 'dark:bg-slate-800/50', 'text-slate-600', 'dark:text-slate-300');
                activeBtn.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600', 'text-white', 'shadow-lg', 'shadow-emerald-500/30');
            }

            // Filter rows
            applyFilters();
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.student-row');
            let visibleCount = 0;

            rows.forEach(row => {
                const name = row.dataset.name;
                const email = row.dataset.email;
                const classrooms = row.dataset.classrooms.split(',');

                const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                const matchesFilter = currentFilter === 'all' || classrooms.includes(currentFilter);

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update visible count
            const visibleCountEl = document.getElementById('visibleCount');
            const studentCountEl = document.getElementById('studentCount');
            if (visibleCountEl) visibleCountEl.textContent = visibleCount;
            if (studentCountEl) studentCountEl.textContent = visibleCount;

            // Show/hide no results message
            const noResults = document.getElementById('noResults');
            const table = document.querySelector('table');
            if (visibleCount === 0 && rows.length > 0) {
                noResults.classList.remove('hidden');
                noResults.classList.add('flex');
                if (table) table.style.display = 'none';
            } else {
                noResults.classList.add('hidden');
                noResults.classList.remove('flex');
                if (table) table.style.display = '';
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', applyFilters);

        // Escape key to close modals
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDropdown();
                closeProfileModal();
                closeRemoveModal();
            }
        });

        // Close modals on backdrop click
        profileModal.addEventListener('click', (e) => { if (e.target === profileModal) closeProfileModal(); });
        removeModal.addEventListener('click', (e) => { if (e.target === removeModal) closeRemoveModal(); });
    </script>
@endsection