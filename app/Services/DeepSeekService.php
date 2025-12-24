<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepSeekService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.deepseek.com';
    protected string $model = 'deepseek-chat';
    
    // Batas aman token agar tidak error saat chat panjang
    protected int $maxHistoryMessages = 10; 

    public function __construct()
    {
        $this->apiKey = (string) config('services.deepseek.api_key', '');
    }

    /**
     * Dibuat PUBLIC kembali agar Controller yang memanggil ini tidak error.
     * Logika tetap dinamis (ada tanggal & jam).
     */
    public function getSystemPrompt(): string
    {
        $today = now()->locale('id')->isoFormat('dddd, D MMMM Y'); // Contoh: Senin, 25 Desember 2025
        
        // Anda bisa mengambil ini dari database jika mau
        $dynamicNews = "Pengumuman: PPDB Gelombang 2 dibuka sampai akhir bulan ini.";

        return <<<EOT
Kamu adalah "BINU" (Buddy Informatif untuk Navigasi Umum), AI Assistant resmi SMAN 2 KAUR.
Tanggal hari ini: {$today}.

IDENTITAS & GAYA BICARA:
1. Nama: BINU.
2. Gaya: Ramah, solutif, menggunakan emoji yang pas (😊, 🎓, ✨), dan bahasa Indonesia yang natural.
3. Peran: Seperti kakak kelas OSIS yang sangat membantu adik kelasnya.

DATA PENGETAHUAN:
- Sekolah: SMAN 2 KAUR (Akreditasi A).
- Alamat: Tanjung Kemuning III, Kab. Kaur, Bengkulu 38955.
- Telepon: (0739) 123456 | Email: info@sman2kaur.nett.to
- Jam Operasional: Senin-Jumat (07:00 - 15:00 WIB).
- Info Terkini: {$dynamicNews}

PANDUAN MENJAWAB:
- Jawab langsung ke inti pertanyaan.
- Jika user menyapa (Halo, Pagi), jawab dengan hangat.
- Jika info tidak tersedia di data di atas, sarankan hubungi pihak sekolah.
- Jangan mengarang data sensitif (nilai siswa, nomor HP guru pribadi).
EOT;
    }

    /**
     * Memproses pesan: Menambahkan System Prompt otomatis & Membatasi history.
     */
    private function optimizeMessages(array $messages): array
    {
        $optimized = [];

        // 1. Masukkan System Prompt di urutan pertama
        // Kita panggil getSystemPrompt() di sini
        $optimized[] = [
            'role' => 'system',
            'content' => $this->getSystemPrompt(),
        ];

        // 2. Filter pesan agar tidak mengambil system prompt ganda dari user input (jika ada)
        // dan hanya mengambil N pesan terakhir untuk hemat token.
        $userMessages = array_filter($messages, function($msg) {
            return $msg['role'] !== 'system';
        });

        $recentMessages = array_slice($userMessages, -$this->maxHistoryMessages);

        foreach ($recentMessages as $msg) {
            $optimized[] = [
                'role' => $msg['role'],
                'content' => $msg['content'],
            ];
        }

        return $optimized;
    }

    /**
     * Fungsi Chat Utama
     */
    public function chat(array $messages): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'message' => 'API Key belum disetting.',
                'error' => 'API_KEY_MISSING'
            ];
        }

        try {
            // Gunakan optimizeMessages untuk menyusun payload
            $finalMessages = $this->optimizeMessages($messages);

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/chat/completions', [
                    'model' => $this->model,
                    'messages' => $finalMessages,
                    'temperature' => 0.7, // 0.7 = seimbang antara kreatif dan akurat
                    'max_tokens' => 800,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'message' => $data['choices'][0]['message']['content'] ?? 'Maaf, BINU sedang tidak bisa menjawab.',
                    'usage' => $data['usage'] ?? null,
                ];
            }

            Log::error('DeepSeek API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Maaf, terjadi gangguan pada server BINU.',
                'error' => 'API_ERROR',
            ];

        } catch (\Exception $e) {
            Log::error('DeepSeek Service Exception', ['message' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Layanan sementara tidak tersedia.',
                'error' => 'SERVICE_UNAVAILABLE',
            ];
        }
    }

    /**
     * Untuk testing satu kali tanya (tanpa history)
     */
    public function ask(string $question): string
    {
        $result = $this->chat([
            ['role' => 'user', 'content' => $question]
        ]);

        return $result['message'];
    }
}