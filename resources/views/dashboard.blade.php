@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <section class="section">
        <div class="container-custom">
            <div class="max-w-4xl mx-auto">
                <div class="card p-8">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h1 class="text-3xl font-bold text-slate-900 mb-2">Selamat Datang, {{ Auth::user()->name }}!</h1>
                        <p class="text-gray-600">Anda berhasil masuk ke sistem pembelajaran online SMAN 2 KAUR</p>
                    </div>

                    <div class="grid md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-slate-50 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold text-slate-900">0</div>
                            <div class="text-sm text-gray-600">Kelas Aktif</div>
                        </div>
                        <div class="bg-green-50 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold text-green-600">0</div>
                            <div class="text-sm text-gray-600">Tugas Selesai</div>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-6 text-center">
                            <div class="text-3xl font-bold text-orange-600">0</div>
                            <div class="text-sm text-gray-600">Tugas Pending</div>
                        </div>
                    </div>

                    <div class="border-t pt-6">
                        <h2 class="font-semibold text-slate-900 mb-4">Aksi Cepat</h2>
                        <div class="flex flex-wrap gap-3">
                            <a href="#" class="btn btn-secondary text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Gabung Kelas
                            </a>
                            <a href="#" class="btn btn-secondary text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                Lihat Materi
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-secondary text-sm text-red-600 hover:bg-red-50">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center text-sm text-gray-500">
                    <p>Fitur LMS (Kelas Online) akan segera tersedia. Terima kasih atas kesabaran Anda.</p>
                </div>
            </div>
        </div>
    </section>
@endsection