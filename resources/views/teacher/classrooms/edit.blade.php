@extends('layouts.teacher')

@section('title', 'Edit Kelas')

@push('styles')
<style>
    .animate-enter { animation: enter 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes enter { to { opacity: 1; transform: translateY(0); } }
    
    .glass-panel {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 32px 0 rgba(16, 185, 129, 0.15);
    }
    .dark .glass-panel {
        background: rgba(15, 23, 42, 0.65);
        border: 1px solid rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.4);
    }

    .input-glossy {
        transition: all 0.3s ease;
        background-color: rgba(255, 255, 255, 0.5);
    }
    .dark .input-glossy {
        background-color: rgba(30, 41, 59, 0.5);
    }
    .input-glossy:focus {
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.25);
        border-color: #10b981;
        background-color: rgba(255, 255, 255, 0.9);
    }
    .dark .input-glossy:focus {
        background-color: rgba(30, 41, 59, 0.8);
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-slate-50 dark:bg-slate-950 transition-colors duration-500 py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden font-sans">
    
    <div class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-emerald-400/20 rounded-full blur-[120px] mix-blend-multiply dark:mix-blend-screen pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[500px] h-[500px] bg-teal-500/20 rounded-full blur-[100px] mix-blend-multiply dark:mix-blend-screen pointer-events-none"></div>

    <div class="max-w-4xl mx-auto relative z-10">
        
        <div class="mb-8 animate-enter flex justify-between items-center">
            <a href="{{ route('teacher.classrooms.show', $classroom) }}" class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors group">
                <div class="mr-2 p-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-sm group-hover:border-emerald-400 dark:group-hover:border-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </div>
                Kembali ke Detail Kelas
            </a>
        </div>

        <div class="glass-panel rounded-[2rem] p-8 md:p-10 animate-enter" style="animation-delay: 0.1s;">
            <div class="flex items-center gap-4 mb-8 border-b border-slate-200 dark:border-slate-700/50 pb-6">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center text-white">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Perbarui Informasi Kelas</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">Ubah detail kelas dan pengaturan akademik.</p>
                </div>
            </div>

            <form action="{{ route('teacher.classrooms.update', $classroom) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label for="name" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Nama Kelas <span class="text-emerald-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $classroom->name) }}"
                                class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 outline-none @error('name') border-red-500 ring-red-500/20 @enderror" 
                                placeholder="Contoh: Matematika Kelas XII IPA" required>
                            @error('name')
                                <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Mata Pelajaran</label>
                            <input type="text" id="subject" name="subject" value="{{ old('subject', $classroom->subject) }}"
                                class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 outline-none"
                                placeholder="Contoh: Matematika">
                        </div>
                        
                        <div>
                            <label for="academic_year" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Tahun Ajaran</label>
                            <input type="text" id="academic_year" name="academic_year" value="{{ old('academic_year', $classroom->academic_year) }}" 
                                class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 outline-none"
                                placeholder="Contoh: 2024/2025">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="grade" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Tingkat Kelas</label>
                            <div class="relative">
                                <select id="grade" name="grade" class="input-glossy appearance-none block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white outline-none cursor-pointer">
                                    <option value="" class="dark:bg-slate-800">Pilih Kelas</option>
                                    <option value="X" {{ old('grade', $classroom->grade) === 'X' ? 'selected' : '' }} class="dark:bg-slate-800">Kelas X</option>
                                    <option value="XI" {{ old('grade', $classroom->grade) === 'XI' ? 'selected' : '' }} class="dark:bg-slate-800">Kelas XI</option>
                                    <option value="XII" {{ old('grade', $classroom->grade) === 'XII' ? 'selected' : '' }} class="dark:bg-slate-800">Kelas XII</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="semester" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Semester</label>
                            <div class="relative">
                                <select id="semester" name="semester" class="input-glossy appearance-none block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white outline-none cursor-pointer">
                                    <option value="" class="dark:bg-slate-800">Pilih Semester</option>
                                    <option value="Ganjil" {{ old('semester', $classroom->semester) === 'Ganjil' ? 'selected' : '' }} class="dark:bg-slate-800">Ganjil</option>
                                    <option value="Genap" {{ old('semester', $classroom->semester) === 'Genap' ? 'selected' : '' }} class="dark:bg-slate-800">Genap</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Status Kelas</label>
                            <div class="relative">
                                <select id="status" name="status" class="input-glossy appearance-none block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white outline-none cursor-pointer">
                                    <option value="active" {{ old('status', $classroom->status) === 'active' ? 'selected' : '' }} class="dark:bg-slate-800">🟢 Aktif</option>
                                    <option value="archived" {{ old('status', $classroom->status) === 'archived' ? 'selected' : '' }} class="dark:bg-slate-800">🟡 Diarsipkan</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2 ml-1">Deskripsi</label>
                        <textarea id="description" name="description" rows="3" 
                            class="input-glossy block w-full px-5 py-3.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 outline-none resize-none"
                            placeholder="Deskripsi singkat tentang kelas ini">{{ old('description', $classroom->description) }}</textarea>
                    </div>

                    {{-- Class Code Display (Read Only) --}}
                    <div class="relative group overflow-hidden rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50/50 dark:bg-emerald-900/10 p-5 transition-all hover:bg-emerald-100/50 dark:hover:bg-emerald-900/20">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-1">Kode Kelas (Permanen)</p>
                                <p class="text-2xl font-mono font-black text-slate-800 dark:text-white tracking-widest">{{ $classroom->code }}</p>
                            </div>
                            <div class="p-3 bg-white dark:bg-slate-800 rounded-lg text-emerald-500 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                            </div>
                        </div>
                        <div class="mt-2 text-xs text-slate-500 dark:text-emerald-200/70">
                            Bagikan kode ini kepada siswa agar mereka dapat bergabung.
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200 dark:border-slate-700 flex flex-col-reverse sm:flex-row justify-end gap-3">
                    <a href="{{ route('teacher.classrooms.show', $classroom) }}" 
                        class="w-full sm:w-auto px-6 py-3.5 rounded-xl text-slate-600 dark:text-slate-300 font-bold bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all text-center shadow-sm hover:shadow-md">
                        Batal
                    </a>
                    <button type="submit" 
                        class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-white font-bold bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-lg shadow-emerald-500/30 hover:shadow-emerald-500/40 transform hover:-translate-y-0.5 transition-all text-center flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection