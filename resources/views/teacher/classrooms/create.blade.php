@extends('layouts.teacher')

@section('title', 'Buat Kelas Baru')

@push('styles')
<style>
    .animate-enter { animation: enter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes enter { to { opacity: 1; transform: translateY(0); } }
    
    .glass-form {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.1);
    }
    .dark .glass-form {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
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
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-500 py-12 px-4 sm:px-6 lg:px-8 font-sans relative overflow-hidden">
    
    <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-emerald-400/20 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2 mix-blend-multiply dark:mix-blend-screen pointer-events-none"></div>
    <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-teal-400/20 rounded-full blur-[100px] translate-x-1/2 translate-y-1/2 mix-blend-multiply dark:mix-blend-screen pointer-events-none"></div>

    <div class="max-w-3xl mx-auto relative z-10">
        
        <div class="mb-8 animate-enter">
            <a href="{{ route('teacher.classrooms.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                <div class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-300 dark:group-hover:border-emerald-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Kelas Saya
            </a>
        </div>

        <div class="glass-form rounded-[2rem] p-8 md:p-10 animate-enter" style="animation-delay: 0.1s;">
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 shadow-lg shadow-emerald-500/30 mb-4 text-white">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white tracking-tight">Buat Kelas Baru</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Lengkapi informasi di bawah untuk memulai ruang belajar baru.</p>
            </div>

            <form action="{{ route('teacher.classrooms.store') }}" method="POST" class="space-y-8">
                @csrf

                <div class="space-y-6">
                    <div class="group">
                        <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Nama Kelas <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="input-glossy block w-full px-5 py-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-emerald-500 focus:ring-0 outline-none @error('name') border-red-500 @enderror" 
                                placeholder="Contoh: Matematika Peminatan XII IPA 1"
                                required>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        </div>
                        @error('name')
                            <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="subject" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Mata Pelajaran</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject') }}" 
                                class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-emerald-500 outline-none"
                                placeholder="Contoh: Matematika">
                        </div>
                        <div>
                            <label for="academic_year" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Tahun Ajaran</label>
                            <input type="text" id="academic_year" name="academic_year"
                                value="{{ old('academic_year', date('Y') . '/' . (date('Y') + 1)) }}" 
                                class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-emerald-500 outline-none"
                                placeholder="YYYY/YYYY">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label for="grade" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Tingkat Kelas</label>
                            <div class="relative">
                                <select id="grade" name="grade" class="input-glossy appearance-none block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white focus:border-emerald-500 outline-none cursor-pointer">
                                    <option value="" class="dark:bg-slate-800">Pilih Kelas</option>
                                    <option value="X" {{ old('grade') === 'X' ? 'selected' : '' }} class="dark:bg-slate-800">Kelas X</option>
                                    <option value="XI" {{ old('grade') === 'XI' ? 'selected' : '' }} class="dark:bg-slate-800">Kelas XI</option>
                                    <option value="XII" {{ old('grade') === 'XII' ? 'selected' : '' }} class="dark:bg-slate-800">Kelas XII</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label for="semester" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Semester</label>
                            <div class="relative">
                                <select id="semester" name="semester" class="input-glossy appearance-none block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white focus:border-emerald-500 outline-none cursor-pointer">
                                    <option value="" class="dark:bg-slate-800">Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester') === 'Ganjil' ? 'selected' : '' }} class="dark:bg-slate-800">Ganjil</option>
                                    <option value="Genap" {{ old('semester') === 'Genap' ? 'selected' : '' }} class="dark:bg-slate-800">Genap</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Deskripsi & Catatan</label>
                        <textarea id="description" name="description" rows="4" 
                            class="input-glossy block w-full px-5 py-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:border-emerald-500 outline-none resize-none"
                            placeholder="Tuliskan deskripsi singkat atau tujuan pembelajaran kelas ini...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 dark:border-slate-700 flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <a href="{{ route('teacher.classrooms.index') }}" 
                        class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-center shadow-sm">
                        Batal
                    </a>
                    <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-white font-bold bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transform hover:-translate-y-0.5 transition-all text-center flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Buat Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection