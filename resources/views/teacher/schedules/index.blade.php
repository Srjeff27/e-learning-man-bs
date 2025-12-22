@extends('layouts.lms')

@section('title', 'Jadwal - ' . $classroom->name)

@section('content')
    <div class="mb-6">
        <a href="{{ route('teacher.classrooms.show', $classroom) }}"
            class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke {{ $classroom->name }}
        </a>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Jadwal Kelas</h1>
            <p class="text-gray-500">{{ $classroom->name }}</p>
        </div>
        <a href="{{ route('teacher.schedules.create', $classroom) }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jadwal
        </a>
    </div>

    @if($schedules->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-2">Belum ada jadwal</h3>
            <p class="text-gray-500 mb-6">Tambahkan jadwal untuk kelas ini</p>
            <a href="{{ route('teacher.schedules.create', $classroom) }}" class="btn btn-primary">Tambah Jadwal</a>
        </div>
    @else
        <div class="space-y-6">
            @foreach(\App\Models\Schedule::DAYS as $dayKey => $dayLabel)
                @if($schedules->has($dayKey))
                    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-3">
                            <h3 class="font-semibold text-white">{{ $dayLabel }}</h3>
                        </div>
                        <div class="divide-y">
                            @foreach($schedules[$dayKey] as $schedule)
                                <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                                    <div class="flex items-center space-x-4">
                                        <div class="text-lg font-semibold text-green-600">
                                            {{ date('H:i', strtotime($schedule->start_time)) }} -
                                            {{ date('H:i', strtotime($schedule->end_time)) }}
                                        </div>
                                        @if($schedule->room)
                                            <span class="px-2 py-1 bg-gray-100 rounded text-sm text-gray-600">
                                                Ruang: {{ $schedule->room }}
                                            </span>
                                        @endif
                                        @if($schedule->notes)
                                            <span class="text-sm text-gray-500">{{ $schedule->notes }}</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('teacher.schedules.edit', [$classroom, $schedule]) }}"
                                            class="p-2 text-gray-400 hover:text-blue-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('teacher.schedules.destroy', [$classroom, $schedule]) }}" method="POST"
                                            onsubmit="return confirm('Hapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
@endsection