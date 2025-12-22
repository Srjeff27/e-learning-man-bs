@extends('layouts.teacher')

@section('title', 'Anggota Kelas')

@section('content')
    <div class="max-w-4xl">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke {{ $classroom->name }}
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Anggota Kelas</h2>
                    <p class="text-sm text-gray-500">{{ $classroom->name }} - {{ $members->count() }} anggota</p>
                </div>
                <div class="bg-gray-50 rounded-lg px-4 py-2">
                    <p class="text-xs text-gray-500 mb-1">Kode Kelas</p>
                    <p class="text-lg font-bold text-blue-600 tracking-wider">{{ $classroom->code }}</p>
                </div>
            </div>

            @if($members->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bergabung</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($members as $index => $member)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white text-sm font-medium mr-3">
                                                {{ substr($member->name, 0, 1) }}
                                            </div>
                                            <span class="font-medium text-slate-900">{{ $member->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $member->email }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">
                                        {{ $member->pivot->joined_at ? \Carbon\Carbon::parse($member->pivot->joined_at)->format('d M Y') : $member->pivot->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('teacher.classrooms.remove-member', [$classroom, $member]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin mengeluarkan {{ $member->name }} dari kelas?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                Keluarkan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada anggota</h3>
                    <p class="text-gray-500 mb-4">Bagikan kode kelas kepada siswa untuk bergabung</p>
                    <div class="inline-flex items-center px-4 py-2 bg-gray-100 rounded-lg">
                        <span class="text-gray-500 mr-2">Kode:</span>
                        <span class="text-xl font-bold text-blue-600 tracking-wider">{{ $classroom->code }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection