@extends('layouts.teacher')

@section('title', 'Kelola Siswa')
@section('page-title', 'Kelola Siswa')

@section('content')
    <div class="space-y-6">
        {{-- Filter by Class --}}
        <div class="bg-white rounded-xl border border-gray-200 p-4">
            <div class="flex flex-wrap gap-2">
                <span class="text-sm text-gray-500 py-2">Filter Kelas:</span>
                <button class="px-3 py-1.5 rounded-lg text-sm font-medium bg-emerald-500 text-white">
                    Semua ({{ $students->count() }})
                </button>
                @foreach($classrooms as $classroom)
                    <button class="px-3 py-1.5 rounded-lg text-sm font-medium bg-gray-100 text-gray-700 hover:bg-gray-200">
                        {{ $classroom->name }} ({{ $classroom->students->count() }})
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Students Table --}}
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="p-5 border-b border-gray-100">
                <h3 class="font-semibold text-gray-900">Daftar Siswa ({{ $students->count() }})</h3>
            </div>

            @if($students->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Siswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $index => $student)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-900">{{ $student->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $student->email }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($student->enrolledClassrooms as $classroom)
                                                <span class="px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-700">
                                                    {{ $classroom->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-2 py-1 text-xs rounded-full {{ $student->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                            {{ $student->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center text-gray-500">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p>Belum ada siswa terdaftar di kelas Anda</p>
                </div>
            @endif
        </div>
    </div>
@endsection