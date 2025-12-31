@extends('layouts.exam')

@section('title', 'Mengerjakan Ujian')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div
            class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-lg flex justify-between items-center sticky top-20 z-40">
            <div>
                <h2 class="text-xl font-bold text-slate-800 dark:text-white">{{ $exam->title }}</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Durasi: {{ $exam->duration_minutes }} Menit</p>
            </div>
            <div class="text-right">
                <div class="text-xs text-slate-500 uppercase tracking-widest font-semibold mb-1">Sisa Waktu</div>
                <div id="check-timer" class="text-2xl font-mono font-bold text-red-500">
                    {{ $exam->duration_minutes }}:00
                </div>
            </div>
        </div>

        <form action="{{ route('student.exams.submit', $exam) }}" method="POST" id="exam-form">
            @csrf

            <div class="space-y-6">
                @foreach($exam->questions as $index => $question)
                    <div
                        class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-sm">
                        <div class="flex gap-4">
                            <span
                                class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-emerald-100 text-emerald-600 font-bold text-sm">
                                {{ $index + 1 }}
                            </span>
                            <div class="w-full">
                                <p class="text-lg font-medium text-slate-800 dark:text-white mb-6">
                                    {{ $question->question_text }}
                                </p>

                                <div class="space-y-3">
                                    @foreach(['a', 'b', 'c', 'd'] as $opt)
                                        <label
                                            class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:border-emerald-200 dark:hover:border-emerald-800 transition-all group">
                                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}"
                                                class="w-5 h-5 text-emerald-600 bg-slate-100 border-slate-300 focus:ring-emerald-500 dark:ring-offset-slate-800 dark:bg-slate-700 dark:border-slate-600">
                                            <span
                                                class="text-slate-700 dark:text-slate-300 group-hover:text-emerald-700 dark:group-hover:text-emerald-400 font-medium">
                                                {{ $question->{'option_' . $opt} }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                <button type="submit"
                    onclick="return confirm('Apakah Anda yakin ingin mengumpulkan ujian ini? Jawaban tidak dapat diubah setelah dikirim.')"
                    class="w-full py-4 bg-gradient-to-r from-emerald-500 to-green-600 text-white rounded-2xl shadow-xl shadow-emerald-500/30 hover:shadow-emerald-500/50 transition-all font-bold text-lg transform hover:-translate-y-1">
                    Kirim Jawaban & Selesai
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- TIMER LOGIC ---
            try {
                let durationMinutes = {{ $exam->duration_minutes ?? 0 }};
                let duration = durationMinutes * 60;
                const timerDisplay = document.getElementById('check-timer');
                const examForm = document.getElementById('exam-form');

                if (timerDisplay && duration > 0) {
                    const interval = setInterval(() => {
                        if (window.isTerminated) return;

                        const minutes = Math.floor(duration / 60);
                        const seconds = duration % 60;

                        timerDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                        if (--duration < 0) {
                            clearInterval(interval);
                            submitExam(true);
                        }
                    }, 1000);
                }
            } catch (e) {
                console.error("Timer Error:", e);
            }

            // --- ANTI-CHEAT LOGIC ---
            try {
                window.isTerminated = false;
                let violationCount = {{ $attempt->violation_count ?? 0 }};
                const maxViolations = 1; 
                let warningTimeout;
                let gracePeriod = false; 

                // 1. Initial Warning & Fullscreen Trigger
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'ATURAN UJIAN',
                        html: `
                            <div class="text-left text-sm">
                                <ul class="list-decimal pl-5 space-y-2">
                                    <li>Wajib <b>FULLSCREEN</b>.</li>
                                    <li>Dilarang pindah tab / minimize browser.</li>
                                    <li>Jika tidak sengaja keluar Fullscreen, Anda punya <b>5 detik</b> untuk kembali.</li>
                                    <li class="text-red-500 font-bold">MELANGGAR = NILAI 0 & UJIAN BERHENTI!</li>
                                </ul>
                            </div>
                        `,
                        icon: 'warning',
                        confirmButtonText: 'Saya Siap Mengerjakan',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        background: '#fff',
                        customClass: {
                            popup: 'rounded-xl shadow-xl border border-slate-200'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            requestFullscreen();
                        }
                    });
                }

                function requestFullscreen() {
                    const elem = document.documentElement;
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen().catch(err => console.log(err));
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }
                }

                function handleViolation(reason) {
                    if (window.isTerminated) return;

                    // Grace Period for Fullscreen Exit
                    if (reason === "Keluar dari Fullscreen") {
                         Swal.fire({
                            title: 'PERINGATAN!',
                            text: 'Anda keluar dari Fullscreen! Tekan "Kembali" dalam 5 detik atau Ujian Dihentikan!',
                            icon: 'error',
                            timer: 5000,
                            timerProgressBar: true,
                            showCancelButton: false,
                            confirmButtonText: 'Kembali ke Fullscreen',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                requestFullscreen();
                            } else if (result.dismiss === Swal.DismissReason.timer) {
                                terminateExam("Waktu habis untuk kembali ke Fullscreen.");
                            }
                        });
                        return;
                    }

                    // Strict violation (Tab Switch) - NO MERCY
                    terminateExam(reason);
                }

                function terminateExam(reason) {
                    if (window.isTerminated) return;
                    window.isTerminated = true;

                    Swal.fire({
                        title: 'UJIAN DIHENTIKAN',
                        text: `Pelanggaran: ${reason}. Nilai Anda otomatis 0.`,
                        icon: 'error',
                        confirmButtonText: 'Tutup',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                         fetch('{{ route("student.exams.violation", $exam) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ terminate: true, reason: reason })
                        }).then(() => {
                            window.location.href = '{{ route("student.exams.result", $exam) }}';
                        });
                    });
                }

                // 2. Event Listeners
                document.addEventListener("visibilitychange", function() {
                    if (document.hidden && !window.isTerminated) {
                         terminateExam("Membuka tab lain / Minimize Browser");
                    }
                });

                document.addEventListener("fullscreenchange", function() {
                    if (!document.fullscreenElement && !window.isTerminated) {
                         handleViolation("Keluar dari Fullscreen");
                    }
                });
                
                document.addEventListener("webkitfullscreenchange", function() {
                    if (!document.webkitFullscreenElement && !window.isTerminated) {
                         handleViolation("Keluar dari Fullscreen");
                    }
                });

                // Prevent Context Menu & Copy Paste
                document.addEventListener('contextmenu', event => event.preventDefault());
                document.addEventListener('copy', event => event.preventDefault());
                document.addEventListener('paste', event => event.preventDefault());

            } catch(e) {
                console.error("Anti-Cheat Error:", e);
            }
        });

        function submitExam(force = false) {
            if (window.isTerminated && !force) return;
            window.isTerminated = true;
            document.getElementById('exam-form').submit();
        }

        // Prevent Defaults
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => e.preventDefault());
        document.addEventListener('paste', e => e.preventDefault());
    </script>
@endsection