@extends('layouts.teacher')

@section('title', 'Buat Pertemuan - ' . $classroom->name)
@section('page-title', 'Buat Pertemuan Baru')

@push('styles')
    <style>
        .animate-enter {
            animation: enter 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes enter {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .glass-form {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.1);
        }

        .dark .glass-form {
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .input-glossy {
            transition: all 0.3s ease;
        }

        .input-glossy:focus {
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
            transform: translateY(-1px);
        }
    </style>
@endpush

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        {{-- Breadcrumb --}}
        <div class="animate-enter">
            <a href="{{ route('teacher.attendance.index', $classroom) }}"
                class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                <div
                    class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-300 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </div>
                Kembali ke {{ $classroom->name }}
            </a>
        </div>

        {{-- Form --}}
        <div class="glass-form rounded-[2rem] p-8 animate-enter" style="animation-delay: 0.1s;">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 shadow-lg shadow-emerald-500/30 mb-4 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">Buat Pertemuan Baru</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1">{{ $classroom->name }}</p>
            </div>

            <form action="{{ route('teacher.attendance.store-session', $classroom) }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="session_number"
                            class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Pertemuan Ke- <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="session_number" name="session_number"
                            value="{{ old('session_number', $nextSessionNumber) }}"
                            class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white focus:border-emerald-500 outline-none @error('session_number') border-red-500 @enderror"
                            min="1" required>
                        @error('session_number')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Tanggal
                            <span class="text-red-500">*</span></label>
                        <input type="date" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}"
                            class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white focus:border-emerald-500 outline-none @error('date') border-red-500 @enderror"
                            required>
                        @error('date')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="topic" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Materi/Topik
                        <span class="text-red-500">*</span></label>
                    <input type="text" id="topic" name="topic" value="{{ old('topic') }}"
                        class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-emerald-500 outline-none @error('topic') border-red-500 @enderror"
                        placeholder="Contoh: Aljabar Linear, Persamaan Kuadrat, dll" required>
                    @error('topic')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="notes" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Catatan
                        (Opsional)</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-emerald-500 outline-none resize-none"
                        placeholder="Catatan tambahan untuk pertemuan ini...">{{ old('notes') }}</textarea>
                </div>

                <div
                    class="pt-4 border-t border-slate-200 dark:border-slate-700 flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <a href="{{ route('teacher.attendance.index', $classroom) }}"
                        class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-white font-bold bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Buat & Isi Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection