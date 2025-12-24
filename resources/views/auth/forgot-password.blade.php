@extends('layouts.guest')

@section('title', 'Lupa Password')
@section('header', 'Reset Password')
@section('subheader', 'Masukkan email untuk menerima link reset')

@section('content')
    @if (session('status'))
        <div
            class="mb-4 sm:mb-5 p-3 sm:p-4 bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-lg sm:rounded-xl text-xs sm:text-sm flex items-center">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4 sm:space-y-5">
        @csrf

        <!-- Email -->
        <div class="space-y-1.5 sm:space-y-2">
            <label for="email"
                class="block text-xs sm:text-sm font-semibold text-slate-700 dark:text-slate-300">Email</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 sm:pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="input-modern text-sm sm:text-base @error('email') !border-red-500 !ring-red-500/50 @enderror"
                    placeholder="nama@email.com" required autofocus>
            </div>
            @error('email')
                <p class="text-xs sm:text-sm text-red-500 dark:text-red-400 flex items-center mt-1">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit"
            class="w-full relative overflow-hidden py-3 sm:py-4 px-4 sm:px-6 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold text-sm sm:text-base rounded-lg sm:rounded-xl shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 transform hover:-translate-y-0.5 transition-all duration-300 group">
            <span class="relative z-10 flex items-center justify-center">
                Kirim Link Reset
                <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-1.5 sm:ml-2 group-hover:translate-x-1 transition-transform duration-300"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </span>
            <div
                class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-700">
            </div>
        </button>
    </form>
@endsection

@section('footer')
    <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
        Ingat password?
        <a href="{{ route('login') }}"
            class="font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:underline transition-colors">
            Masuk di sini
        </a>
    </p>
@endsection