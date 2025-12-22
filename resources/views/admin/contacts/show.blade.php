@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('page-title', 'Detail Pesan')
@section('page-subtitle', 'Dari: {{ $contact->name }}')

@section('content')
    <div class="max-w-3xl">
        <div class="glass-card rounded-2xl p-6 space-y-6">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $contact->subject }}</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                        {{ $contact->created_at->format('d F Y, H:i') }}</p>
                </div>
                @if($contact->is_read)
                    <span
                        class="px-3 py-1 text-xs font-medium rounded-full bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">Dibaca</span>
                @else
                    <span
                        class="px-3 py-1 text-xs font-medium rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">Baru</span>
                @endif
            </div>

            <div class="border-t border-slate-100 dark:border-slate-700 pt-6">
                <div class="flex items-center mb-4">
                    <div
                        class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold text-lg mr-4">
                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-slate-900 dark:text-white">{{ $contact->name }}</p>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $contact->email }}</p>
                        @if($contact->phone)
                            <p class="text-sm text-slate-500 dark:text-slate-400">{{ $contact->phone }}</p>
                        @endif
                    </div>
                </div>

                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4">
                    <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap">{{ $contact->message }}</p>
                </div>
            </div>

            <div class="flex items-center justify-between border-t border-slate-100 dark:border-slate-700 pt-6">
                <a href="{{ route('admin.contacts.index') }}"
                    class="inline-flex items-center text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke daftar
                </a>
                <div class="flex space-x-3">
                    <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-medium rounded-xl hover:bg-blue-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Balas via Email
                    </a>
                    <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-500 text-white font-medium rounded-xl hover:bg-red-600 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection