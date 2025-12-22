@extends('layouts.admin')

@section('title', 'Profil Sekolah')
@section('page-title', 'Profil Sekolah')
@section('page-subtitle', 'Kelola informasi profil sekolah')

@section('content')
<div class="max-w-7xl mx-auto" x-data="profileManager()">
    <!-- Header dengan Statistik -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Profil Sekolah</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-2">Kelola informasi lengkap sekolah secara dinamis</p>
            </div>
            <div class="flex items-center space-x-4">
                <button type="button" @click="saveAll()" class="px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    <span>Simpan Semua</span>
                </button>
            </div>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
            <div class="glass-card rounded-2xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 rounded-xl bg-blue-500/10">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ strlen($profile->name) > 0 ? '✓' : '0' }}</span>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">Info Umum</p>
            </div>

            <div class="glass-card rounded-2xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 rounded-xl bg-cyan-500/10">
                        <svg class="w-6 h-6 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ strlen($profile->vision) > 0 ? '✓' : '0' }}</span>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">Visi & Misi</p>
            </div>

            <div class="glass-card rounded-2xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 rounded-xl bg-emerald-500/10">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ count($profile->organization_structure ?? []) }}</span>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">Struktur</p>
            </div>

            <div class="glass-card rounded-2xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 rounded-xl bg-violet-500/10">
                        <svg class="w-6 h-6 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ strlen($profile->history) > 0 ? '✓' : '0' }}</span>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">Profil</p>
            </div>

            <div class="glass-card rounded-2xl p-4">
                <div class="flex items-center justify-between">
                    <div class="p-3 rounded-xl bg-amber-500/10">
                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-slate-900 dark:text-white">{{ $profile->school_photo ? '✓' : '0' }}</span>
                </div>
                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2">Foto</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:w-64 flex-shrink-0">
            <div class="glass-card rounded-2xl p-4 sticky top-24">
                <nav class="space-y-2">
                    <button @click="activeTab = 'info'" :class="activeTab === 'info' ? 'bg-gradient-to-r from-blue-500/20 to-cyan-500/20 text-blue-600 dark:text-blue-400 border-l-4 border-blue-500' : 'text-slate-700 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50'"
                        class="w-full text-left px-4 py-3 rounded-xl transition-all duration-300 flex items-center space-x-3 group">
                        <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">Informasi Umum</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Data dasar sekolah</p>
                        </div>
                        <span :class="activeTab === 'info' ? 'opacity-100' : 'opacity-0'" class="w-2 h-2 rounded-full bg-blue-500"></span>
                    </button>

                    <button @click="activeTab = 'visi-misi'" :class="activeTab === 'visi-misi' ? 'bg-gradient-to-r from-blue-500/20 to-cyan-500/20 text-blue-600 dark:text-blue-400 border-l-4 border-blue-500' : 'text-slate-700 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50'"
                        class="w-full text-left px-4 py-3 rounded-xl transition-all duration-300 flex items-center space-x-3 group">
                        <div class="p-2 rounded-lg bg-cyan-100 dark:bg-cyan-900/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">Visi & Misi</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Tujuan & nilai</p>
                        </div>
                        <span :class="activeTab === 'visi-misi' ? 'opacity-100' : 'opacity-0'" class="w-2 h-2 rounded-full bg-blue-500"></span>
                    </button>

                    <button @click="activeTab = 'struktur'" :class="activeTab === 'struktur' ? 'bg-gradient-to-r from-blue-500/20 to-cyan-500/20 text-blue-600 dark:text-blue-400 border-l-4 border-blue-500' : 'text-slate-700 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50'"
                        class="w-full text-left px-4 py-3 rounded-xl transition-all duration-300 flex items-center space-x-3 group">
                        <div class="p-2 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">Struktur Organisasi</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Pimpinan & koordinator</p>
                        </div>
                        <span :class="activeTab === 'struktur' ? 'opacity-100' : 'opacity-0'" class="w-2 h-2 rounded-full bg-blue-500"></span>
                    </button>

                    <button @click="activeTab = 'profil'" :class="activeTab === 'profil' ? 'bg-gradient-to-r from-blue-500/20 to-cyan-500/20 text-blue-600 dark:text-blue-400 border-l-4 border-blue-500' : 'text-slate-700 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800/50'"
                        class="w-full text-left px-4 py-3 rounded-xl transition-all duration-300 flex items-center space-x-3 group">
                        <div class="p-2 rounded-lg bg-violet-100 dark:bg-violet-900/30 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium">Profil Lengkap</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Sejarah & fasilitas</p>
                        </div>
                        <span :class="activeTab === 'profil' ? 'opacity-100' : 'opacity-0'" class="w-2 h-2 rounded-full bg-blue-500"></span>
                    </button>
                </nav>

                <div class="mt-6 p-4 rounded-xl bg-gradient-to-br from-blue-500/5 to-cyan-500/5">
                    <p class="text-sm text-slate-700 dark:text-slate-300 font-medium mb-2">💡 Tips Pengisian</p>
                    <p class="text-xs text-slate-600 dark:text-slate-400">Pastikan semua data diisi lengkap untuk tampilan optimal di website.</p>
                </div>
            </div>
        </div>

        <!-- Main Form Area -->
        <div class="flex-1">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="profileForm">
                @csrf
                @method('PUT')

                <!-- Tab: Informasi Umum -->
                <div x-show="activeTab === 'info'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="space-y-6">
                    
                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Identitas Sekolah</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Informasi dasar dan kontak sekolah</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span>
                                    Nama Sekolah
                                </label>
                                <input type="text" name="name" value="{{ old('name', $profile->name) }}"
                                    class="input-field"
                                    placeholder="Masukkan nama sekolah lengkap">
                            </div>
                            <div class="form-group">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-cyan-500 mr-2"></span>
                                    NPSN
                                </label>
                                <input type="text" name="npsn" value="{{ old('npsn', $profile->npsn) }}"
                                    class="input-field"
                                    placeholder="Nomor Pokok Sekolah Nasional">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                                    Alamat Lengkap
                                </label>
                                <textarea name="address" rows="3" class="input-field">{{ old('address', $profile->address) }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-violet-500 mr-2"></span>
                                    Telepon
                                </label>
                                <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                                    class="input-field"
                                    placeholder="(0736) XXXXX">
                            </div>
                            <div class="form-group">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 mr-2"></span>
                                    Email
                                </label>
                                <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                                    class="input-field"
                                    placeholder="admin@sman2kaur.sch.id">
                            </div>
                            <div class="form-group">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-rose-500 mr-2"></span>
                                    Tahun Berdiri
                                </label>
                                <input type="number" name="established_year" value="{{ old('established_year', $profile->established_year) }}"
                                    class="input-field"
                                    placeholder="Contoh: 1990">
                            </div>
                            <div class="form-group">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-indigo-500 mr-2"></span>
                                    Akreditasi
                                </label>
                                <select name="accreditation" class="input-field">
                                    <option value="A" {{ $profile->accreditation == 'A' ? 'selected' : '' }}>A (Unggul)</option>
                                    <option value="B" {{ $profile->accreditation == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                    <option value="C" {{ $profile->accreditation == 'C' ? 'selected' : '' }}>C (Cukup)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Kepala Sekolah</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Informasi pimpinan sekolah</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="form-group">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap</label>
                                <input type="text" name="principal_name" value="{{ old('principal_name', $profile->principal_name) }}"
                                    class="input-field"
                                    placeholder="Nama kepala sekolah">
                            </div>
                            <div class="form-group">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">NIP</label>
                                <input type="text" name="principal_nip" value="{{ old('principal_nip', $profile->principal_nip) }}"
                                    class="input-field"
                                    placeholder="Nomor Induk Pegawai">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Pesan Sambutan</label>
                                <textarea name="principal_message" rows="3" class="input-field" placeholder="Tuliskan pesan sambutan kepala sekolah...">{{ old('principal_message', $profile->principal_message) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Visi & Misi -->
                <div x-show="activeTab === 'visi-misi'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="space-y-6">
                    
                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Visi Sekolah</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Tujuan dan harapan masa depan</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <textarea name="vision" rows="4" class="input-field" placeholder="Tuliskan visi sekolah yang inspiratif...">{{ old('vision', $profile->vision) }}</textarea>
                        <div class="flex items-center text-sm text-slate-500 dark:text-slate-400 mt-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Visi harus mencerminkan tujuan jangka panjang sekolah
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl"
                        x-data="{
                            missions: {{ json_encode($profile->missions ?? [['title' => '', 'description' => '']]) }},
                            addMission() { 
                                this.missions.push({title: '', description: ''});
                                this.$nextTick(() => {
                                    const lastInput = this.$el.querySelector('.mission-item:last-child input');
                                    if(lastInput) lastInput.focus();
                                });
                            },
                            removeMission(index) { 
                                if(this.missions.length > 1) {
                                    this.missions.splice(index, 1);
                                }
                            }
                        }">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Misi Sekolah</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Langkah-langkah untuk mencapai visi</p>
                            </div>
                            <button type="button" @click="addMission()" 
                                class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-xl hover:shadow-lg hover:shadow-cyan-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Tambah Misi</span>
                            </button>
                        </div>

                        <div class="space-y-4" x-show="missions.length > 0">
                            <template x-for="(mission, index) in missions" :key="index">
                                <div class="mission-item p-4 rounded-xl border-2 border-dashed border-slate-200 dark:border-slate-700 bg-gradient-to-br from-slate-50/50 to-white dark:from-slate-800/30 dark:to-slate-800/10 hover:border-blue-300 dark:hover:border-blue-700 transition-all duration-300">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center text-white font-bold text-lg shadow-lg" x-text="index + 1"></div>
                                        <div class="flex-1 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Judul Misi</label>
                                                <input type="text" :name="'missions[' + index + '][title]'" x-model="mission.title" 
                                                    class="input-field"
                                                    placeholder="Contoh: Meningkatkan Kualitas Pembelajaran">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Deskripsi</label>
                                                <textarea :name="'missions[' + index + '][description]'" x-model="mission.description" rows="2"
                                                    class="input-field"
                                                    placeholder="Jelaskan misi ini secara detail..."></textarea>
                                            </div>
                                        </div>
                                        <button type="button" @click="removeMission(index)" 
                                            :class="missions.length > 1 ? 'opacity-100' : 'opacity-0 pointer-events-none'"
                                            class="p-2 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-all duration-300 transform hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl"
                        x-data="{
                            values: {{ json_encode($profile->values ?? [['title' => '', 'description' => '']]) }},
                            addValue() { this.values.push({title: '', description: ''}); },
                            removeValue(index) { if(this.values.length > 1) this.values.splice(index, 1); }
                        }">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Nilai-Nilai Utama</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Prinsip dan nilai yang dijunjung tinggi</p>
                            </div>
                            <button type="button" @click="addValue()" 
                                class="px-4 py-2 bg-gradient-to-r from-violet-500 to-purple-500 text-white rounded-xl hover:shadow-lg hover:shadow-violet-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Tambah Nilai</span>
                            </button>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <template x-for="(value, index) in values" :key="index">
                                <div class="p-4 rounded-xl bg-gradient-to-br from-slate-50/50 to-white dark:from-slate-800/30 dark:to-slate-800/10 border border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-500 transition-all duration-300 relative group">
                                    <button type="button" @click="removeValue(index)" 
                                        :class="values.length > 1 ? 'opacity-0 group-hover:opacity-100' : 'opacity-0 pointer-events-none'"
                                        class="absolute -top-2 -right-2 p-1.5 bg-white dark:bg-slate-800 text-red-500 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-violet-500/20 to-purple-500/20 flex items-center justify-center mb-3">
                                        <span class="text-violet-600 dark:text-violet-400 font-bold" x-text="index + 1"></span>
                                    </div>
                                    <input type="text" :name="'values[' + index + '][title]'" x-model="value.title" 
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm font-medium mb-2"
                                        placeholder="Nama nilai (contoh: Integritas)">
                                    <textarea :name="'values[' + index + '][description]'" x-model="value.description" rows="2"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm"
                                        placeholder="Deskripsi nilai..."></textarea>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Motto & Tagline</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Kalimat penyemangat dan ciri khas</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <input type="text" name="motto" value="{{ old('motto', $profile->motto) }}" 
                            class="input-field text-center text-xl font-semibold"
                            placeholder="Contoh: Unggul dalam Prestasi, Berakhlak Mulia">
                        <div class="text-center text-sm text-slate-500 dark:text-slate-400 mt-2">
                            Motto akan ditampilkan di halaman utama website
                        </div>
                    </div>
                </div>

                <!-- Tab: Struktur Organisasi -->
                <div x-show="activeTab === 'struktur'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="space-y-6">
                    
                    @php 
                        $orgStructure = $profile->organization_structure ?? [];
                        $pimpinan = array_values(array_filter($orgStructure, fn($item) => ($item['type'] ?? 'pimpinan') === 'pimpinan'));
                        $koordinator = array_values(array_filter($orgStructure, fn($item) => ($item['type'] ?? '') === 'koordinator'));
                        if(empty($pimpinan)) $pimpinan = [['position' => 'Kepala Sekolah', 'name' => '', 'nip' => '', 'photo' => '', 'type' => 'pimpinan']];
                        if(empty($koordinator)) $koordinator = [['position' => '', 'name' => '', 'nip' => '', 'photo' => '', 'type' => 'koordinator']];
                    @endphp

                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl"
                        x-data="{
                            pimpinan: {{ json_encode($pimpinan) }},
                            addPimpinan() { this.pimpinan.push({position: '', name: '', nip: '', photo: '', type: 'pimpinan'}); },
                            removePimpinan(index) { if(this.pimpinan.length > 1) this.pimpinan.splice(index, 1); },
                            previewPhoto(event, index) {
                                const file = event.target.files[0];
                                if(file) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.pimpinan[index].photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }
                        }">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Pimpinan Sekolah</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Kepala sekolah dan wakil kepala sekolah</p>
                            </div>
                            <button type="button" @click="addPimpinan()" 
                                class="px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Tambah Pimpinan</span>
                            </button>
                        </div>

                        <div class="space-y-6">
                            <template x-for="(item, index) in pimpinan" :key="'pimpinan-' + index">
                                <div class="p-6 rounded-xl border-2 border-dashed border-blue-200 dark:border-blue-800/30 bg-gradient-to-br from-blue-50/30 to-white dark:from-blue-900/10 dark:to-slate-800/10 hover:border-blue-300 dark:hover:border-blue-600 transition-all duration-300">
                                    <div class="flex flex-col lg:flex-row gap-6">
                                        <!-- Photo Upload -->
                                        <div class="lg:w-48 flex-shrink-0">
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Foto</label>
                                                <div class="relative">
                                                    <div class="w-32 h-32 rounded-xl overflow-hidden border-2 border-dashed border-slate-300 dark:border-slate-600 bg-gradient-to-br from-blue-500/10 to-cyan-500/10 flex items-center justify-center">
                                                        <template x-if="item.photoPreview || (item.photo && item.photo.length > 0)">
                                                            <img :src="item.photoPreview || '/storage/' + item.photo" 
                                                                class="w-full h-full object-cover">
                                                        </template>
                                                        <template x-if="!item.photoPreview && (!item.photo || item.photo.length === 0)">
                                                            <div class="text-center p-4">
                                                                <svg class="w-12 h-12 mx-auto text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">Upload Foto</p>
                                                            </div>
                                                        </template>
                                                    </div>
                                                    <label :for="'pimpinan-photo-' + index" class="absolute bottom-2 right-2 p-2 bg-blue-500 text-white rounded-lg shadow-lg cursor-pointer hover:bg-blue-600 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                        </svg>
                                                    </label>
                                                    <input type="file" :id="'pimpinan-photo-' + index" :name="'pimpinan_photos[' + index + ']'" accept="image/*" 
                                                        @change="previewPhoto($event, index)"
                                                        class="hidden">
                                                    <input type="hidden" :name="'pimpinan[' + index + '][photo]'" :value="item.photo || ''">
                                                </div>
                                            </div>
                                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                                <p>Format: JPG, PNG</p>
                                                <p>Max: 1MB</p>
                                                <p>Rasio: 1:1</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Information -->
                                        <div class="flex-1 space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Jabatan</label>
                                                <input type="text" :name="'pimpinan[' + index + '][position]'" x-model="item.position"
                                                    class="input-field"
                                                    placeholder="Contoh: Wakasek Kurikulum">
                                            </div>
                                            <div class="grid md:grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap</label>
                                                    <input type="text" :name="'pimpinan[' + index + '][name]'" x-model="item.name"
                                                        class="input-field"
                                                        placeholder="Nama lengkap">
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">NIP</label>
                                                    <input type="text" :name="'pimpinan[' + index + '][nip]'" x-model="item.nip"
                                                        class="input-field"
                                                        placeholder="Nomor Induk Pegawai">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Remove Button -->
                                        <div class="flex lg:flex-col justify-end lg:justify-start space-x-2 lg:space-x-0 lg:space-y-2">
                                            <button type="button" @click="removePimpinan(index)" 
                                                :class="pimpinan.length > 1 ? 'opacity-100' : 'opacity-0 pointer-events-none'"
                                                class="px-4 py-2 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-xl hover:shadow-lg hover:shadow-red-500/30 transition-all duration-300 flex items-center space-x-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                <span class="hidden lg:inline">Hapus</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl"
                        x-data="{
                            koordinator: {{ json_encode($koordinator) }},
                            addKoordinator() { this.koordinator.push({position: '', name: '', nip: '', photo: '', type: 'koordinator'}); },
                            removeKoordinator(index) { if(this.koordinator.length > 1) this.koordinator.splice(index, 1); },
                            previewPhoto(event, index) {
                                const file = event.target.files[0];
                                if(file) {
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        this.koordinator[index].photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }
                        }">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Koordinator & Staf</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Kepala bidang, laboratorium, dan staf</p>
                            </div>
                            <button type="button" @click="addKoordinator()" 
                                class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-500 text-white rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Tambah Koordinator</span>
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(item, index) in koordinator" :key="'koordinator-' + index">
                                <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-emerald-50/20 to-white dark:from-emerald-900/10 dark:to-slate-800/10 hover:border-emerald-300 dark:hover:border-emerald-600 transition-all duration-300 group">
                                    <div class="flex flex-col lg:flex-row items-start lg:items-center gap-4">
                                        <!-- Photo -->
                                        <div class="flex-shrink-0">
                                            <div class="relative">
                                                <div class="w-16 h-16 rounded-lg overflow-hidden border border-slate-300 dark:border-slate-600 bg-gradient-to-br from-emerald-500/10 to-teal-500/10">
                                                    <template x-if="item.photoPreview || (item.photo && item.photo.length > 0)">
                                                        <img :src="item.photoPreview || '/storage/' + item.photo" 
                                                            class="w-full h-full object-cover">
                                                    </template>
                                                    <template x-if="!item.photoPreview && (!item.photo || item.photo.length === 0)">
                                                        <div class="w-full h-full flex items-center justify-center">
                                                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                            </svg>
                                                        </div>
                                                    </template>
                                                </div>
                                                <label :for="'koordinator-photo-' + index" class="absolute -bottom-1 -right-1 p-1 bg-emerald-500 text-white rounded-full shadow cursor-pointer hover:bg-emerald-600 transition-colors">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                                    </svg>
                                                </label>
                                                <input type="file" :id="'koordinator-photo-' + index" :name="'koordinator_photos[' + index + ']'" accept="image/*" 
                                                    @change="previewPhoto($event, index)"
                                                    class="hidden">
                                                <input type="hidden" :name="'koordinator[' + index + '][photo]'" :value="item.photo || ''">
                                            </div>
                                        </div>
                                        
                                        <!-- Information -->
                                        <div class="flex-1 grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Jabatan</label>
                                                <input type="text" :name="'koordinator[' + index + '][position]'" x-model="item.position"
                                                    class="input-field text-sm"
                                                    placeholder="Contoh: Kepala Lab IPA">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama</label>
                                                <input type="text" :name="'koordinator[' + index + '][name]'" x-model="item.name"
                                                    class="input-field text-sm"
                                                    placeholder="Nama lengkap">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">NIP</label>
                                                <input type="text" :name="'koordinator[' + index + '][nip]'" x-model="item.nip"
                                                    class="input-field text-sm"
                                                    placeholder="NIP (opsional)">
                                            </div>
                                        </div>
                                        
                                        <!-- Remove Button -->
                                        <button type="button" @click="removeKoordinator(index)" 
                                            :class="koordinator.length > 1 ? 'opacity-100' : 'opacity-0 pointer-events-none'"
                                            class="p-2 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-all duration-300 transform hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Tab: Profil Lengkap -->
                <div x-show="activeTab === 'profil'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="space-y-6">
                    
                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Sejarah Sekolah</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Cerita perjalanan sekolah dari awal berdiri</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        
                        <textarea name="history" rows="10" class="input-field" placeholder="Tuliskan sejarah sekolah secara lengkap...">{{ old('history', $profile->history) }}</textarea>
                        <div class="flex items-center text-sm text-slate-500 dark:text-slate-400 mt-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Gunakan editor untuk format teks yang lebih baik
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl"
                        x-data="{
                            facilities: {{ json_encode($profile->facilities ?? ['']) }},
                            addFacility() { 
                                this.facilities.push('');
                                this.$nextTick(() => {
                                    const lastInput = this.$el.querySelector('.facility-item:last-child input');
                                    if(lastInput) lastInput.focus();
                                });
                            },
                            removeFacility(index) { 
                                if(this.facilities.length > 1) {
                                    this.facilities.splice(index, 1);
                                }
                            }
                        }">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Fasilitas Sekolah</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Sarana dan prasarana yang tersedia</p>
                            </div>
                            <button type="button" @click="addFacility()" 
                                class="px-4 py-2 bg-gradient-to-r from-cyan-500 to-teal-500 text-white rounded-xl hover:shadow-lg hover:shadow-cyan-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                <span>Tambah Fasilitas</span>
                            </button>
                        </div>

                        <div class="space-y-3">
                            <template x-for="(facility, index) in facilities" :key="index">
                                <div class="facility-item flex items-center space-x-3 p-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-slate-50/50 to-white dark:from-slate-800/30 dark:to-slate-800/10 hover:border-cyan-300 dark:hover:border-cyan-500 transition-all duration-300">
                                    <span class="w-6 h-6 rounded-lg bg-gradient-to-br from-cyan-500/20 to-teal-500/20 flex items-center justify-center text-cyan-600 dark:text-cyan-400 font-bold text-xs flex-shrink-0" x-text="index + 1"></span>
                                    <input type="text" name="facilities[]" x-model="facilities[index]" 
                                        class="flex-1 px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm"
                                        placeholder="Contoh: Laboratorium Komputer, Perpustakaan Digital, dll.">
                                    <button type="button" @click="removeFacility(index)" 
                                        :class="facilities.length > 1 ? 'opacity-100' : 'opacity-0 pointer-events-none'"
                                        class="p-2 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 transform transition-all duration-300 hover:shadow-xl">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white">Foto Utama Sekolah</h3>
                                <p class="text-slate-600 dark:text-slate-400 mt-1">Foto yang akan ditampilkan di halaman utama</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6">
                            @if($profile->school_photo)
                            <div>
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Foto Saat Ini</p>
                                <div class="rounded-xl overflow-hidden border border-slate-200 dark:border-slate-700">
                                    <img src="{{ Storage::url($profile->school_photo) }}" 
                                        class="w-full h-64 object-cover"
                                        alt="Foto Sekolah">
                                </div>
                            </div>
                            @endif
                            
                            <div class="@if($profile->school_photo) md:col-span-1 @else md:col-span-2 @endif">
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Upload Foto Baru</p>
                                <div class="border-2 border-dashed border-slate-300 dark:border-slate-600 rounded-xl p-8 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-300 bg-gradient-to-br from-slate-50/50 to-white dark:from-slate-800/30 dark:to-slate-800/10">
                                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <p class="text-slate-600 dark:text-slate-400 mb-2">Drag & drop atau klik untuk upload</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Format: JPG, PNG. Maksimal 2MB</p>
                                    <label for="school-photo" class="px-4 py-2 bg-gradient-to-r from-blue-500 to-cyan-500 text-white rounded-lg hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300 inline-block cursor-pointer">
                                        Pilih File
                                    </label>
                                    <input type="file" id="school-photo" name="school_photo" accept="image/*" class="hidden">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px rgba(0, 107, 255, 0.08);
    }
    
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.05);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }
    
    .input-field {
        width: 100%;
        padding: 0.875rem 1rem;
        border-radius: 0.75rem;
        border: 1px solid #e2e8f0;
        background: rgba(255, 255, 255, 0.9);
        color: #1e293b;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }
    
    .dark .input-field {
        border-color: #475569;
        background: rgba(15, 23, 42, 0.9);
        color: #f1f5f9;
    }
    
    .input-field:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }
    
    .dark .input-field:focus {
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.2);
    }
    
    .form-group {
        position: relative;
    }
    
    .form-group label {
        transition: all 0.3s ease;
    }
    
    .form-group:focus-within label {
        transform: translateY(-2px);
    }
    
    textarea.input-field {
        min-height: 120px;
        resize: vertical;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-slide-in {
        animation: slideIn 0.5s ease-out;
    }
    
    @media (max-width: 768px) {
        .glass-card {
            padding: 1.25rem;
        }
        
        .input-field {
            padding: 0.75rem;
        }
    }
</style>

<script>
    function profileManager() {
        return {
            activeTab: 'info',
            isLoading: false,
            
            init() {
                this.setupAutoSave();
            },
            
            setupAutoSave() {
                const form = document.getElementById('profileForm');
                let saveTimeout;
                
                form.addEventListener('input', () => {
                    clearTimeout(saveTimeout);
                    saveTimeout = setTimeout(() => {
                        this.saveAll();
                    }, 3000);
                });
            },
            
            async saveAll() {
                if (this.isLoading) return;
                
                this.isLoading = true;
                const submitButton = document.querySelector('[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                submitButton.innerHTML = `
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Menyimpan...
                `;
                submitButton.disabled = true;
                
                try {
                    const form = document.getElementById('profileForm');
                    const formData = new FormData(form);
                    
                    const response = await fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    });
                    
                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        const result = await response.json();
                        if (result.success) {
                            this.showNotification('Data berhasil disimpan!', 'success');
                        } else {
                            this.showNotification(result.message || 'Gagal menyimpan data.', 'error');
                        }
                    } else {
                        // Not JSON, likely an HTML error page or redirect
                         const text = await response.text();
                         console.error('Non-JSON response:', text);
                         if (response.ok) {
                             // Assuming success if status is 200 but not JSON (maybe direct redirect processed by browser?)
                             // But fetch follows redirects automatically.
                             this.showNotification('Data disimpan (Notifikasi manual).', 'success');
                         } else {
                             this.showNotification(`Terjadi kesalahan server (${response.status}).`, 'error');
                         }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.showNotification('Terjadi kesalahan saat menyimpan.', 'error');
                } finally {
                    this.isLoading = false;
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                }
            },
            
            showNotification(message, type = 'info') {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-xl transition-all duration-300 transform translate-x-0 ${
                    type === 'success' ? 'bg-gradient-to-r from-emerald-500 to-green-500 text-white' :
                    type === 'error' ? 'bg-gradient-to-r from-red-500 to-rose-500 text-white' :
                    'bg-gradient-to-r from-blue-500 to-cyan-500 text-white'
                }`;
                notification.innerHTML = `
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${
                                type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"' :
                                type === 'error' ? 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"' :
                                'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
                            }"/>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.style.transform = 'translateX(120%)';
                    setTimeout(() => notification.remove(), 300);
                }, 3000);
            }
        };
    }
</script>
@endsection