@extends('layouts.app')

@section('title', 'Kontak')
@section('meta_description', 'Hubungi SMAN 2 KAUR - Alamat, telepon, email, dan formulir kontak')

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
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Hubungi Kami
            </span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 animate-fade-in animate-delay-100">
                Kontak & <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-400">Lokasi</span>
            </h1>
            <p class="text-lg text-blue-100/80 max-w-2xl mx-auto animate-fade-in animate-delay-200">
                Kami siap membantu Anda. Jangan ragu untuk menghubungi kami
            </p>
        </div>
    </section>

    <section class="section bg-white dark:bg-slate-900 transition-colors">
        <div class="container-custom">
            <div class="grid lg:grid-cols-3 gap-8 mb-16">
                <div class="glass-card p-8 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Alamat</h3>
                    <p class="text-slate-600 dark:text-slate-400">
                        Tanjung Kemuning III<br>
                        Kec. Tanjung Kemuning, Kab. Kaur<br>
                        Bengkulu 38955, Indonesia
                    </p>
                </div>

                <div class="glass-card p-8 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-cyan-500 to-blue-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Telepon</h3>
                    <p class="text-slate-600 dark:text-slate-400">
                        (0739) 123-4567<br>
                        Senin - Jumat: 07:00 - 15:00<br>
                        Sabtu: 07:00 - 12:00
                    </p>
                </div>

                <div class="glass-card p-8 text-center group">
                    <div
                        class="w-16 h-16 mx-auto bg-gradient-to-br from-indigo-500 to-purple-500 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Email</h3>
                    <p class="text-slate-600 dark:text-slate-400">
                        info@sman2kaur.sch.id<br>
                        humas@sman2kaur.sch.id
                    </p>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-extrabold gradient-text mb-6">Kirim Pesan</h2>
                    <p class="text-slate-600 dark:text-slate-400 mb-8">
                        Ada pertanyaan atau butuh informasi lebih lanjut? Silakan isi formulir berikut dan kami akan segera
                        menghubungi Anda.
                    </p>

                    <form class="space-y-6" action="{{ url('/kontak') }}" method="POST">
                        @csrf
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Nama
                                    Lengkap</label>
                                <input type="text" name="name" required class="input" placeholder="Masukkan nama Anda">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Email</label>
                                <input type="email" name="email" required class="input" placeholder="email@contoh.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Subjek</label>
                            <select name="subject" required class="input">
                                <option value="">Pilih subjek pesan</option>
                                <option value="informasi">Informasi Umum</option>
                                <option value="pendaftaran">Pendaftaran Siswa Baru</option>
                                <option value="akademik">Pertanyaan Akademik</option>
                                <option value="kerjasama">Kerjasama</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-900 dark:text-white mb-2">Pesan</label>
                            <textarea name="message" rows="5" required class="input resize-none"
                                placeholder="Tulis pesan Anda..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-full py-4">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                <div>
                    <h2 class="text-3xl font-extrabold gradient-text mb-6">Lokasi Kami</h2>
                    <div class="glass-card overflow-hidden h-[400px] lg:h-[500px] relative group">
                        <iframe
                            src="https://maps.google.com/maps?width=600&height=400&hl=en&q=SMAN%2002%20KAUR&t=k&z=19&ie=UTF8&iwloc=B&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            class="absolute inset-0 w-full h-full grayscale hover:grayscale-0 transition-all duration-500">
                        </iframe>

                        {{-- Overlay Info --}}
                        <div
                            class="absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-white/90 via-white/80 to-transparent dark:from-slate-900/90 dark:via-slate-900/80 pointer-events-none group-hover:opacity-0 transition-opacity duration-300">
                            <div
                                class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md p-4 rounded-2xl shadow-lg border border-white/20">
                                <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1">SMAN 2 KAUR</h3>
                                <p class="text-slate-600 dark:text-slate-400 text-sm mb-3">Tanjung Kemuning III, Tanjung
                                    Kemuning, Kaur Regency, Bengkulu 38955, Indonesia</p>
                                <a href="https://maps.app.goo.gl/eRTQ9e8JvSoMQZJw7" target="_blank"
                                    class="inline-flex items-center text-sm font-semibold text-blue-600 dark:text-blue-400 pointer-events-auto hover:underline">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Buka di Google Maps
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section bg-slate-50 dark:bg-slate-800 transition-colors">
        <div class="container-custom">
            <div class="section-header">
                <h2 class="section-title">Ikuti Kami</h2>
                <p class="section-subtitle">Terhubung dengan kami di media sosial</p>
            </div>

            <div class="flex flex-wrap justify-center gap-6">
                <a href="#" class="glass-card p-6 flex items-center gap-4 group hover:scale-105 transition-transform">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 dark:text-white">Facebook</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400">@sman2kaur</div>
                    </div>
                </a>

                <a href="#" class="glass-card p-6 flex items-center gap-4 group hover:scale-105 transition-transform">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 dark:text-white">Instagram</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400">@sman2kaur.official</div>
                    </div>
                </a>

                <a href="#" class="glass-card p-6 flex items-center gap-4 group hover:scale-105 transition-transform">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-slate-900 dark:text-white">YouTube</div>
                        <div class="text-sm text-slate-600 dark:text-slate-400">SMAN 2 KAUR Channel</div>
                    </div>
                </a>
            </div>
        </div>
    </section>
@endsection