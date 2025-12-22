<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="chatbotThemeManager()">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BINU - Asisten Virtual SMAN 2 KAUR</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .chat-container {
            height: calc(100vh - 180px);
            min-height: 400px;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 107, 255, 0.1);
        }

        .dark .glass-card {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .message-animation {
            animation: messageSlide 0.3s ease-out;
        }

        .typing-indicator span {
            animation: typing 1.4s infinite;
            background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        }

        .dark .typing-indicator span {
            background: linear-gradient(90deg, #60a5fa, #3b82f6);
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        .pulse-ring {
            animation: pulseRing 2s infinite;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #dbeafe 100%);
        }

        .dark .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%);
        }

        .btn-glow {
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        .btn-glow:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes typing {

            0%,
            60%,
            100% {
                opacity: 0.3;
                transform: translateY(0);
            }

            30% {
                opacity: 1;
                transform: translateY(-4px);
            }
        }

        @keyframes pulseRing {
            0% {
                transform: scale(0.95);
                opacity: 0.8;
            }

            70% {
                transform: scale(1.1);
                opacity: 0;
            }

            100% {
                transform: scale(1.1);
                opacity: 0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .chat-container {
                height: calc(100vh - 160px);
                min-height: 300px;
            }
        }
    </style>
    <script>
        function chatbotThemeManager() {
            return {
                darkMode: localStorage.getItem('theme') === 'dark' ||
                    (window.matchMedia('(prefers-color-scheme: dark)').matches && !localStorage.getItem('theme')),

                init() {
                    // Apply theme immediately on init
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }

                    // Watch for system preference changes
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (!localStorage.getItem('theme')) {
                            this.darkMode = e.matches;
                            if (e.matches) document.documentElement.classList.add('dark');
                            else document.documentElement.classList.remove('dark');
                        }
                    });
                },

                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');

                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            };
        }

        function chatApp() {
            return {
                sessionId: localStorage.getItem('binu_session_id') || this.generateUUID(),
                messages: [],
                newMessage: '',
                isTyping: false,

                generateUUID() {
                    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                        const r = Math.random() * 16 | 0;
                        const v = c === 'x' ? r : (r & 0x3 | 0x8);
                        return v.toString(16);
                    });
                },

                init() {
                    localStorage.setItem('binu_session_id', this.sessionId);
                    this.loadSession();
                },

                async loadSession() {
                    try {
                        const response = await fetch('{{ route("chatbot.session") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ session_id: this.sessionId })
                        });
                        const data = await response.json();
                        this.messages = data.messages || [];
                        this.scrollToBottom();
                    } catch (error) {
                        console.error('Error loading session:', error);
                    }
                },

                async sendMessage() {
                    if (!this.newMessage.trim() || this.isTyping) return;

                    const userMessage = this.newMessage.trim();
                    this.newMessage = '';

                    this.messages.push({
                        role: 'user',
                        content: userMessage,
                        created_at: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                    });
                    this.scrollToBottom();

                    this.isTyping = true;

                    try {
                        const response = await fetch('{{ route("chatbot.send") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                session_id: this.sessionId,
                                message: userMessage
                            })
                        });

                        const data = await response.json();
                        this.messages.push(data.message);
                        this.scrollToBottom();
                    } catch (error) {
                        console.error('Error sending message:', error);
                        this.messages.push({
                            role: 'assistant',
                            content: 'Maaf, terjadi kesalahan. Silakan coba lagi.',
                            created_at: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' })
                        });
                    } finally {
                        this.isTyping = false;
                    }
                },

                askQuestion(question) {
                    this.newMessage = question;
                    this.sendMessage();
                },

                async clearChat() {
                    if (!confirm('Hapus semua riwayat chat?')) return;

                    try {
                        await fetch('{{ route("chatbot.clear") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ session_id: this.sessionId })
                        });
                        this.messages = [];
                    } catch (error) {
                        console.error('Error clearing chat:', error);
                    }
                },

                formatMessage(content) {
                    if (!content) return '';
                    return content
                        .replace(/\n/g, '<br>')
                        .replace(/\*\*(.*?)\*\*/g, '<strong class="text-blue-600 dark:text-blue-400">$1</strong>')
                        .replace(/\*(.*?)\*/g, '<em>$1</em>')
                        .replace(/`(.*?)`/g, '<code class="bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded text-sm">$1</code>');
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('messagesContainer');
                        if (container) container.scrollTop = container.scrollHeight;
                    });
                }
            };
        }
    </script>
</head>

<body class="min-h-screen gradient-bg transition-colors duration-300">
    <div class="min-h-screen flex flex-col fade-in" x-data="chatApp()">
        <!-- Header -->
        <header class="glass-effect sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-4 py-3 sm:px-6 lg:px-8 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <div
                            class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg overflow-hidden border-2 border-blue-500">
                            <img src="{{ asset('images/icon-chatbot.png') }}" alt="BINU Icon"
                                class="w-full h-full object-cover">
                        </div>
                        <div class="absolute -inset-1 rounded-full pulse-ring bg-blue-400 opacity-70"></div>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-slate-800 dark:text-white">BINU</h1>
                        <p class="text-sm text-blue-600 dark:text-blue-400 font-medium">Asisten Virtual SMAN 2 KAUR</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Dark Mode Toggle -->
                    <button @click="toggleTheme" class="p-2 rounded-full glass-effect hover:bg-white/20 transition">
                        <svg x-show="!darkMode" class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <svg x-show="darkMode" class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    <button @click="clearChat()"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-white/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span class="hidden sm:inline">Hapus Chat</span>
                    </button>

                    <a href="{{ route('home') }}"
                        class="flex items-center space-x-2 px-4 py-2 rounded-lg text-sm font-medium bg-blue-600 text-white hover:bg-blue-700 transition btn-glow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        <span class="hidden sm:inline">Kembali</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 max-w-6xl w-full mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-6 h-full">
                <!-- Chat Container -->
                <div class="flex-1">
                    <div class="glass-card rounded-2xl shadow-xl overflow-hidden chat-container flex flex-col fade-in">
                        <!-- Messages -->
                        <div class="flex-1 overflow-y-auto p-4 sm:p-6 space-y-4" id="messagesContainer">
                            <div class="flex items-start space-x-3 message-animation" x-show="messages.length === 0">
                                <div
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md overflow-hidden border border-blue-200">
                                    <img src="{{ asset('images/icon-chatbot.png') }}" alt="BINU"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="glass-card rounded-2xl rounded-tl-none px-5 py-4 max-w-lg">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                                        <p class="text-sm font-medium text-blue-600 dark:text-blue-400">BINU Online</p>
                                    </div>
                                    <p class="text-slate-800 dark:text-slate-200">
                                        Halo! 👋 Saya <span
                                            class="font-bold text-blue-600 dark:text-blue-400">BINU</span>, asisten
                                        virtual SMAN 2 KAUR.
                                        Saya siap membantu menjawab pertanyaan seputar sekolah, pendaftaran, kegiatan,
                                        dan informasi akademik lainnya.
                                    </p>
                                    <p class="text-slate-600 dark:text-slate-400 mt-3 text-sm">
                                        Silakan ketik pertanyaan Anda di bawah atau pilih pertanyaan cepat di samping!
                                    </p>
                                </div>
                            </div>

                            <template x-for="(message, index) in messages" :key="index">
                                <div class="flex items-start space-x-3 message-animation"
                                    :class="message.role === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 shadow-md overflow-hidden"
                                        :class="message.role === 'user' ? 'bg-gradient-to-br from-blue-600 to-blue-800' : 'bg-white border border-blue-200'">
                                        <template x-if="message.role === 'user'">
                                            <span class="text-white text-sm">👤</span>
                                        </template>
                                        <template x-if="message.role !== 'user'">
                                            <img src="{{ asset('images/icon-chatbot.png') }}" alt="BINU"
                                                class="w-full h-full object-cover">
                                        </template>
                                    </div>
                                    <div class="rounded-2xl px-5 py-4 max-w-lg shadow-sm"
                                        :class="message.role === 'user' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-tr-none' : 'glass-card text-slate-800 dark:text-slate-200 rounded-tl-none'">
                                        <p x-html="formatMessage(message.content)"></p>
                                        <p class="text-xs mt-2 opacity-70" x-text="message.created_at"></p>
                                    </div>
                                </div>
                            </template>

                            <!-- Typing Indicator -->
                            <div class="flex items-start space-x-3" x-show="isTyping">
                                <div
                                    class="w-10 h-10 bg-white rounded-full flex items-center justify-center flex-shrink-0 shadow-md overflow-hidden border border-blue-200">
                                    <img src="{{ asset('images/icon-chatbot.png') }}" alt="BINU"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="glass-card rounded-2xl rounded-tl-none px-5 py-4">
                                    <div class="typing-indicator flex space-x-1">
                                        <span class="w-2 h-2 rounded-full"></span>
                                        <span class="w-2 h-2 rounded-full"></span>
                                        <span class="w-2 h-2 rounded-full"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Input Area -->
                        <div class="border-t border-slate-200 dark:border-slate-700/50 p-4">
                            <form @submit.prevent="sendMessage()" class="flex items-center space-x-3">
                                <div class="flex-1 relative">
                                    <input type="text" x-model="newMessage" @keydown.enter.prevent="sendMessage()"
                                        placeholder="Tanyakan sesuatu tentang SMAN 2 KAUR..."
                                        class="w-full px-5 py-3.5 bg-white/80 dark:bg-slate-800/80 border border-slate-300 dark:border-slate-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition pl-12"
                                        :disabled="isTyping">
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </div>
                                </div>
                                <button type="submit"
                                    class="bg-gradient-to-r from-blue-600 to-blue-700 text-white p-3.5 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all disabled:opacity-50 disabled:cursor-not-allowed btn-glow"
                                    :disabled="!newMessage.trim() || isTyping">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                </button>
                            </form>
                            <p class="text-center text-slate-500 dark:text-slate-400 text-xs mt-3">
                                BINU dapat membuat kesalahan. Untuk informasi resmi, hubungi sekolah langsung.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Questions Sidebar -->
                <div class="lg:w-80 fade-in" x-show="messages.length === 0">
                    <div class="glass-card rounded-2xl p-5 h-full">
                        <div class="flex items-center space-x-2 mb-6">
                            <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Pertanyaan Cepat</h2>
                        </div>

                        <div class="space-y-3">
                            <button @click="askQuestion('Bagaimana prosedur pendaftaran siswa baru?')"
                                class="w-full text-left p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition group">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="p-2 bg-blue-100 dark:bg-blue-900/40 rounded-lg group-hover:scale-110 transition">
                                        <span class="text-blue-600 dark:text-blue-400">📝</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800 dark:text-slate-200">Pendaftaran Siswa Baru
                                        </p>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Prosedur dan
                                            persyaratan</p>
                                    </div>
                                </div>
                            </button>

                            <button @click="askQuestion('Apa saja ekstrakurikuler yang tersedia di SMAN 2 KAUR?')"
                                class="w-full text-left p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition group">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="p-2 bg-blue-100 dark:bg-blue-900/40 rounded-lg group-hover:scale-110 transition">
                                        <span class="text-blue-600 dark:text-blue-400">🎯</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800 dark:text-slate-200">Ekstrakurikuler</p>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Kegiatan pengembangan
                                            diri</p>
                                    </div>
                                </div>
                            </button>

                            <button @click="askQuestion('Jam operasional dan jadwal belajar di SMAN 2 KAUR?')"
                                class="w-full text-left p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition group">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="p-2 bg-blue-100 dark:bg-blue-900/40 rounded-lg group-hover:scale-110 transition">
                                        <span class="text-blue-600 dark:text-blue-400">🕐</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800 dark:text-slate-200">Jam Operasional</p>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Jadwal sekolah &
                                            kegiatan</p>
                                    </div>
                                </div>
                            </button>

                            <button @click="askQuestion('Berapa biaya pendaftaran dan SPP di SMAN 2 KAUR?')"
                                class="w-full text-left p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition group">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="p-2 bg-blue-100 dark:bg-blue-900/40 rounded-lg group-hover:scale-110 transition">
                                        <span class="text-blue-600 dark:text-blue-400">💰</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800 dark:text-slate-200">Biaya Pendidikan</p>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Informasi keuangan
                                        </p>
                                    </div>
                                </div>
                            </button>

                            <button @click="askQuestion('Bagaimana sistem kurikulum dan pembelajaran di SMAN 2 KAUR?')"
                                class="w-full text-left p-4 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-700 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition group">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="p-2 bg-blue-100 dark:bg-blue-900/40 rounded-lg group-hover:scale-110 transition">
                                        <span class="text-blue-600 dark:text-blue-400">📚</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-slate-800 dark:text-slate-200">Kurikulum</p>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Sistem pembelajaran
                                        </p>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Mobile Quick Questions -->
        <div class="lg:hidden max-w-6xl mx-auto px-4 pb-6" x-show="messages.length === 0">
            <div class="glass-card rounded-2xl p-5">
                <h3 class="font-bold text-slate-800 dark:text-white mb-3">Pertanyaan Cepat</h3>
                <div class="flex flex-wrap gap-2">
                    <button @click="askQuestion('Bagaimana cara mendaftar?')"
                        class="px-4 py-2 text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                        📝 Pendaftaran
                    </button>
                    <button @click="askQuestion('Ekstrakurikuler apa saja?')"
                        class="px-4 py-2 text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                        🎯 Ekstrakurikuler
                    </button>
                    <button @click="askQuestion('Jam operasional?')"
                        class="px-4 py-2 text-sm bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full hover:bg-blue-200 dark:hover:bg-blue-800 transition">
                        🕐 Jam Sekolah
                    </button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>