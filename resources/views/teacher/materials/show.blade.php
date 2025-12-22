@extends('layouts.teacher')

@section('title', $material->title)

@section('content')
    <div class="max-w-3xl">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('teacher.classrooms.show', $classroom) }}"
                class="text-gray-500 hover:text-gray-700 flex items-center text-sm">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke {{ $classroom->name }}
            </a>
            <a href="{{ route('teacher.materials.edit', [$classroom, $material]) }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2 py-1 rounded text-xs font-medium 
                                    @if($material->type === 'text') bg-blue-100 text-blue-700
                                    @elseif($material->type === 'file') bg-green-100 text-green-700
                                    @elseif($material->type === 'video') bg-red-100 text-red-700
                                    @else bg-purple-100 text-purple-700 @endif">
                            {{ ucfirst($material->type) }}
                        </span>
                        <span
                            class="px-2 py-1 rounded text-xs font-medium {{ $material->is_published ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $material->is_published ? 'Dipublikasikan' : 'Draft' }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900">{{ $material->title }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Dibuat {{ $material->created_at->format('d M Y H:i') }}
                    </p>
                </div>
            </div>

            @if($material->content)
                <div class="prose prose-slate max-w-none mb-6">
                    {!! nl2br(e($material->content)) !!}
                </div>
            @endif

            @if($material->file_path)
                <div class="p-4 bg-gray-50 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div>
                            <p class="font-medium text-slate-900">{{ $material->file_name }}</p>
                            <p class="text-sm text-gray-500">File attachment</p>
                        </div>
                    </div>
                    <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="btn btn-primary">
                        Download
                    </a>
                </div>
            @endif

            @if($material->external_link)
                <div class="p-4 bg-gray-50 rounded-lg">
                    <p class="text-sm text-gray-500 mb-2">Link Eksternal:</p>
                    <a href="{{ $material->external_link }}" target="_blank"
                        class="text-blue-600 hover:text-blue-800 break-all">
                        {{ $material->external_link }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection