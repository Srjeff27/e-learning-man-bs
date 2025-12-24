<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - SMAN 2 KAUR</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        (function () {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'true' || (darkMode === null && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>
    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dark .glass-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glossy-bg {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 50%);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @keyframes float-reverse {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(20px) rotate(-5deg);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 0.4;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
            }
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-reverse {
            animation: float-reverse 8s ease-in-out infinite;
        }

        .animate-pulse-glow {
            animation: pulse-glow 4s ease-in-out infinite;
        }

        .animate-slide-up {
            animation: slide-up 0.6s ease-out forwards;
        }

        .animate-delay-100 {
            animation-delay: 0.1s;
        }

        .animate-delay-200 {
            animation-delay: 0.2s;
        }

        .animate-delay-300 {
            animation-delay: 0.3s;
        }

        .input-modern {
            width: 100%;
            padding: 1rem 1.25rem;
            padding-left: 3rem;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(148, 163, 184, 0.3);
            border-radius: 0.875rem;
            color: #0f172a;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .input-modern::placeholder {
            color: #94a3b8;
        }

        .input-modern:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.9);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), 0 4px 20px rgba(59, 130, 246, 0.1);
        }

        .dark .input-modern {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(148, 163, 184, 0.2);
            color: #f8fafc;
        }

        .dark .input-modern::placeholder {
            color: rgba(203, 213, 225, 0.6);
        }

        .dark .input-modern:focus {
            background: rgba(30, 41, 59, 0.9);
            border-color: rgba(59, 130, 246, 0.5);
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15), 0 4px 20px rgba(59, 130, 246, 0.1);
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-cyan-50 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 transition-colors duration-300">
    @include('partials.navbar')

    <main
        class="relative min-h-screen flex items-center justify-center py-8 sm:py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-1/4 -left-20 w-40 sm:w-72 h-40 sm:h-72 bg-gradient-to-br from-blue-400/30 to-cyan-400/30 rounded-full blur-3xl animate-float">
            </div>
            <div
                class="absolute bottom-1/4 -right-20 w-48 sm:w-96 h-48 sm:h-96 bg-gradient-to-br from-indigo-400/20 to-purple-400/20 rounded-full blur-3xl animate-float-reverse">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] sm:w-[600px] h-[300px] sm:h-[600px] bg-gradient-to-br from-blue-500/10 to-cyan-500/10 rounded-full blur-3xl animate-pulse-glow">
            </div>
            <div class="hidden sm:block absolute top-20 right-1/4 w-20 h-20 bg-gradient-to-br from-blue-500/40 to-cyan-500/40 rounded-2xl blur-xl animate-float"
                style="animation-delay: 1s;"></div>
            <div class="hidden sm:block absolute bottom-32 left-1/4 w-16 h-16 bg-gradient-to-br from-indigo-500/40 to-blue-500/40 rounded-full blur-xl animate-float-reverse"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">
            <div class="text-center mb-6 sm:mb-8 animate-slide-up">
                <a href="{{ url('/') }}" class="inline-flex items-center justify-center mb-4 sm:mb-6 group">
                    <div class="relative">
                        <div
                            class="w-14 h-14 sm:w-20 sm:h-20 rounded-xl sm:rounded-2xl flex items-center justify-center shadow-xl shadow-blue-500/20 group-hover:shadow-blue-500/40 transition-all duration-500 group-hover:scale-105 overflow-hidden">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo SMAN 2 KAUR" width="80" height="80"
                                class="w-full h-full object-contain">
                        </div>
                        <div
                            class="absolute -inset-2 bg-gradient-to-r from-blue-500/20 to-cyan-500/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                    </div>
                </a>
                <h1
                    class="text-2xl sm:text-3xl md:text-4xl font-extrabold bg-gradient-to-r from-slate-900 via-blue-900 to-slate-900 dark:from-white dark:via-blue-200 dark:to-white bg-clip-text text-transparent">
                    @yield('header', 'Selamat Datang')
                </h1>
                <p class="mt-2 sm:mt-3 text-sm sm:text-base text-slate-600 dark:text-slate-400">
                    @yield('subheader', 'Sistem Informasi SMAN 2 KAUR')
                </p>
            </div>

            <div
                class="glass-card rounded-2xl sm:rounded-3xl shadow-2xl shadow-blue-500/10 p-5 sm:p-8 md:p-10 animate-slide-up animate-delay-100">
                <div class="glossy-bg absolute inset-0 rounded-2xl sm:rounded-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    @yield('content')
                </div>
            </div>

            @hasSection('footer')
                <div class="mt-6 sm:mt-8 text-center animate-slide-up animate-delay-200">
                    @yield('footer')
                </div>
            @endif

            <div class="mt-6 sm:mt-8 text-center animate-slide-up animate-delay-300">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center text-xs sm:text-sm text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-300 group">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 group-hover:-translate-x-1 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>

</html>