<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login') - E-Learning MAN Bengkulu Selatan</title>
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
        [x-cloak] {
            display: none !important;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .dark .glass-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .glossy-overlay {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0) 50%);
        }

        .input-glass {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 2.75rem;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(34, 197, 94, 0.2);
            border-radius: 0.75rem;
            color: #0f172a;
            font-size: 0.9375rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-glass::placeholder {
            color: #94a3b8;
        }

        .input-glass:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(34, 197, 94, 0.5);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1), 0 4px 24px rgba(34, 197, 94, 0.15);
        }

        .dark .input-glass {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(34, 197, 94, 0.15);
            color: #f8fafc;
        }

        .dark .input-glass::placeholder {
            color: rgba(203, 213, 225, 0.6);
        }

        .dark .input-glass:focus {
            background: rgba(30, 41, 59, 0.9);
            border-color: rgba(34, 197, 94, 0.5);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15), 0 4px 24px rgba(34, 197, 94, 0.1);
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(3deg);
            }
        }

        @keyframes float-reverse {

            0%,
            100% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(20px) rotate(-3deg);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
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

        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
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
            animation: slide-up 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-delay-100 {
            animation-delay: 0.1s;
            opacity: 0;
        }

        .animate-delay-200 {
            animation-delay: 0.2s;
            opacity: 0;
        }

        .animate-delay-300 {
            animation-delay: 0.3s;
            opacity: 0;
        }
    </style>
</head>

<body
    class="min-h-screen bg-gradient-to-br from-slate-50 via-emerald-50/50 to-white dark:from-slate-900 dark:via-slate-900 dark:to-emerald-950/30 transition-colors duration-500">
    <div class="fixed top-4 right-4 z-50" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }">
        <button
            @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark', darkMode)"
            class="p-2.5 rounded-xl bg-white/80 dark:bg-slate-800/80 backdrop-blur-lg border border-emerald-100 dark:border-emerald-900/30 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
            <svg x-show="!darkMode" class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                    clip-rule="evenodd" />
            </svg>
            <svg x-show="darkMode" x-cloak class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
            </svg>
        </button>
    </div>

    <main
        class="relative min-h-screen flex items-center justify-center py-8 sm:py-12 px-4 sm:px-6 lg:px-8 overflow-hidden">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute top-1/4 -left-20 w-48 sm:w-80 h-48 sm:h-80 bg-gradient-to-br from-emerald-400/30 to-green-400/20 rounded-full blur-3xl animate-float">
            </div>
            <div
                class="absolute bottom-1/4 -right-20 w-56 sm:w-96 h-56 sm:h-96 bg-gradient-to-br from-emerald-500/20 to-teal-400/15 rounded-full blur-3xl animate-float-reverse">
            </div>
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] sm:w-[650px] h-[350px] sm:h-[650px] bg-gradient-to-br from-emerald-400/10 to-green-500/10 rounded-full blur-3xl animate-pulse-glow">
            </div>
            <div class="hidden sm:block absolute top-24 right-1/4 w-24 h-24 bg-gradient-to-br from-emerald-500/40 to-green-500/30 rounded-2xl blur-xl animate-float"
                style="animation-delay: 1s;"></div>
            <div class="hidden sm:block absolute bottom-36 left-1/4 w-20 h-20 bg-gradient-to-br from-teal-500/40 to-emerald-500/30 rounded-full blur-xl animate-float-reverse"
                style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">
            <div class="text-center mb-6 sm:mb-8 animate-slide-up">
                <div class="inline-flex items-center justify-center mb-4 sm:mb-6 group">
                    <div class="relative">
                        <div
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 p-0.5 shadow-xl shadow-emerald-500/30 group-hover:shadow-emerald-500/50 transition-all duration-500 group-hover:scale-105">
                            <div
                                class="w-full h-full rounded-2xl bg-white dark:bg-slate-900 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo MAN Bengkulu Selatan" width="80"
                                    height="80" class="w-12 h-12 sm:w-14 sm:h-14 object-contain" loading="eager">
                            </div>
                        </div>
                        <div
                            class="absolute -inset-3 bg-gradient-to-r from-emerald-500/20 to-green-500/20 rounded-3xl blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                        </div>
                    </div>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-slate-800 dark:text-white">
                    @yield('header', 'E-Learning')
                </h1>
                <p
                    class="mt-2 text-sm sm:text-base font-medium bg-gradient-to-r from-emerald-600 to-green-600 dark:from-emerald-400 dark:to-green-400 bg-clip-text text-transparent">
                    MAN BENGKULU SELATAN
                </p>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    @yield('subheader', 'Sistem Pembelajaran Digital')
                </p>
            </div>

            <div
                class="glass-card rounded-2xl sm:rounded-3xl shadow-2xl shadow-emerald-500/10 p-6 sm:p-8 animate-slide-up animate-delay-100 relative overflow-hidden">
                <div class="glossy-overlay absolute inset-0 rounded-2xl sm:rounded-3xl pointer-events-none"></div>
                <div class="relative z-10">
                    @yield('content')
                </div>
            </div>

            @hasSection('footer')
                <div class="mt-6 text-center animate-slide-up animate-delay-200">
                    @yield('footer')
                </div>
            @endif

            <div class="mt-6 text-center animate-slide-up animate-delay-300">
                <p class="text-xs text-slate-500 dark:text-slate-500">
                    &copy; {{ date('Y') }} MAN Bengkulu Selatan. All rights reserved.
                </p>
            </div>
        </div>
    </main>
</body>

</html>