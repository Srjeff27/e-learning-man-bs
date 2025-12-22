<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

        .messages-container {
            scrollbar-width: thin;
        }

        .messages-container::-webkit-scrollbar {
            width: 6px;
        }

        .messages-container::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 3px;
        }

        .typing-indicator span {
            animation: typing 1.4s infinite;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
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
    </style>
</head>

<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    <div class="min-h-screen flex flex-col" x-data="chatApp()">
        <!-- Header -->
        <header class="bg-white/10 backdrop-blur-lg border-b border-white/10">
            <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center">
                        <span class="text-white text-lg">🤖</span>
                    </div>
                    <div>
                        <h1 class="text-white font-semibold">BINU</h1>
                        <p class="text-green-400 text-xs">Buddy Informatif untuk Navigasi Umum</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <button @click="clearChat()" class="text-white/60 hover:text-white text-sm flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Chat
                    </button>
                    <a href="{{ route('home') }}" class="text-white/60 hover:text-white text-sm">
                        ← Kembali
                    </a>
                </div>
            </div>
        </header>

        <!-- Chat Container -->
        <div class="flex-1 max-w-4xl w-full mx-auto px-4 py-6">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden chat-container flex flex-col">
                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4 messages-container" id="messagesContainer">
                    <!-- Welcome Message -->
                    <div class="flex items-start space-x-3" x-show="messages.length === 0">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-sm">🤖</span>
                        </div>
                        <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3 max-w-lg">
                            <p class="text-gray-800">
                                Halo! 👋 Saya <strong>BINU</strong>, asisten virtual SMAN 2 KAUR.
                                Saya siap membantu menjawab pertanyaan seputar sekolah, pendaftaran, kegiatan, dan
                                informasi akademik lainnya.
                            </p>
                            <p class="text-gray-600 mt-2 text-sm">
                                Silakan ketik pertanyaan Anda di bawah!
                            </p>
                        </div>
                    </div>

                    <!-- Chat Messages -->
                    <template x-for="(message, index) in messages" :key="index">
                        <div class="flex items-start space-x-3"
                            :class="message.role === 'user' ? 'flex-row-reverse space-x-reverse' : ''">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0"
                                :class="message.role === 'user' ? 'bg-blue-500' : 'bg-gradient-to-br from-green-400 to-emerald-600'">
                                <span class="text-white text-sm" x-text="message.role === 'user' ? '👤' : '🤖'"></span>
                            </div>
                            <div class="rounded-2xl px-4 py-3 max-w-lg"
                                :class="message.role === 'user' ? 'bg-blue-500 text-white rounded-tr-none' : 'bg-gray-100 text-gray-800 rounded-tl-none'">
                                <p x-html="formatMessage(message.content)"></p>
                                <p class="text-xs mt-1 opacity-60" x-text="message.created_at"></p>
                            </div>
                        </div>
                    </template>

                    <!-- Typing Indicator -->
                    <div class="flex items-start space-x-3" x-show="isTyping">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-green-400 to-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-sm">🤖</span>
                        </div>
                        <div class="bg-gray-100 rounded-2xl rounded-tl-none px-4 py-3">
                            <div class="typing-indicator flex space-x-1">
                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input -->
                <div class="border-t p-4">
                    <form @submit.prevent="sendMessage()" class="flex items-center space-x-3">
                        <input type="text" x-model="newMessage" @keydown.enter="sendMessage()"
                            placeholder="Ketik pertanyaan Anda..."
                            class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            :disabled="isTyping">
                        <button type="submit"
                            class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!newMessage.trim() || isTyping">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </form>
                    <p class="text-center text-gray-400 text-xs mt-3">
                        BINU dapat membuat kesalahan. Untuk informasi resmi, hubungi sekolah langsung.
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Questions -->
        <div class="max-w-4xl w-full mx-auto px-4 pb-6" x-show="messages.length === 0">
            <p class="text-white/60 text-sm text-center mb-3">Pertanyaan populer:</p>
            <div class="flex flex-wrap justify-center gap-2">
                <button @click="askQuestion('Bagaimana cara mendaftar siswa baru?')"
                    class="bg-white/10 hover:bg-white/20 text-white text-sm px-4 py-2 rounded-full transition">
                    📝 Pendaftaran siswa baru
                </button>
                <button @click="askQuestion('Apa saja ekstrakurikuler yang tersedia?')"
                    class="bg-white/10 hover:bg-white/20 text-white text-sm px-4 py-2 rounded-full transition">
                    🎯 Ekstrakurikuler
                </button>
                <button @click="askQuestion('Jam operasional sekolah?')"
                    class="bg-white/10 hover:bg-white/20 text-white text-sm px-4 py-2 rounded-full transition">
                    🕐 Jam operasional
                </button>
                <button @click="askQuestion('Berapa biaya pendaftaran?')"
                    class="bg-white/10 hover:bg-white/20 text-white text-sm px-4 py-2 rounded-full transition">
                    💰 Biaya pendaftaran
                </button>
            </div>
        </div>
    </div>

    <script>
        // UUID generator function outside the component
        function generateUUID() {
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
                const r = Math.random() * 16 | 0;
                const v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        function chatApp() {
            return {
                sessionId: localStorage.getItem('binu_session_id') || generateUUID(),
                messages: [],
                newMessage: '',
                isTyping: false,

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

                    // Add user message to UI
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
                    // Convert newlines to <br> and basic markdown
                    return content
                        .replace(/\n/g, '<br>')
                        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
                        .replace(/\*(.*?)\*/g, '<em>$1</em>');
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('messagesContainer');
                        container.scrollTop = container.scrollHeight;
                    });
                }
            };
        }
    </script>
</body>

</html>