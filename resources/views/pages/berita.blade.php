@extends('layouts.app')

@section('title', 'Berita')
@section('meta_description', 'Berita dan pengumuman terbaru SMAN 2 KAUR')

@section('content')
    <section class="relative hero-gradient py-24 lg:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 left-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-float"></div>
            <div
                class="absolute bottom-10 right-10 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl animate-float animate-delay-300">
            </div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <span
                class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-blue-200 text-sm font-medium mb-6 animate-fade-in">
                <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                Informasi Terbaru
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Berita & <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Pengumuman</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Tetap update dengan informasi terkini dari SMAN 2 KAUR
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors" x-data="{ 
                activeFilter: 'Semua',
                currentPage: 1,
                itemsPerPage: 6,
                news: [
                    {title: 'Siswa Meraih Medali Emas Olimpiade Sains Nasional', category: 'Akademik', date: '21 Desember 2025', excerpt: 'Prestasi gemilang diraih oleh siswa kelas XII dalam kompetisi Olimpiade Sains Nasional bidang Fisika.', color: 'from-blue-500 to-cyan-500'},
                    {title: 'Peringatan Hari Guru Nasional 2025', category: 'Kegiatan', date: '20 Desember 2025', excerpt: 'Sekolah menggelar rangkaian kegiatan untuk memperingati Hari Guru Nasional dengan penuh semangat.', color: 'from-indigo-500 to-purple-500'},
                    {title: 'Jadwal Ujian Akhir Semester Ganjil', category: 'Pengumuman', date: '19 Desember 2025', excerpt: 'Informasi lengkap mengenai jadwal pelaksanaan Ujian Akhir Semester Ganjil tahun ajaran 2025/2026.', color: 'from-amber-500 to-orange-500'},
                    {title: 'Juara 1 Lomba Debat Bahasa Inggris', category: 'Prestasi', date: '18 Desember 2025', excerpt: 'Tim debat bahasa Inggris berhasil meraih juara pertama dalam kompetisi tingkat provinsi.', color: 'from-emerald-500 to-teal-500'},
                    {title: 'Workshop Kewirausahaan untuk Siswa', category: 'Kegiatan', date: '17 Desember 2025', excerpt: 'Kegiatan workshop kewirausahaan bersama pengusaha sukses untuk membekali siswa dengan jiwa entrepreneur.', color: 'from-rose-500 to-pink-500'},
                    {title: 'Pendaftaran Ekstrakurikuler Semester Genap', category: 'Pengumuman', date: '16 Desember 2025', excerpt: 'Pendaftaran kegiatan ekstrakurikuler untuk semester genap sudah dibuka. Segera daftarkan diri Anda!', color: 'from-violet-500 to-purple-500'},
                    {title: 'Olimpiade Matematika Tingkat Kabupaten', category: 'Akademik', date: '15 Desember 2025', excerpt: 'Siswa SMAN 2 KAUR berhasil meraih medali perak dalam Olimpiade Matematika tingkat kabupaten.', color: 'from-blue-500 to-cyan-500'},
                    {title: 'Kegiatan Bakti Sosial di Desa Binaan', category: 'Kegiatan', date: '14 Desember 2025', excerpt: 'Siswa dan guru melaksanakan kegiatan bakti sosial di desa binaan sebagai bentuk kepedulian sosial.', color: 'from-indigo-500 to-purple-500'},
                    {title: 'Pengumuman Libur Akhir Tahun', category: 'Pengumuman', date: '13 Desember 2025', excerpt: 'Informasi jadwal libur akhir tahun 2025 dan awal tahun ajaran baru 2026.', color: 'from-amber-500 to-orange-500'},
                ],
                get filteredNews() {
                    if (this.activeFilter === 'Semua') return this.news;
                    return this.news.filter(item => item.category === this.activeFilter);
                },
                get totalPages() {
                    return Math.ceil(this.filteredNews.length / this.itemsPerPage);
                },
                get paginatedNews() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    return this.filteredNews.slice(start, start + this.itemsPerPage);
                },
                setFilter(filter) {
                    this.activeFilter = filter;
                    this.currentPage = 1;
                },
                getBadgeClass(category) {
                    if (category === 'Akademik') return 'badge-success';
                    if (category === 'Pengumuman') return 'badge-warning';
                    return 'badge-primary';
                }
            }">
        <div class="container-custom">
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button @click="setFilter('Semua')"
                    :class="activeFilter === 'Semua' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-semibold transition-all duration-300">
                    Semua
                </button>
                <button @click="setFilter('Akademik')"
                    :class="activeFilter === 'Akademik' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Akademik
                </button>
                <button @click="setFilter('Kegiatan')"
                    :class="activeFilter === 'Kegiatan' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Kegiatan
                </button>
                <button @click="setFilter('Pengumuman')"
                    :class="activeFilter === 'Pengumuman' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Pengumuman
                </button>
                <button @click="setFilter('Prestasi')"
                    :class="activeFilter === 'Prestasi' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Prestasi
                </button>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <template x-for="(item, index) in paginatedNews" :key="index">
                    <article class="glass-card overflow-hidden group" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        <div class="aspect-video relative" :class="'bg-gradient-to-br ' + item.color">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent"></div>
                            <span class="absolute top-4 left-4 badge" :class="getBadgeClass(item.category)"
                                x-text="item.category"></span>
                        </div>
                        <div class="p-6">
                            <time class="text-sm text-slate-500 dark:text-slate-400" x-text="item.date"></time>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white mt-2 mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2"
                                x-text="item.title"></h3>
                            <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-2" x-text="item.excerpt"></p>
                            <a href="#"
                                class="inline-flex items-center mt-4 text-blue-600 dark:text-blue-400 font-semibold text-sm hover:text-blue-700 transition-colors group/link">
                                Baca selengkapnya
                                <svg class="w-4 h-4 ml-1 group-hover/link:translate-x-1 transition-transform" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </article>
                </template>
            </div>

            <!-- No results message -->
            <div x-show="filteredNews.length === 0" class="text-center py-12">
                <p class="text-slate-500 dark:text-slate-400">Tidak ada berita untuk kategori ini.</p>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center mt-12" x-show="totalPages > 1">
                <nav class="inline-flex gap-2">
                    <!-- Previous button -->
                    <button @click="currentPage > 1 && currentPage--"
                        :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:border-blue-500'"
                        class="w-10 h-10 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>

                    <!-- Page numbers -->
                    <template x-for="page in totalPages" :key="page">
                        <button @click="currentPage = page"
                            :class="currentPage === page ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                            class="w-10 h-10 rounded-lg font-semibold transition-all duration-300" x-text="page">
                        </button>
                    </template>

                    <!-- Next button -->
                    <button @click="currentPage < totalPages && currentPage++"
                        :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed' : 'hover:border-blue-500'"
                        class="w-10 h-10 rounded-lg bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </section>
@endsection