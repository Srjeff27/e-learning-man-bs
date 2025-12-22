<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SMAN 2 KAUR') - Sistem Informasi Sekolah</title>
    <meta name="description"
        content="@yield('meta_description', 'Website resmi SMAN 2 KAUR - Sistem Informasi & Pembelajaran Online')">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-sman2.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')

    <!-- Dark Mode Script - Must be in head to prevent flash -->
    <script>
        (function () {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'true' || (!darkMode && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>

<body class="min-h-screen flex flex-col bg-white dark:bg-slate-900 transition-colors duration-300">
    <!-- Navigation -->
    @include('partials.navbar')

    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Floating Chatbot Button -->
    <!-- Floating Chatbot Wrapper -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end pointer-events-none">
        <!-- Animated Speech Bubble -->
        <div class="bg-white dark:bg-slate-800 text-slate-800 dark:text-white px-4 py-3 rounded-2xl rounded-br-none shadow-xl border border-blue-500 mb-3 mr-2 animate-bounce-subtle max-w-[200px] text-sm font-medium relative pointer-events-auto origin-bottom-right transition-all duration-300"
             x-data="{ show: true }"
             x-init="setTimeout(() => { show = true }, 1000)"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90 translate-y-4"
             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
             style="animation: float 3s ease-in-out infinite;">
            Kalo ada yang bingung tanya BINU ya! 👋
            
            <!-- Triangle -->
            <div class="absolute -bottom-2 right-4 w-4 h-4 bg-white dark:bg-slate-800 border-r border-b border-blue-500 transform rotate-45"></div>
        </div>

        <!-- Button -->
        <a href="{{ route('chatbot.index') }}"
            class="bg-white text-white rounded-full p-1 shadow-lg hover:shadow-xl hover:scale-110 transition-all duration-300 group border-2 border-green-500 w-16 h-16 flex items-center justify-center overflow-hidden pointer-events-auto relative"
            title="Chat dengan BINU">
            <img src="{{ asset('images/icon-chatbot.png') }}" alt="BINU" class="w-full h-full object-cover animate-pulse-slow">
            
            <!-- Notification Dot -->
            <span class="absolute top-1 right-1 w-3 h-3 bg-red-500 rounded-full animate-ping"></span>
            <span class="absolute top-1 right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
        </a>
    </div>

    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>

    @stack('scripts')
</body>

</html>