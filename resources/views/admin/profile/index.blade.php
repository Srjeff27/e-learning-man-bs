@extends('layouts.admin')

@section('title', 'Profil Sekolah')
@section('page-title', 'Profil Sekolah')
@section('page-subtitle', 'Kelola informasi profil sekolah')

@section('content')
    <div class="max-w-5xl" x-data="{ activeTab: 'info' }">
        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-1 mb-6 glass-card rounded-xl p-1.5">
            <button @click="activeTab = 'info'"
                :class="activeTab === 'info' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                class="flex-1 min-w-[120px] px-3 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Info Umum
            </button>
            <button @click="activeTab = 'visi-misi'"
                :class="activeTab === 'visi-misi' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                class="flex-1 min-w-[120px] px-3 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Visi & Misi
            </button>
            <button @click="activeTab = 'history'"
                :class="activeTab === 'history' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                class="flex-1 min-w-[120px] px-3 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                Sejarah
            </button>
            <button @click="activeTab = 'facilities'"
                :class="activeTab === 'facilities' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                class="flex-1 min-w-[120px] px-3 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Fasilitas
            </button>
            <button @click="activeTab = 'photo'"
                :class="activeTab === 'photo' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white'"
                class="flex-1 min-w-[120px] px-3 py-2.5 rounded-lg font-medium transition-all duration-300 flex items-center justify-center text-sm">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Foto
            </button>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Tab: Informasi Umum -->
            <div x-show="activeTab === 'info'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-4"
                x-transition:enter-end="opacity-100 transform translate-x-0">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        Informasi Umum
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama
                                Sekolah</label>
                            <input type="text" name="name" value="{{ old('name', $profile->name) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">NPSN</label>
                            <input type="text" name="npsn" value="{{ old('npsn', $profile->npsn) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Alamat</label>
                            <textarea name="address" rows="2"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('address', $profile->address) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $profile->email) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Tahun
                                Berdiri</label>
                            <input type="number" name="established_year"
                                value="{{ old('established_year', $profile->established_year) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Akreditasi</label>
                            <input type="text" name="accreditation"
                                value="{{ old('accreditation', $profile->accreditation) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6 mt-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Kepala Sekolah
                    </h3>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Nama Kepala
                                Sekolah</label>
                            <input type="text" name="principal_name"
                                value="{{ old('principal_name', $profile->principal_name) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">NIP</label>
                            <input type="text" name="principal_nip"
                                value="{{ old('principal_nip', $profile->principal_nip) }}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab: Visi & Misi -->
            <div x-show="activeTab === 'visi-misi'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-4"
                x-transition:enter-end="opacity-100 transform translate-x-0">

                <!-- Visi -->
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        Visi Kami
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Tuliskan visi sekolah yang menjadi tujuan
                        utama pendidikan.</p>
                    <textarea name="vision" rows="3"
                        placeholder="Contoh: Menjadi lembaga pendidikan unggulan yang menghasilkan generasi beriman, berilmu, berkarakter, dan berdaya saing global."
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('vision', $profile->vision) }}</textarea>
                </div>

                <!-- Misi -->
                <div class="glass-card rounded-2xl p-6 mt-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Misi Kami
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Daftar misi sekolah dengan judul dan
                        deskripsi.</p>

                    <div class="space-y-4">
                        @php $missions = $profile->missions ?? []; @endphp
                        @for($i = 0; $i < 5; $i++)
                            <div
                                class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                                <div class="flex items-start gap-4">
                                    <span
                                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500 to-blue-500 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">{{ $i + 1 }}</span>
                                    <div class="flex-1 space-y-3">
                                        <input type="text" name="missions[{{ $i }}][title]"
                                            value="{{ $missions[$i]['title'] ?? '' }}"
                                            placeholder="Judul misi (contoh: Pendidikan Berkualitas)"
                                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">
                                        <textarea name="missions[{{ $i }}][description]" rows="2"
                                            placeholder="Deskripsi misi..."
                                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">{{ $missions[$i]['description'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <p class="text-xs text-slate-400 mt-3">* Kosongkan field jika tidak ada misi tambahan</p>
                </div>

                <!-- Nilai-Nilai Utama -->
                <div class="glass-card rounded-2xl p-6 mt-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                        Nilai-Nilai Utama
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Prinsip yang menjadi landasan dalam setiap
                        kegiatan pendidikan.</p>

                    <div class="grid md:grid-cols-2 gap-4">
                        @php $values = $profile->values ?? []; @endphp
                        @for($i = 0; $i < 4; $i++)
                            <div
                                class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                                <div class="space-y-3">
                                    <input type="text" name="values[{{ $i }}][title]" value="{{ $values[$i]['title'] ?? '' }}"
                                        placeholder="Nama nilai (contoh: Integritas)"
                                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm font-medium">
                                    <textarea name="values[{{ $i }}][description]" rows="2" placeholder="Deskripsi nilai..."
                                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-sm">{{ $values[$i]['description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <p class="text-xs text-slate-400 mt-3">* Kosongkan field jika tidak ada nilai tambahan</p>
                </div>

                <!-- Motto -->
                <div class="glass-card rounded-2xl p-6 mt-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Motto Sekolah
                    </h3>
                    <input type="text" name="motto" value="{{ old('motto', $profile->motto) }}"
                        placeholder="Contoh: Unggul Dalam Prestasi, Mulia Dalam Budi Pekerti"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                </div>
            </div>

            <!-- Tab: Sejarah -->
            <div x-show="activeTab === 'history'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-4"
                x-transition:enter-end="opacity-100 transform translate-x-0">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Sejarah Sekolah
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Ceritakan perjalanan dan sejarah sekolah dari
                        awal berdiri hingga saat ini.</p>

                    <div>
                        <textarea name="history" rows="12" placeholder="Tuliskan sejarah sekolah di sini..."
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">{{ old('history', $profile->history) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Tab: Fasilitas -->
            <div x-show="activeTab === 'facilities'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-4"
                x-transition:enter-end="opacity-100 transform translate-x-0">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Fasilitas Unggulan
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Daftar fasilitas yang tersedia di sekolah.
                    </p>

                    <div class="space-y-3">
                        @php $facilities = $profile->facilities ?? []; @endphp
                        @for($i = 0; $i < 10; $i++)
                            <div class="flex items-center space-x-3">
                                <span
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-cyan-500/20 to-teal-500/20 flex items-center justify-center text-cyan-600 dark:text-cyan-400 font-bold text-sm">{{ $i + 1 }}</span>
                                <input type="text" name="facilities[]" value="{{ $facilities[$i] ?? '' }}"
                                    placeholder="Nama fasilitas (contoh: Ruang Kelas Ber-AC)"
                                    class="flex-1 px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                            </div>
                        @endfor
                    </div>
                    <p class="text-xs text-slate-400 mt-4">* Kosongkan field jika tidak ada fasilitas tambahan</p>
                </div>
            </div>

            <!-- Tab: Foto Sekolah -->
            <div x-show="activeTab === 'photo'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-4"
                x-transition:enter-end="opacity-100 transform translate-x-0">
                <div class="glass-card rounded-2xl p-6">
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Foto Sekolah
                    </h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Upload foto gedung sekolah yang akan
                        ditampilkan di halaman profil.</p>

                    @if($profile->school_photo)
                        <div class="mb-6">
                            <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Foto Saat Ini:</p>
                            <img src="{{ Storage::url($profile->school_photo) }}" class="w-full max-w-md rounded-xl shadow-lg"
                                alt="Foto Sekolah">
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Upload Foto
                            Baru</label>
                        <input type="file" name="school_photo" accept="image/*"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <p class="text-xs text-slate-400 mt-2">Format: JPG, PNG. Maksimal 2MB.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection