@extends('layouts.exam')

@section('title', $exam->title)

@section('content')
    <div class="min-h-screen bg-slate-50 dark:bg-slate-900 flex flex-col" x-data="examApp()">
        <!-- Top Bar -->
        <header
            class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 h-16 flex items-center justify-between px-6 shadow-sm z-30 fixed top-0 w-full">
            <div class="flex items-center gap-4">
                <div class="h-8 w-8 bg-emerald-500 rounded-lg flex items-center justify-center text-white font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10v6" />
                        <path d="M12 2v2" />
                        <path d="M12 22v-2" />
                        <path d="m5.2 6.8 1.4-1.4" />
                        <path d="m17.4 18.6 1.4-1.4" />
                        <path d="m5.2 17.2 1.4 1.4" />
                        <path d="m17.4 5.4 1.4 1.4" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-sm font-bold text-slate-800 dark:text-white line-clamp-1">{{ $exam->title }}</h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Sisa Waktu: <span
                            class="font-mono font-bold text-emerald-600" id="timer">--:--:--</span></p>
                </div>
            </div>

            <button type="button" @click="toggleSidebar"
                class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="18" height="18" x="3" y="3" rx="2" />
                    <path d="M9 3v18" />
                </svg>
            </button>
        </header>

        <!-- Main Layout -->
        <div class="flex flex-1 pt-16 h-screen overflow-hidden">
            <!-- Questions Area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8 pb-32 scroll-smooth">
                <form id="exam-form" action="{{ route('student.exams.submit', $exam) }}" method="POST"
                    class="max-w-3xl mx-auto space-y-12">
                    @csrf

                    @foreach($exam->questions as $index => $question)
                        <div id="question-{{ $question->id }}"
                            class="scroll-mt-24 bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 md:p-8 shadow-sm hover:shadow-md transition-shadow">

                            <!-- Question Header -->
                            <div class="flex gap-4 mb-6">
                                <span
                                    class="flex-shrink-0 h-8 w-8 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg flex items-center justify-center font-bold text-sm select-none">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-grow">
                                    <p class="text-lg font-medium text-slate-800 dark:text-white leading-relaxed select-none">
                                        {{ $question->question_text }}</p>
                                </div>
                            </div>

                            <!-- Options -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ml-0 md:ml-12">
                                @foreach(['a', 'b', 'c', 'd'] as $option)
                                    <label
                                        class="group relative flex items-center gap-4 p-4 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer overflow-hidden transition-all duration-200 hover:border-emerald-300 hover:bg-emerald-50/30 dark:hover:bg-emerald-900/10">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}"
                                            class="peer sr-only" @change="markAnswered({{ $index }})">

                                        <!-- Active State Indicators -->
                                        <div
                                            class="absolute inset-0 border-2 border-emerald-500 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity pointer-events-none">
                                        </div>
                                        <div
                                            class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 peer-checked:opacity-100 text-emerald-500 transition-opacity">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                        </div>

                                        <span
                                            class="w-8 h-8 flex items-center justify-center rounded-lg bg-slate-100 dark:bg-slate-700 text-slate-500 font-bold uppercase text-sm group-hover:bg-emerald-100 group-hover:text-emerald-600 peer-checked:bg-emerald-500 peer-checked:text-white transition-colors">
                                            {{ $option }}
                                        </span>
                                        <span
                                            class="text-slate-700 dark:text-slate-300 font-medium select-none flex-1 pr-6 group-hover:text-emerald-900 dark:group-hover:text-emerald-100 peer-checked:text-emerald-800 dark:peer-checked:text-emerald-200 transition-colors">
                                            {{ $question->{'option_' . $option} }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- Submit Button Area -->
                    <div class="pt-8 pb-16">
                        <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menyelesaikan ujian? Anda tidak dapat mengubah jawaban setelah ini.')"
                            class="w-full py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl font-black text-lg shadow-xl shadow-emerald-500/30 hover:shadow-emerald-500/50 hover:scale-[1.01] active:scale-[0.99] transition-all">
                            SELESAIKAN UJIAN SEKARANG
                        </button>
                    </div>
                </form>
            </main>

            <!-- Sidebar Navigation -->
            <aside
                class="fixed right-0 top-16 bottom-0 w-72 bg-white dark:bg-slate-800 border-l border-slate-200 dark:border-slate-700 transform transition-transform duration-300 z-20 overflow-y-auto"
                :class="{'translate-x-0': sidebarOpen, 'translate-x-full': !sidebarOpen}"
                class="md:translate-x-0 md:static md:w-80 hidden md:block">
                <div
                    class="p-6 sticky top-0 bg-white dark:bg-slate-800 z-10 border-b border-slate-100 dark:border-slate-700/50">
                    <h3 class="font-bold text-slate-800 dark:text-white mb-1">Navigasi Soal</h3>
                    <p class="text-xs text-slate-400">Klik nomor untuk melompat.</p>
                </div>

                <div class="p-6 grid grid-cols-5 gap-3">
                    @foreach($exam->questions as $index => $question)
                        <a href="#question-{{ $question->id }}" @click="sidebarOpen = false"
                            class="aspect-square flex items-center justify-center rounded-xl text-sm font-bold border transition-all"
                            :class="answered[{{ $index }}] ? 'bg-emerald-500 text-white border-emerald-600' : 'bg-slate-50 dark:bg-slate-700 text-slate-600 dark:text-slate-300 border-slate-200 dark:border-slate-600 hover:border-emerald-400 hover:text-emerald-500'">
                            {{ $index + 1 }}
                        </a>
                    @endforeach
                </div>
            </aside>

            <!-- Mobile Overlay -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false"
                class="fixed inset-0 bg-black/50 z-10 md:hidden backdrop-blur-sm" style="display: none;"></div>
        </div>
    </div>

    <!-- Security Overlay (Initially Hidden) -->
    <div id="fullscreen-warning"
        class="fixed inset-0 bg-slate-900/95 backdrop-blur-xl z-[60] flex flex-col items-center justify-center text-center p-8 hidden">
        <div class="bg-red-500/10 p-6 rounded-full mb-6 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-red-500">
                <path
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <h2 class="text-3xl font-black text-white mb-2">MODE UJIAN WAJIB FULLSCREEN</h2>
        <p class="text-slate-300 max-w-md mb-8">Anda dilarang keluar dari mode fullscreen. Klik tombol di bawah untuk
            kembali ke ujian.</p>
        <button onclick="enableFullscreen()"
            class="px-8 py-4 bg-emerald-500 text-white rounded-xl font-bold hover:bg-emerald-600 transition-colors shadow-lg shadow-emerald-500/20">
            Kembali ke Ujian
        </button>
    </div>

    @push('scripts')
        <script src="//cdn.jsdelivr.net/npm/alpinejs" defer></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('examApp', () => ({
                    sidebarOpen: false,
                    answered: new Array({{ $exam->questions->count() }}).fill(false),

                    toggleSidebar() {
                        this.sidebarOpen = !this.sidebarOpen;
                    },
                    markAnswered(index) {
                        this.answered[index] = true;
                    }
                }))
            });

            // Timer Logic
            const endTime = new Date("{{ \Carbon\Carbon::parse($attempt->started_at)->addMinutes($exam->duration_minutes) }}").getTime();

            function updateTimer() {
                const now = new Date().getTime();
                const distance = endTime - now;

                if (distance < 0) {
                    document.getElementById("exam-form").submit();
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("timer").innerHTML =
                    (hours < 10 ? "0" + hours : hours) + ":" +
                    (minutes < 10 ? "0" + minutes : minutes) + ":" +
                    (seconds < 10 ? "0" + seconds : seconds);

                if (distance < 300000) { // 5 minutes warning
                    document.getElementById("timer").classList.replace("text-emerald-600", "text-red-500");
                    document.getElementById("timer").classList.add("animate-pulse");
                }
            }
            setInterval(updateTimer, 1000);

            // Security & Fullscreen Logic
            const warningOverlay = document.getElementById('fullscreen-warning');
            let violationCount = 0;

            function enableFullscreen() {
                const elem = document.documentElement;
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.webkitRequestFullscreen) { /* Safari */
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) { /* IE11 */
                    elem.msRequestFullscreen();
                }
                warningOverlay.classList.add('hidden');
            }

            // Force Fullscreen on Load
            // document.addEventListener('click', enableFullscreen, { once: true });

            // Detect Fullscreen Exit
            document.addEventListener('fullscreenchange', () => {
                if (!document.fullscreenElement) {
                    warningOverlay.classList.remove('hidden');
                    recordViolation();
                }
            });

            // Detect Tab Switching/Blur
            window.addEventListener('blur', () => {
                // Optional: trigger warning or record violation immediately
                // For now, let's just log it or show a toast if we had one.
                recordViolation();
            });

            function recordViolation() {
                violationCount++;
                // Send AJAX to server to record violation
                fetch('{{ route("student.exams.record-violation", $exam) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                }).then(res => {
                    if (res.status === 403) {
                        alert('Terlalu banyak pelanggaran! Ujian Anda dihentikan otomatis.');
                        window.location.reload(); // Will redirect to result
                    }
                });
            }

            // Prevent Right Click & Copy Paste
            document.addEventListener('contextmenu', event => event.preventDefault());
            document.addEventListener('keydown', function (event) {
                if (event.ctrlKey && (event.key === 'c' || event.key === 'v' || event.key === 'u')) {
                    event.preventDefault();
                }
            });
        </script>
        <style>
            /* Hide scrollbar for Chrome, Safari and Opera */
            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }

            /* Hide scrollbar for IE, Edge and Firefox */
            .no-scrollbar {
                -ms-overflow-style: none;
                /* IE and Edge */
                scrollbar-width: none;
                /* Firefox */
            }
        </style>
    @endpush
@endsection