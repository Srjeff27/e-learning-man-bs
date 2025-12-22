@extends('layouts.teacher')

@section('title', 'Laporan - ' . $classroom->name)
@section('page-title', 'Laporan Penilaian: ' . $classroom->name)

@section('content')
    <div class="space-y-6">
        {{-- Back Link --}}
        <a href="{{ route('teacher.reports.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Laporan
        </a>

        {{-- Class Info --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                        {{ strtoupper(substr($classroom->subject ?? $classroom->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $classroom->name }}</h2>
                        <p class="text-gray-500">{{ $classroom->subject ?? 'Mata Pelajaran' }} • {{ $students->count() }}
                            siswa • {{ $assignments->count() }} tugas</p>
                    </div>
                </div>
                <a href="{{ route('teacher.reports.export', $classroom) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export
                </a>
            </div>
        </div>

        {{-- Grades Table --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase sticky left-0 bg-gray-50">
                                No</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase sticky left-10 bg-gray-50 min-w-[200px]">
                                Nama Siswa</th>
                            @foreach($assignments as $assignment)
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase min-w-[100px]"
                                    title="{{ $assignment->title }}">
                                    {{ Str::limit($assignment->title, 15) }}
                                </th>
                            @endforeach
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase bg-emerald-50">
                                Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($grades as $studentId => $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-500 sticky left-0 bg-white">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 sticky left-10 bg-white">
                                    <span class="font-medium text-gray-900">{{ $data['student']->name }}</span>
                                </td>
                                @foreach($assignments as $assignment)
                                    <td class="px-4 py-3 text-center">
                                        @php $submission = $data['assignments'][$assignment->id] ?? null; @endphp
                                        @if($submission && $submission->status === 'graded')
                                            <span
                                                class="font-medium {{ $submission->score >= ($assignment->max_score * 0.7) ? 'text-green-600' : ($submission->score >= ($assignment->max_score * 0.5) ? 'text-yellow-600' : 'text-red-600') }}">
                                                {{ $submission->score }}
                                            </span>
                                        @elseif($submission)
                                            <span class="text-xs text-orange-500">Pending</span>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-4 py-3 text-center bg-emerald-50">
                                    @if($data['average'] !== null)
                                        <span
                                            class="font-bold {{ $data['average'] >= 70 ? 'text-green-600' : ($data['average'] >= 50 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $data['average'] }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ 3 + $assignments->count() }}" class="px-4 py-12 text-center text-gray-500">
                                    Belum ada data siswa
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Legend --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <p class="text-sm text-gray-500 mb-2">Keterangan Warna:</p>
            <div class="flex flex-wrap gap-4 text-sm">
                <div class="flex items-center">
                    <span class="w-4 h-4 bg-green-500 rounded mr-2"></span>
                    <span class="text-gray-600">≥ 70% (Baik)</span>
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 bg-yellow-500 rounded mr-2"></span>
                    <span class="text-gray-600">50-69% (Cukup)</span>
                </div>
                <div class="flex items-center">
                    <span class="w-4 h-4 bg-red-500 rounded mr-2"></span>
                    <span class="text-gray-600">&lt; 50% (Kurang)</span>
                </div>
            </div>
        </div>
    </div>
@endsection