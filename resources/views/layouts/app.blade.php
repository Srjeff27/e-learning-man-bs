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

    <!-- BINU Chatbot Popup Widget -->
    <div x-data="binuChat()" x-init="init()" class="fixed bottom-6 right-6 z-50 flex flex-col items-end font-sans">

        <!-- Chat Popup Window -->
        <div x-show="isOpen" style="display: none; height: 550px; max-height: calc(100vh - 120px);"
            x-transition:enter="transition cubic-bezier(0.22, 1, 0.36, 1) duration-500"
            x-transition:enter-start="opacity-0 translate-y-12 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-12 scale-95" @click.outside="isOpen = false"
            class="mb-6 w-[380px] max-w-[calc(100vw-2rem)] bg-white/80 dark:bg-slate-900/80 backdrop-blur-2xl rounded-[2.5rem] shadow-2xl border border-white/40 dark:border-slate-700/50 overflow-hidden flex flex-col relative ring-1 ring-black/5 dark:ring-white/10">

            <!-- Glass Reflection Overlay -->
            <div
                class="absolute inset-0 pointer-events-none z-0 bg-gradient-to-b from-white/20 to-transparent opacity-50">
            </div>

            <!-- Header -->
            <div
                class="relative z-10 bg-gradient-to-r from-blue-600/90 to-cyan-500/90 backdrop-blur-md p-5 flex items-center justify-between border-b border-white/10">
                <div class="absolute inset-0 bg-noise opacity-10"></div>

                <div class="flex items-center gap-4">
                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-white/30 rounded-full blur transition duration-500 group-hover:bg-white/50">
                        </div>
                        <div
                            class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-md p-0.5 border border-white/40 overflow-hidden relative shadow-lg">
                            <img src="{{ asset('images/icon-chatbot-glass.png') }}" alt="BINU"
                                class="w-full h-full object-cover">
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-400 border-2 border-blue-600 rounded-full animate-pulse">
                        </div>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-white text-xl tracking-wide drop-shadow-sm">BINU</h3>
                        <p
                            class="text-blue-50 text-xs font-medium bg-blue-700/30 px-2 py-0.5 rounded-full inline-block backdrop-blur-sm border border-blue-400/30">
                            Asisten Virtual</p>
                    </div>
                </div>
                <button @click="isOpen = false"
                    class="w-9 h-9 rounded-full bg-white/10 hover:bg-white/20 border border-white/20 flex items-center justify-center transition-all duration-300 hover:rotate-90 hover:scale-110 group">
                    <svg class="w-5 h-5 text-white/90 group-hover:text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Messages Area -->
            <div x-ref="messagesContainer"
                class="relative z-10 flex-1 overflow-y-auto p-5 space-y-5 scroll-smooth custom-scrollbar">
                <!-- Welcome Message -->
                <template x-if="messages.length === 0">
                    <div class="text-center py-10 animate-fade-in-up">
                        <div class="relative w-24 h-24 mx-auto mb-6 group cursor-pointer">
                            <div
                                class="absolute inset-0 bg-blue-500/30 rounded-full blur-xl group-hover:blur-2xl transition-all duration-500 animate-pulse-slow">
                            </div>
                            <div
                                class="relative w-full h-full rounded-full bg-gradient-to-br from-white/90 to-blue-50/50 backdrop-blur-sm p-1 border-2 border-white/60 shadow-xl overflow-hidden group-hover:scale-105 transition-transform duration-300">
                                <img src="{{ asset('images/icon-chatbot-glass.png') }}" alt="BINU"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                        <h4 class="font-bold text-2xl text-slate-800 dark:text-white mb-3 tracking-tight">Halo, Saya
                            BINU! 👋</h4>
                        <p
                            class="text-slate-600 dark:text-slate-300 max-w-[260px] mx-auto leading-relaxed text-sm bg-white/50 dark:bg-slate-800/50 px-4 py-2 rounded-2xl border border-white/40 dark:border-slate-700/50 backdrop-blur-sm">
                            Asisten pintar SMAN 2 KAUR. Tanyakan jadwal, nilai, atau info sekolah!
                        </p>
                    </div>
                </template>

                <!-- Chat Messages -->
                <template x-for="(msg, index) in messages" :key="index">
                    <div :class="msg.role === 'user' ? 'flex justify-end' : 'flex justify-start'"
                        class="animate-fade-in-up">
                        <div :class="msg.role === 'user' ? 
                            'bg-gradient-to-br from-blue-600 to-cyan-500 text-white rounded-[1.5rem] rounded-tr-sm shadow-blue-500/20' : 
                            'bg-white dark:bg-slate-800 text-slate-800 dark:text-white rounded-[1.5rem] rounded-tl-sm border border-slate-100 dark:border-slate-700 shadow-slate-200/50 dark:shadow-none'"
                            class="px-5 py-3.5 max-w-[85%] shadow-lg text-sm leading-relaxed relative group transition-all hover:scale-[1.02]">
                            <p class="whitespace-pre-wrap" x-text="msg.content"></p>
                            <!-- Message Timestamp (Optional enhancement) -->
                            <span class="text-[0.65rem] opacity-60 mt-1 block text-right font-medium"
                                x-text="new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})"></span>
                        </div>
                    </div>
                </template>

                <!-- Typing Indicator -->
                <div x-show="isLoading" class="flex justify-start animate-fade-in">
                    <div
                        class="bg-white dark:bg-slate-800 rounded-[1.5rem] rounded-tl-sm px-5 py-4 shadow-md border border-slate-100 dark:border-slate-700 flex items-center gap-1.5">
                        <span class="w-2 h-2 bg-blue-400 rounded-full animate-bounce"
                            style="animation-duration: 0.6s; animation-delay: 0ms"></span>
                        <span class="w-2 h-2 bg-blue-400 rounded-full animate-bounce"
                            style="animation-duration: 0.6s; animation-delay: 150ms"></span>
                        <span class="w-2 h-2 bg-blue-400 rounded-full animate-bounce"
                            style="animation-duration: 0.6s; animation-delay: 300ms"></span>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div
                class="relative z-10 p-4 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl border-t border-slate-200/60 dark:border-slate-700/60">
                <form @submit.prevent="sendMessage" class="flex items-center gap-2 relative">
                    <input type="text" x-model="input" @keydown.enter="sendMessage" :disabled="isLoading"
                        placeholder="Ketik pesan..."
                        class="w-full pl-5 pr-14 py-3.5 rounded-full bg-slate-100/80 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:bg-white dark:focus:bg-slate-900 transition-all text-sm font-medium shadow-inner">

                    <button type="submit" :disabled="isLoading || !input.trim()"
                        class="absolute right-1.5 p-2 rounded-full bg-gradient-to-r from-blue-600 to-cyan-500 text-white shadow-lg hover:shadow-blue-500/40 hover:scale-105 active:scale-95 transition-all disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100">
                        <svg x-show="!isLoading" class="w-5 h-5 translate-x-0.5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M5 12h14M12 5l7 7-7 7" />
                        </svg>
                        <svg x-show="isLoading" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Floating Orb Button -->
        <div class="flex flex-col items-end relative z-50">
            <!-- Speech Bubble -->
            <div x-show="!isOpen && showBubble" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-8 scale-50"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100" @click="isOpen = true; showBubble = false"
                class="group cursor-pointer mb-4 mr-2 relative z-50 animate-float-slow">
                <div
                    class="bg-white dark:bg-slate-800 text-slate-800 dark:text-white px-5 py-3 rounded-2xl rounded-br-none shadow-2xl border border-blue-500/30 flex items-center gap-3 backdrop-blur-xl hover:scale-105 transition-transform duration-300">
                    <span class="relative flex h-3 w-3">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                    </span>
                    <span
                        class="font-bold text-sm bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-cyan-500 dark:from-blue-400 dark:to-cyan-300">
                        Tanya BINU yuk! 👋
                    </span>
                </div>
                <!-- Triangle -->
                <div
                    class="absolute -bottom-2 right-4 w-4 h-4 bg-white dark:bg-slate-800 border-r border-b border-blue-500/30 transform rotate-45">
                </div>
            </div>

            <!-- Main Orb Button -->
            <button @click="isOpen = !isOpen; showBubble = false" class="relative group w-20 h-20 focus:outline-none"
                aria-label="Toggle Chat">

                <!-- Radiant Glow -->
                <div
                    class="absolute inset-0 bg-blue-500 rounded-full blur-xl opacity-40 group-hover:opacity-60 transition-opacity duration-500 animate-pulse-slow">
                </div>
                <div
                    class="absolute -inset-1 bg-gradient-to-r from-cyan-400 to-blue-600 rounded-full blur opacity-30 group-hover:opacity-70 transition-opacity duration-500">
                </div>

                <!-- Glass Orb -->
                <div
                    class="relative w-full h-full rounded-full bg-gradient-to-b from-blue-500/90 to-blue-700/90 shadow-2xl border-2 border-white/20 backdrop-blur-sm overflow-hidden transform transition-all duration-300 group-hover:scale-105 group-hover:-translate-y-1">

                    <!-- Shine Effects -->
                    <div
                        class="absolute top-0 left-0 w-full h-1/2 bg-gradient-to-b from-white/30 to-transparent rounded-t-full pointer-events-none">
                    </div>
                    <div class="absolute bottom-2 right-2 w-8 h-8 bg-blue-400/50 rounded-full blur-md"></div>
                    <div
                        class="absolute top-3 left-3 w-4 h-2 bg-white/60 rounded-full transform -rotate-45 filter blur-[1px]">
                    </div>

                    <!-- Icon Image -->
                    <img src="{{ asset('images/icon-chatbot-glass.png') }}" alt="BINU"
                        class="w-full h-full object-cover relative z-10 transition-transform duration-500 group-hover:scale-110"
                        :class="isOpen ? 'scale-90 opacity-0' : 'scale-100 opacity-100'">

                    <!-- Close Icon (shown when open) -->
                    <div class="absolute inset-0 flex items-center justify-center z-20 transition-all duration-300 transform"
                        :class="isOpen ? 'opacity-100 rotate-0' : 'opacity-0 -rotate-90'">
                        <svg class="w-8 h-8 text-white drop-shadow-md" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>

                    <!-- Ripple Ring (Outer) -->
                    <div class="absolute inset-0 border-2 border-white/30 rounded-full animate-ping-slow pointer-events-none"
                        x-show="!isOpen"></div>
                </div>

                <!-- Notification Badge -->
                <div x-show="!isOpen" x-transition:enter="transition transform ease-out duration-300"
                    x-transition:enter-start="scale-0 translate-y-2" x-transition:enter-end="scale-100 translate-y-0"
                    class="absolute -top-1 -right-1 flex h-6 w-6">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span
                        class="relative inline-flex rounded-full h-6 w-6 bg-gradient-to-r from-red-500 to-pink-500 border-2 border-white flex items-center justify-center text-[10px] font-bold text-white shadow-sm">
                        1
                    </span>
                </div>
            </button>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.3);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.5);
        }

        @keyframes float-slow {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .animate-float-slow {
            animation: float-slow 4s ease-in-out infinite;
        }

        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 0.4;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes ping-slow {

            75%,
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        .animate-ping-slow {
            animation: ping-slow 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.4s ease-out forwards;
        }

        .bg-noise {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='1'/%3E%3C/svg%3E");
        }
    </style>

    <script>
        function binuChat() {
            return {
                isOpen: false,
                showBubble: true,
                isLoading: false,
                input: '',
                messages: [],
                sessionId: null,

                init() {
                    // Show bubble after 2 seconds
                    setTimeout(() => {
                        this.showBubble = true;
                    }, 2000);

                    // Initialize session
                    this.initSession();
                },

                async initSession() {
                    try {
                        const response = await fetch('{{ route("chatbot.session") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });
                        const data = await response.json();
                        this.sessionId = data.session_id;
                    } catch (error) {
                        console.error('Failed to init session:', error);
                    }
                },

                async sendMessage() {
                    if (!this.input.trim() || this.isLoading) return;

                    const userMessage = this.input.trim();
                    this.messages.push({ role: 'user', content: userMessage });
                    this.input = '';
                    this.isLoading = true;

                    // Scroll to bottom
                    this.$nextTick(() => {
                        this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                    });

                    try {
                        const response = await fetch('{{ route("chatbot.send") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                message: userMessage,
                                session_id: this.sessionId
                            })
                        });

                        const data = await response.json();

                        if (data.message && data.message.content) {
                            this.messages.push({ role: 'assistant', content: data.message.content });
                        } else if (data.error) {
                            this.messages.push({ role: 'assistant', content: 'Maaf, terjadi kesalahan. Silakan coba lagi.' });
                        }
                    } catch (error) {
                        console.error('Failed to send message:', error);
                        this.messages.push({ role: 'assistant', content: 'Maaf, koneksi terputus. Silakan coba lagi.' });
                    } finally {
                        this.isLoading = false;
                        // Scroll to bottom
                        this.$nextTick(() => {
                            this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
                        });
                    }
                }
            }
        }
    </script>

    @stack('scripts')
</body>

</html>