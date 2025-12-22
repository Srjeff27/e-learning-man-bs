@extends('layouts.lms')

@section('title', 'Kelas Saya')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelas Saya</h1>
            <p class="text-gray-500">Lihat semua kelas yang Anda ikuti</p>
        </div>
    </div>

    <!-- Join Class -->
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-8">
        <h3 class="font-semibold text-slate-900 mb-4">Gabung ke Kelas Baru</h3>
        <form action="{{ route('student.classrooms.join') }}" method="POST" class="flex gap-4">
            @csrf
            <input type="text" name="code" placeholder="Masukkan kode kelas (6 karakter)" class="input flex-1 uppercase"
                maxlength="6" required style="text-transform: uppercase;">
            <button type="submit" class="btn btn-primary">Gabung</button>
        </form>
        @error('code')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    @if($classrooms->isEmpty())
        <div class="card p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-2">Belum ada kelas</h3>
            <p class="text-gray-500">Masukkan kode kelas dari guru Anda untuk bergabung</p>
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($classrooms as $classroom)
                <a href="{{ route('student.classrooms.show', $classroom) }}" class="card-hover group">
                    <div class="h-24 bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center">
                        <span class="text-white text-2xl font-bold">{{ substr($classroom->name, 0, 2) }}</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-slate-900 group-hover:text-blue-600 mb-1">{{ $classroom->name }}</h3>
                        <p class="text-sm text-gray-500 mb-3">{{ $classroom->subject ?? 'Mata Pelajaran' }}</p>
                        <div class="flex items-center text-sm text-gray-500">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ $classroom->teacher->name ?? 'Guru' }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
@endsection