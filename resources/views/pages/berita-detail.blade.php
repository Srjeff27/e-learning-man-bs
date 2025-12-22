@extends('layouts.app')

@section('title', $article->title)
@section('meta_description', $article->excerpt ?? Str::limit(strip_tags($article->content), 160))

@section('content')
    <article class="py-12 bg-white dark:bg-slate-900">
        <div class="container-custom">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="mb-8">
                    <ol class="flex items-center space-x-2 text-sm text-slate-500 dark:text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a></li>
                        <li><span>/</span></li>
                        <li><a href="{{ route('berita') }}" class="hover:text-blue-600">Berita</a></li>
                        <li><span>/</span></li>
                        <li class="text-slate-900 dark:text-white truncate max-w-xs">{{ $article->title }}</li>
                    </ol>
                </nav>

                <!-- Category & Date -->
                <div class="flex flex-wrap items-center gap-4 mb-6">
                    @if($article->category)
                        <span class="badge 
                                @if($article->category === 'Akademik') badge-success
                                @elseif($article->category === 'Pengumuman') badge-warning
                                @else badge-primary @endif">
                            {{ $article->category }}
                        </span>
                    @endif
                    <time class="text-slate-500 dark:text-slate-400">
                        {{ $article->published_at ? $article->published_at->format('d F Y') : $article->created_at->format('d F Y') }}
                    </time>
                    <span class="text-slate-400 dark:text-slate-500">•</span>
                    <span class="text-slate-500 dark:text-slate-400">{{ $article->views ?? 0 }} views</span>
                </div>

                <!-- Title -->
                <h1
                    class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white mb-8 leading-tight">
                    {{ $article->title }}
                </h1>

                <!-- Featured Image -->
                @if($article->featured_image)
                    <div class="aspect-video rounded-2xl overflow-hidden mb-10">
                        <img src="{{ Storage::url($article->featured_image) }}" alt="{{ $article->title }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Content -->
                <div class="prose prose-lg dark:prose-invert max-w-none mb-12">
                    {!! $article->content !!}
                </div>

                <!-- Author Info -->
                @if($article->author)
                    <div class="flex items-center gap-4 p-6 rounded-xl bg-slate-50 dark:bg-slate-800 mb-12">
                        <div
                            class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 flex items-center justify-center text-white font-bold text-xl">
                            {{ substr($article->author->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 dark:text-white">{{ $article->author->name }}</p>
                            <p class="text-sm text-slate-500 dark:text-slate-400">Penulis</p>
                        </div>
                    </div>
                @endif

                <!-- Back Button -->
                <a href="{{ route('berita') }}"
                    class="inline-flex items-center text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <section class="py-12 bg-slate-50 dark:bg-slate-800">
            <div class="container-custom">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-8">Berita Terkait</h2>
                <div class="grid md:grid-cols-3 gap-6">
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
                            <div class="p-4">
                                <h3
                                    class="font-semibold text-slate-900 dark:text-white group-hover:text-blue-600 transition-colors line-clamp-2">
                                    {{ $related->title }}
                                </h3>
                                <time class="text-sm text-slate-500 dark:text-slate-400 mt-2 block">
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