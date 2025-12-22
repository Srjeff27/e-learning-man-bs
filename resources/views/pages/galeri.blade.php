@extends('layouts.app')

@section('title', 'Galeri')
@section('meta_description', 'Galeri foto dan video kegiatan SMAN 2 KAUR')

@section('content')
    <section class="relative hero-gradient py-24 lg:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 right-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-float"></div>
            <div
                class="absolute bottom-10 left-10 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl animate-float animate-delay-300">
            </div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <span
                class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-blue-200 text-sm font-medium mb-6 animate-fade-in">
                <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Momen Berharga
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Foto</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Dokumentasi kegiatan dan momen berharga di SMAN 2 KAUR
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors" x-data="{ 
                activeFilter: 'Semua',
                visibleCount: 8,
                galleries: [
                    {title: 'Upacara Bendera', category: 'Kegiatan', color: 'from-blue-500 to-cyan-500'},
                    {title: 'Kegiatan Belajar', category: 'Akademik', color: 'from-indigo-500 to-purple-500'},
                    {title: 'Lomba Olahraga', category: 'Olahraga', color: 'from-emerald-500 to-teal-500'},
                    {title: 'Pentas Seni', category: 'Kesenian', color: 'from-rose-500 to-pink-500'},
                    {title: 'Praktikum IPA', category: 'Akademik', color: 'from-amber-500 to-orange-500'},
                    {title: 'Ekstrakurikuler', category: 'Kegiatan', color: 'from-violet-500 to-purple-500'},
                    {title: 'Wisuda', category: 'Kegiatan', color: 'from-cyan-500 to-blue-500'},
                    {title: 'Study Tour', category: 'Kegiatan', color: 'from-pink-500 to-rose-500'},
                    {title: 'Kompetisi Akademik', category: 'Akademik', color: 'from-teal-500 to-cyan-500'},
                    {title: 'Kegiatan OSIS', category: 'Kegiatan', color: 'from-orange-500 to-amber-500'},
                    {title: 'Pramuka', category: 'Kegiatan', color: 'from-purple-500 to-indigo-500'},
                    {title: 'Kegiatan Sosial', category: 'Kegiatan', color: 'from-blue-600 to-indigo-600'},
                    {title: 'Pertandingan Futsal', category: 'Olahraga', color: 'from-green-500 to-emerald-500'},
                    {title: 'Latihan Basket', category: 'Olahraga', color: 'from-orange-600 to-red-500'},
                    {title: 'Penampilan Tari', category: 'Kesenian', color: 'from-fuchsia-500 to-pink-500'},
                    {title: 'Paduan Suara', category: 'Kesenian', color: 'from-sky-500 to-blue-500'},
                ],
                get filteredGalleries() {
                    if (this.activeFilter === 'Semua') return this.galleries;
                    return this.galleries.filter(item => item.category === this.activeFilter);
                },
                get visibleGalleries() {
                    return this.filteredGalleries.slice(0, this.visibleCount);
                },
                get hasMore() {
                    return this.visibleCount < this.filteredGalleries.length;
                },
                setFilter(filter) {
                    this.activeFilter = filter;
                    this.visibleCount = 8;
                },
                loadMore() {
                    this.visibleCount += 4;
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
                <button @click="setFilter('Olahraga')"
                    :class="activeFilter === 'Olahraga' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Olahraga
                </button>
                <button @click="setFilter('Kesenian')"
                    :class="activeFilter === 'Kesenian' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Kesenian
                </button>
                <button @click="setFilter('Kegiatan')"
                    :class="activeFilter === 'Kegiatan' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500'"
                    class="px-6 py-3 rounded-xl font-medium transition-all duration-300">
                    Kegiatan
                </button>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template x-for="(item, index) in visibleGalleries" :key="index">
                    <div class="group relative aspect-square rounded-2xl overflow-hidden cursor-pointer"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">
                        <div class="absolute inset-0" :class="'bg-gradient-to-br ' + item.color"></div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div
                            class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div
                                class="w-14 h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                </svg>
                            </div>
                        </div>
                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                            <h3 class="text-white font-semibold" x-text="item.title"></h3>
                            <span class="text-white/70 text-sm" x-text="item.category"></span>
                        </div>
                        <div
                            class="absolute inset-0 border-2 border-transparent group-hover:border-white/30 rounded-2xl transition-colors duration-300">
                        </div>
                    </div>
                </template>
            </div>

            <!-- No results message -->
            <div x-show="filteredGalleries.length === 0" class="text-center py-12">
                <p class="text-slate-500 dark:text-slate-400">Tidak ada foto untuk kategori ini.</p>
            </div>

            <div class="text-center mt-12" x-show="hasMore">
                <button @click="loadMore()" class="btn btn-secondary px-8 py-4 inline-flex items-center">
                    Muat Lebih Banyak
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <section class="section bg-slate-50 dark:bg-slate-800 transition-colors">
        <div class="container-custom">
            <div class="section-header">
                <h2 class="section-title">Video Kegiatan</h2>
                <p class="section-subtitle">Dokumentasi video dari berbagai kegiatan sekolah</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $videos = [
                        ['title' => 'Profile SMAN 2 KAUR 2025', 'duration' => '5:30', 'color' => 'from-blue-500 to-cyan-500'],
                        ['title' => 'Peringatan HUT RI ke-80', 'duration' => '12:45', 'color' => 'from-red-500 to-rose-500'],
                        ['title' => 'Wisuda Kelas XII', 'duration' => '8:20', 'color' => 'from-indigo-500 to-purple-500'],
                    ];
                @endphp

                @foreach($videos as $video)
                    <div class="glass-card overflow-hidden group cursor-pointer">
                        <div class="aspect-video bg-gradient-to-br {{ $video['color'] }} relative">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div
                                    class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8 5v14l11-7z" />
                                    </svg>
                                </div>
                            </div>
                            <span
                                class="absolute bottom-4 right-4 px-2 py-1 rounded bg-black/50 text-white text-sm font-medium">
                                {{ $video['duration'] }}
                            </span>
                        </div>
                        <div class="p-6">
                            <h3
                                class="font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                {{ $video['title'] }}
                            </h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection