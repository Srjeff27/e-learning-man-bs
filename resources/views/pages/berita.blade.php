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

    <section class="section bg-white dark:bg-slate-900 transition-colors">
        <div class="container-custom">
            <!-- Filter Buttons -->
            @if($categories->count() > 0)
                <div class="flex flex-wrap justify-center gap-3 mb-12">
                    <a href="{{ route('berita') }}"
                        class="px-6 py-3 rounded-xl font-semibold transition-all duration-300 {{ !request('category') || request('category') === 'Semua' ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500' }}">
                        Semua
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('berita', ['category' => $category]) }}"
                            class="px-6 py-3 rounded-xl font-medium transition-all duration-300 {{ request('category') === $category ? 'bg-gradient-to-r from-blue-500 to-cyan-500 text-white shadow-lg' : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:border-blue-500' }}">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- News Grid -->
            @if($news->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($news as $item)
                        <article class="glass-card overflow-hidden group">
                            <div class="aspect-video relative overflow-hidden">
                                @if($item->featured_image)
                                    <img src="{{ Storage::url($item->featured_image) }}" alt="{{ $item->title }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    @php
                                        $colors = ['from-blue-500 to-cyan-500', 'from-indigo-500 to-purple-500', 'from-emerald-500 to-teal-500', 'from-rose-500 to-pink-500', 'from-amber-500 to-orange-500'];
                                        $colorIndex = $loop->index % count($colors);
                                    @endphp
                                    <div class="w-full h-full bg-gradient-to-br {{ $colors[$colorIndex] }}"></div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent"></div>
                                @if($item->category)
                                    <span class="absolute top-4 left-4 badge 
                                            @if($item->category === 'Akademik') badge-success
                                            @elseif($item->category === 'Pengumuman') badge-warning
                                            @else badge-primary @endif">
                                        {{ $item->category }}
                                    </span>
                                @endif
                                @if($item->is_featured)
                                    <span
                                        class="absolute top-4 right-4 px-2 py-1 bg-amber-500 text-white text-xs font-semibold rounded-lg">Featured</span>
                                @endif
                            </div>
                            <div class="p-6">
                                <time class="text-sm text-slate-500 dark:text-slate-400">
                                    {{ $item->published_at ? $item->published_at->format('d F Y') : $item->created_at->format('d F Y') }}
                                </time>
                                <h3
                                    class="text-lg font-bold text-slate-900 dark:text-white mt-2 mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                    {{ $item->title }}
                                </h3>
                                <p class="text-slate-600 dark:text-slate-400 text-sm line-clamp-2">
                                    {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 120) }}
                                </p>
                                <a href="{{ route('berita.show', $item->slug) }}"
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
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-12">
                    {{ $news->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">Belum ada berita yang dipublikasikan.</p>
                </div>
            @endif
        </div>
    </section>
@endsection