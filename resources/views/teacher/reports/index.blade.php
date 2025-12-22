@extends('layouts.teacher')

@section('title', 'Laporan Penilaian')
@section('page-title', 'Laporan Penilaian')

@section('content')
    <div class="space-y-6">
        {{-- Info Card --}}
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl p-6 text-white">
            <h2 class="text-xl font-bold mb-2">Laporan Penilaian</h2>
            <p class="text-purple-100">Lihat rekap nilai dan progress siswa di setiap kelas Anda.</p>
        </div>

        {{-- Classrooms List --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($classrooms as $classroom)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition">
                    <div class="p-5">
                        <div class="flex items-center space-x-3 mb-4">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                                {{ strtoupper(substr($classroom->subject ?? $classroom->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $classroom->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $classroom->subject ?? 'Mata Pelajaran' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <p class="text-2xl font-bold text-gray-900">{{ $classroom->students_count }}</p>
                                <p class="text-xs text-gray-500">Siswa</p>
                            </div>
                            <div class="bg-gray-50 rounded-lg p-3 text-center">
                                <p class="text-2xl font-bold text-gray-900">{{ $classroom->assignments_count }}</p>
                                <p class="text-xs text-gray-500">Tugas</p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('teacher.reports.classroom', $classroom) }}"
                                class="flex-1 btn btn-primary text-center text-sm py-2">
                                Lihat Detail
                            </a>
                            <a href="{{ route('teacher.reports.export', $classroom) }}" class="btn btn-secondary text-sm py-2"
                                title="Export">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center text-gray-500">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p>Belum ada kelas untuk ditampilkan laporannya</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection