@extends('layouts.app')

@section('title', 'Visi & Misi')
@section('meta_description', 'Visi dan Misi ' . ($profile->name ?? 'SMAN 2 KAUR') . ' dalam mencetak generasi unggul dan berkarakter')

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
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Landasan Kami
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Visi & <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Misi</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Panduan dan tujuan kami dalam mencetak generasi unggul dan berkarakter
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors">
        <div class="container-custom">
            <div class="max-w-4xl mx-auto">
                <!-- Visi -->
                <div class="glass-card p-10 md:p-14 text-center mb-16 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 gradient-bg"></div>
                    <div
                        class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl flex items-center justify-center mb-8">
                        <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-extrabold gradient-text mb-6">Visi Kami</h2>
                    <p class="text-xl md:text-2xl text-slate-700 dark:text-slate-300 leading-relaxed font-medium">
                        "{{ $profile->vision ?? 'Menjadi lembaga pendidikan unggulan yang menghasilkan generasi beriman, berilmu, berkarakter, dan berdaya saing global.' }}"
                    </p>
                </div>

                <!-- Misi -->
                <div class="mb-16">
                    <div class="text-center mb-12">
                        <div
                            class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-3xl flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-extrabold gradient-text">Misi Kami</h2>
                    </div>

                    <div class="space-y-6">
                        @php
                            $missions = $profile->missions ?? [
                                ['title' => 'Pendidikan Berkualitas', 'description' => 'Menyelenggarakan pendidikan yang berkualitas dengan standar nasional dan internasional.'],
                                ['title' => 'Karakter Mulia', 'description' => 'Mengembangkan karakter siswa yang berakhlak mulia, beriman, dan bertakwa kepada Tuhan Yang Maha Esa.'],
                                ['title' => 'Kreativitas & Inovasi', 'description' => 'Menumbuhkan semangat kreativitas, inovasi, dan jiwa kewirausahaan dalam diri peserta didik.'],
                                ['title' => 'Tenaga Profesional', 'description' => 'Meningkatkan profesionalisme tenaga pendidik dan kependidikan melalui pelatihan berkelanjutan.'],
                                ['title' => 'Kemitraan Strategis', 'description' => 'Membangun kemitraan dengan berbagai pihak untuk pengembangan program pendidikan.']
                            ];
                        @endphp

                        @foreach($missions as $index => $mission)
                            @if(!empty($mission['title']) || !empty($mission['description']))
                                <div class="glass-card p-6 flex items-start gap-6 group hover:scale-[1.02] transition-transform">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center flex-shrink-0 text-white font-bold text-lg shadow-lg">
                                        {{ $index + 1 }}
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 dark:text-white mb-2">{{ $mission['title'] ?? '' }}</h3>
                                        <p class="text-slate-600 dark:text-slate-400">{{ $mission['description'] ?? '' }}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nilai-Nilai Utama -->
    <section class="section bg-slate-50 dark:bg-slate-800 transition-colors">
        <div class="container-custom">
            <div class="section-header">
                <h2 class="section-title">Nilai-Nilai Utama</h2>
                <p class="section-subtitle">Prinsip yang menjadi landasan dalam setiap kegiatan pendidikan</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $values = $profile->values ?? [
                        ['title' => 'Integritas', 'description' => 'Menjunjung tinggi kejujuran dan kebenaran dalam setiap tindakan'],
                        ['title' => 'Inovasi', 'description' => 'Selalu berinovasi dalam metode pembelajaran dan pengembangan'],
                        ['title' => 'Kolaborasi', 'description' => 'Membangun kerjasama yang harmonis antar seluruh elemen'],
                        ['title' => 'Keunggulan', 'description' => 'Berkomitmen untuk mencapai standar tertinggi dalam pendidikan']
                    ];
                    $gradients = [
                        'from-blue-500 to-blue-600',
                        'from-cyan-500 to-cyan-600',
                        'from-indigo-500 to-indigo-600',
                        'from-purple-500 to-purple-600'
                    ];
                    $icons = [
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />',
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />',
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />',
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />'
                    ];
                @endphp

                @foreach($values as $index => $value)
                    @if(!empty($value['title']) || !empty($value['description']))
                        <div class="glass-card p-8 text-center group">
                            <div
                                class="w-16 h-16 mx-auto bg-gradient-to-br {{ $gradients[$index % count($gradients)] }} rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $icons[$index % count($icons)] !!}
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">{{ $value['title'] ?? '' }}</h3>
                            <p class="text-slate-600 dark:text-slate-400 text-sm">{{ $value['description'] ?? '' }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <!-- Motto Section -->
    @if($profile && $profile->motto)
        <section class="section bg-white dark:bg-slate-900 transition-colors">
            <div class="container-custom">
                <div class="max-w-3xl mx-auto text-center">
                    <div class="glass-card p-10 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1 gradient-bg"></div>
                        <svg class="w-12 h-12 mx-auto text-blue-500/30 mb-4" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <p class="text-2xl md:text-3xl font-bold gradient-text">{{ $profile->motto }}</p>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection