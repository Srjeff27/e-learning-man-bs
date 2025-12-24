@extends('layouts.app')

@section('title', 'Galeri')
@section('meta_description', 'Galeri foto dan video kegiatan SMAN 2 KAUR')

@section('content')
    <section class="relative hero-gradient py-16 sm:py-20 lg:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 right-20 w-40 sm:w-72 h-40 sm:h-72 bg-blue-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-32 sm:w-64 h-32 sm:h-64 bg-cyan-500/20 rounded-full blur-3xl"></div>
        </div>

        <div class="container-custom relative z-10 text-center px-4">
            <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-blue-200 text-xs sm:text-sm font-medium mb-4 sm:mb-6">
                <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Momen Berharga
            </span>
            <h1 class="text-2xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-4 sm:mb-6">
                Galeri <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Foto</span>
            </h1>
            <p class="text-sm sm:text-lg text-blue-100/80 max-w-2xl mx-auto px-2">
                Dokumentasi kegiatan SMAN 2 KAUR
            </p>
        </div>
    </section>

    <!-- Photos Section -->
    <section class="py-12 sm:py-16 lg:py-20 bg-white dark:bg-slate-900 transition-colors" x-data="{ 
            activeFilter: 'Semua',
            lightboxOpen: false,
            lightboxImage: '',
            lightboxTitle: '',
            lightboxCategory: '',
            openLightbox(image, title, category) {
                this.lightboxImage = image;
                this.lightboxTitle = title;
                this.lightboxCategory = category;
                this.lightboxOpen = true;
                document.body.style.overflow = 'hidden';
            },
            closeLightbox() {
                this.lightboxOpen = false;
                document.body.style.overflow = '';
            }
        }" @keydown.escape.window="closeLightbox()">
        <div class="container-custom px-4">
            <!-- Filter Buttons -->
            @if($categories->count() > 0)
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-8 sm:mb-12">
                    <button @click="activeFilter = 'Semua'"
                        :class="activeFilter === 'Semua' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700'"
                        class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-semibold transition-all">
                        Semua
                    </button>
                    @foreach($categories as $category)
                        <button @click="activeFilter = '{{ $category }}'"
                            :class="activeFilter === '{{ $category }}' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700'"
                            class="px-4 sm:px-6 py-2 sm:py-3 rounded-lg sm:rounded-xl text-sm sm:text-base font-medium transition-all">
                            {{ $category }}
                        </button>
                    @endforeach
                </div>
            @endif

            <!-- Photos Grid -->
            @if($photos->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-4">
                    @foreach($photos as $photo)
                        <div x-show="activeFilter === 'Semua' || activeFilter === '{{ $photo->category }}'"
                            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            @click="openLightbox('{{ $photo->file_path ? Storage::url($photo->file_path) : '' }}', '{{ addslashes($photo->title) }}', '{{ $photo->category }}')"
                            class="group relative aspect-square rounded-lg sm:rounded-2xl overflow-hidden cursor-pointer">
                            @if($photo->file_path)
                                <img src="{{ Storage::url($photo->file_path) }}" alt="{{ $photo->title }}" loading="lazy"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-500 to-cyan-500"></div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30">
                                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 p-2 sm:p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                <h3 class="text-white font-semibold text-xs sm:text-base line-clamp-1">{{ $photo->title }}</h3>
                                @if($photo->category)
                                    <span class="text-white/70 text-[10px] sm:text-sm">{{ $photo->category }}</span>
                                @endif
                            </div>
                            @if($photo->is_featured)
                                <span class="absolute top-2 right-2 sm:top-3 sm:right-3 px-1.5 sm:px-2 py-0.5 sm:py-1 bg-amber-500 text-white text-[10px] sm:text-xs font-semibold rounded-lg">Featured</span>
                            @endif
                            <div class="absolute inset-0 border-2 border-transparent group-hover:border-white/30 rounded-lg sm:rounded-2xl transition-colors duration-300"></div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 sm:py-12">
                    <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-slate-300 dark:text-slate-600 mb-3 sm:mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400">Belum ada foto.</p>
                </div>
            @endif
        </div>

        <!-- Lightbox Modal -->
        <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-sm"
            @click.self="closeLightbox()">

            <!-- Close Button -->
            <button @click="closeLightbox()"
                class="absolute top-4 right-4 w-12 h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors z-10">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Image Container -->
            <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300 delay-100"
                x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                class="relative max-w-5xl max-h-[85vh] w-full">

                <!-- Image -->
                <img :src="lightboxImage" :alt="lightboxTitle"
                    class="w-full h-full max-h-[75vh] object-contain rounded-xl shadow-2xl">

                <!-- Caption -->
                <div class="mt-4 text-center" x-show="lightboxTitle">
                    <h3 class="text-xl font-bold text-white" x-text="lightboxTitle"></h3>
                    <p class="text-white/60 text-sm mt-1" x-text="lightboxCategory"></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Videos Section -->
    @if($videos->count() > 0)
        <section class="py-12 sm:py-16 lg:py-20 bg-slate-50 dark:bg-slate-800 transition-colors">
            <div class="container-custom px-4">
                <div class="text-center mb-8 sm:mb-12">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-slate-900 dark:text-white mb-2 sm:mb-3">Video Kegiatan</h2>
                    <p class="text-xs sm:text-sm md:text-base text-slate-600 dark:text-slate-400">Dokumentasi video kegiatan sekolah</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                    @foreach($videos as $video)
                        <div class="glass-card overflow-hidden group cursor-pointer">
                            <div class="aspect-video relative overflow-hidden">
                                @if($video->thumbnail)
                                    <img src="{{ Storage::url($video->thumbnail) }}" alt="{{ $video->title }}" loading="lazy"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-indigo-500 to-purple-500"></div>
                                @endif
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center border border-white/30 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white ml-0.5 sm:ml-1" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </div>
                                </div>
                                @if($video->is_featured)
                                    <span class="absolute top-2 right-2 sm:top-3 sm:right-3 px-1.5 sm:px-2 py-0.5 sm:py-1 bg-amber-500 text-white text-[10px] sm:text-xs font-semibold rounded-lg">Featured</span>
                                @endif
                            </div>
                            <div class="p-4 sm:p-6">
                                <h3 class="text-sm sm:text-base font-bold text-slate-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                    {{ $video->title }}
                                </h3>
                                @if($video->description)
                                    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 mt-1 sm:mt-2 line-clamp-2">{{ $video->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection