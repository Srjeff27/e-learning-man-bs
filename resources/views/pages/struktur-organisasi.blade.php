@extends('layouts.app')

@section('title', 'Struktur Organisasi')
@section('meta_description', 'Struktur Organisasi ' . ($profile->name ?? 'SMAN 2 KAUR'))

@section('content')
    <section class="relative hero-gradient py-24 lg:py-32 overflow-hidden">
        <div class="absolute inset-0 opacity-30">
            <div class="absolute top-20 right-20 w-72 h-72 bg-blue-500/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-10 left-10 w-64 h-64 bg-cyan-500/20 rounded-full blur-3xl animate-float animate-delay-300"></div>
        </div>

        <div class="container-custom relative z-10 text-center">
            <span class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-blue-200 text-sm font-medium mb-6 animate-fade-in">
                <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Organisasi
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Struktur <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Organisasi</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Struktur organisasi dan kepemimpinan {{ $profile->name ?? 'SMAN 2 KAUR' }}
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors">
        <div class="container-custom">
            <div class="max-w-5xl mx-auto">
                @php
                    $orgStructure = $profile->organization_structure ?? [];
                    
                    // Filter by type
                    $pimpinan = array_values(array_filter($orgStructure, fn($item) => ($item['type'] ?? 'pimpinan') === 'pimpinan'));
                    $koordinator = array_values(array_filter($orgStructure, fn($item) => ($item['type'] ?? '') === 'koordinator'));
                    
                    // Get Kepala Sekolah from pimpinan (first one)
                    $kepalaSekolah = null;
                    $wakasek = [];
                    foreach ($pimpinan as $person) {
                        if (stripos($person['position'] ?? '', 'Kepala Sekolah') !== false) {
                            $kepalaSekolah = $person;
                        } else {
                            $wakasek[] = $person;
                        }
                    }
                    
                    // If no Kepala Sekolah found but pimpinan has data, use first one as Kepala Sekolah
                    if (!$kepalaSekolah && count($pimpinan) > 0) {
                        $kepalaSekolah = $pimpinan[0];
                        $wakasek = array_slice($pimpinan, 1);
                    }
                @endphp

                <!-- Pimpinan Sekolah Section -->
                @if($kepalaSekolah && !empty($kepalaSekolah['name']))
                <div class="mb-12">
                    <h2 class="text-2xl font-bold gradient-text text-center mb-8">Pimpinan Sekolah</h2>
                    
                    <!-- Kepala Sekolah -->
                    <div class="glass-card p-8 md:p-12 text-center mb-8">
                        <div class="w-32 h-32 mx-auto bg-gradient-to-br from-blue-500 to-cyan-500 rounded-3xl flex items-center justify-center mb-6 shadow-xl overflow-hidden">
                            @if(isset($kepalaSekolah['photo']) && $kepalaSekolah['photo'])
                                <img src="{{ Storage::url($kepalaSekolah['photo']) }}" class="w-full h-full object-cover" alt="{{ $kepalaSekolah['name'] }}">
                            @else
                                <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            @endif
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">{{ $kepalaSekolah['position'] ?? 'Kepala Sekolah' }}</h3>
                        <p class="text-lg text-blue-600 dark:text-blue-400 font-semibold mb-4">{{ $kepalaSekolah['name'] }}</p>
                        @if(!empty($kepalaSekolah['nip']))
                            <p class="text-slate-600 dark:text-slate-400">NIP: {{ $kepalaSekolah['nip'] }}</p>
                        @endif
                    </div>

                    <!-- Wakasek -->
                    @if(count($wakasek) > 0)
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($wakasek as $person)
                            @if(!empty($person['name']))
                            <div class="glass-card p-6 text-center">
                                <div class="w-24 h-24 mx-auto bg-gradient-to-br from-blue-500/20 to-cyan-500/20 rounded-2xl flex items-center justify-center mb-4 overflow-hidden">
                                    @if(isset($person['photo']) && $person['photo'])
                                        <img src="{{ Storage::url($person['photo']) }}" class="w-full h-full object-cover" alt="{{ $person['name'] }}">
                                    @else
                                        <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    @endif
                                </div>
                                <h4 class="text-lg font-bold text-slate-900 dark:text-white mb-2">{{ $person['position'] ?? '' }}</h4>
                                <p class="text-blue-600 dark:text-blue-400 font-semibold mb-1">{{ $person['name'] }}</p>
                                @if(!empty($person['nip']))
                                    <p class="text-sm text-slate-600 dark:text-slate-400">NIP: {{ $person['nip'] }}</p>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

                <!-- Koordinator Bidang Section -->
                @if(count($koordinator) > 0)
                <div class="glass-card p-8 md:p-10">
                    <h3 class="text-2xl font-bold gradient-text text-center mb-8">Koordinator Bidang</h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($koordinator as $person)
                            @if(!empty($person['name']))
                            <div class="text-center p-4 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-500/20 to-teal-500/20 rounded-xl flex items-center justify-center mb-4 overflow-hidden">
                                    @if(isset($person['photo']) && $person['photo'])
                                        <img src="{{ Storage::url($person['photo']) }}" class="w-full h-full object-cover" alt="{{ $person['name'] }}">
                                    @else
                                        <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    @endif
                                </div>
                                <h4 class="font-bold text-slate-900 dark:text-white mb-1">{{ $person['position'] ?? '' }}</h4>
                                <p class="text-emerald-600 dark:text-emerald-400 font-medium">{{ $person['name'] }}</p>
                                @if(!empty($person['nip']))
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">NIP: {{ $person['nip'] }}</p>
                                @endif
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Empty State -->
                @if(empty($kepalaSekolah) && count($koordinator) == 0)
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-300 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-slate-500 dark:text-slate-400">Data struktur organisasi belum tersedia.</p>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection