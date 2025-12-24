@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->excerpt ?? Str::limit(strip_tags($article->content), 160))

@section('content')
    <article class="py-8 sm:py-12 bg-white dark:bg-slate-900">
        <div class="container-custom px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-4 sm:mb-8">
                    <ol
                        class="flex items-center space-x-1.5 sm:space-x-2 text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
                        <li><span>/</span></li>
                        <li><a href="{{ route('berita') }}" class="hover:text-blue-600">Berita</a></li>
                        <li><span>/</span></li>
                        <li class="text-slate-900 dark:text-white truncate max-w-[120px] sm:max-w-xs">{{ $article->title }}
                        </li>
                    </ol>
                </nav>

                <!-- Category & Date -->
                <div class="flex flex-wrap items-center gap-2 sm:gap-4 mb-4 sm:mb-6">
                    @if($article->category)
                        <span class="badge text-[10px] sm:text-xs
                                    @if($article->category === 'Akademik') badge-success
                                    @elseif($article->category === 'Pengumuman') badge-warning
                                    @else badge-primary @endif">
                            {{ $article->category }}
                        </span>
                    @endif
                    <time class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                        {{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}
                    </time>
                    <span class="text-slate-400 dark:text-slate-500 hidden sm:inline">•</span>
                    <span
                        class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 hidden sm:inline">{{ $article->views ?? 0 }}
                        views</span>
                </div>

                <!-- Title -->
                <h1
                    class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-extrabold text-slate-900 dark:text-white mb-4 sm:mb-8 leading-tight">
                    {{ $article->title }}
                </h1>

                <!-- Featured Image -->
                @if($article->featured_image)
                    <div class="aspect-video rounded-xl sm:rounded-2xl overflow-hidden mb-6 sm:mb-10">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Content -->
                <div class="prose prose-sm sm:prose-base lg:prose-lg dark:prose-invert max-w-none mb-8 sm:mb-12">
                    {!! $article->content !!}
                </div>

                <!-- Author Info -->
                @if($article->author)
                    <div
                        class="flex items-center gap-3 sm:gap-4 p-4 sm:p-6 rounded-lg sm:rounded-xl bg-slate-50 dark:bg-slate-800 mb-8 sm:mb-12">
                        <div
                            class="w-10 h-10 sm:w-14 sm:h-14 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold text-base sm:text-xl flex-shrink-0">
                            {{ substr($article->author->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm sm:text-base font-semibold text-slate-900 dark:text-white">
                                {{ $article->author->name }}</p>
                            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Penulis</p>
                        </div>
                    </div>
                @endif

                <!-- Back Button -->
                <a href="{{ route('berita') }}"
                    class="inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold text-sm sm:text-base hover:text-blue-700 transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                    </svg>
                    Kembali ke Berita
                </a>
            </div>
        </div>
    </article>

    <!-- Related News -->
    @if($relatedNews->count() > 0)
        <section class="py-8 sm:py-12 bg-slate-50 dark:bg-slate-800">
            <div class="container-custom px-4">
                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-slate-900 dark:text-white mb-4 sm:mb-8">Berita Terkait
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6">
                    @foreach($relatedNews as $related)
                        <a href="{{ route('berita.show', $related->slug) }}" class="glass-card overflow-hidden group">
                            <div class="aspect-video relative overflow-hidden">
                                @if($related->featured_image)
                                    <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-500 to-cyan-500"></div>
                                @endif
                            </div>
                            <div class="p-3 sm:p-4">
                                <h3
                                    class="text-sm sm:text-base font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $related->title }}
                                </h3>
                                <time class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1 sm:mt-2 block">
                                    {{ $related->published_at ? $related->published_at->format('d M Y') : $related->created_at->format('d M Y') }}
                                </time>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection