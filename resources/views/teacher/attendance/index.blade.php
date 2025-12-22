@extends('layouts.lms')

@section('title', 'Absensi - ' . $classroom->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('teacher.classrooms.show', $classroom) }}" class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke {{ $classroom->name }}
        </a>
    </div>
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Absensi Kelas</h1>
            <p class="text-gray-500">{{ $classroom->name }}</p>
        </div>
        <a href="{{ route('teacher.attendance.report', $classroom) }}" class="btn btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Lihat Rekap
        </a>
    </div>
    
    <!-- Date Picker -->
    <div class="bg-white rounded-xl shadow-sm border p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" class="input" onchange="this.form.submit()">
            </div>
            <div class="text-gray-600">
                <strong>{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</strong>
            </div>
        </form>
    </div>
    
    <!-- Attendance Form -->
    <form action="{{ route('teacher.attendance.store', $classroom) }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        
        <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($students as $index => $student)
                        @php
                            $attendance = $attendances->get($student->id);
                            $status = $attendance?->status ?? 'hadir';
                            $notes = $attendance?->notes ?? '';
                        @endphp
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center text-sm font-medium mr-3">
                                        {{ substr($student->name, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-900">{{ $student->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    @foreach(\App\Models\Attendance::STATUSES as $key => $data)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $student->id }}][status]" value="{{ $key }}" 
                                                   {{ $status === $key ? 'checked' : '' }} class="sr-only peer">
                                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg border-2 
                                                         peer-checked:border-{{ $data['color'] }}-500 peer-checked:bg-{{ $data['color'] }}-50 
                                                         peer-checked:text-{{ $data['color'] }}-600 text-gray-400 border-gray-200
                                                         hover:border-gray-300 transition-colors">
                                                {{ $data['icon'] }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <input type="text" name="attendance[{{ $student->id }}][notes]" value="{{ $notes }}" 
                                       class="input text-sm py-1" placeholder="Keterangan (opsional)">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                Belum ada siswa terdaftar di kelas ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($students->isNotEmpty())
            <div class="mt-6 flex justify-end">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Absensi
                </button>
            </div>
        @endif
    </form>
    
    <!-- Status Legend -->
    <div class="mt-6 flex flex-wrap gap-4 text-sm text-gray-600">
        @foreach(\App\Models\Attendance::STATUSES as $key => $data)
            <div class="flex items-center">
                <span class="w-6 h-6 rounded bg-{{ $data['color'] }}-100 text-{{ $data['color'] }}-600 flex items-center justify-center mr-2 text-xs font-medium">
                    {{ $data['icon'] }}
                </span>
                {{ $data['label'] }}
            </div>
        @endforeach
    </div>
@endsection
