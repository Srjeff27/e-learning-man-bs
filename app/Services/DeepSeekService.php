<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

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
     * Mengambil System Prompt yang Dinamis (Cerdas).
     * Bisa disisipi data dari Database (misal: Berita Terbaru).
     */
    private function buildSystemPrompt(): string
    {
        // Contoh: Mengambil pengumuman terbaru dari Cache/DB (Simulasi)
        // $latestNews = Announcement::latest()->take(3)->get();
        $today = now()->format('l, d F Y');
        $dynamicNews = "Pengumuman Sekolah Terbaru: PPDB Gelombang 2 dibuka sampai 30 Juni.";

        return <<<EOT
Kamu adalah "BINU" (Buddy Informatif untuk Navigasi Umum), AI Assistant resmi SMAN 2 KAUR yang cerdas, empatik, dan gaul tapi sopan.
Tanggal hari ini: {$today}.

IDENTITAS & GAYA BICARA:
1.  **Nama:** BINU.
2.  **Gaya:** Ramah, solutif, menggunakan emoji yang pas (😊, 🎓, ✨), dan bahasa Indonesia yang natural (tidak kaku seperti robot).
3.  **Vibe:** Seperti kakak kelas OSIS yang sangat membantu adik kelasnya.

DATA PENGETAHUAN (KNOWLEDGE BASE):
- **Sekolah:** SMAN 2 KAUR (Akreditasi A).
- **Lokasi:** Tanjung Kemuning III, Kab. Kaur, Bengkulu 38955.
- **Kontak:** (0739) 123456 | info@sman2kaur.nett.to
- **Jam:** Senin-Jumat (07:00 - 15:00 WIB).
- **Kurikulum:** Merdeka Belajar.
- **Info Live:** {$dynamicNews}

ATURAN LOGIKA (CHAIN OF THOUGHT):
1.  Jika user bertanya tentang hal sensitif/kekerasan, tolak dengan halus.
2.  Jika user bertanya data spesifik siswa (nilai/SPP), minta mereka login ke portal (jangan berikan data di chat).
3.  Jika user menyapa (Halo, Pagi), jawab dengan variasi sapaan yang hangat, jangan robotik.
4.  Jika informasi tidak ada di "DATA PENGETAHUAN", katakan: "Waduh, untuk info detail itu BINU sarankan kontak admin ya, biar akurat! 🙏"

EOT;
    }

    /**
     * Memproses pesan agar hemat token tapi tetap ingat konteks.
     */
    private function optimizeMessages(array $messages): array
    {
        // 1. Selalu sertakan System Prompt di awal
        $optimized[] = [
            'role' => 'system',
            'content' => $this->buildSystemPrompt(),
        ];

        // 2. Ambil N pesan terakhir saja untuk menjaga konteks tanpa memboroskan token
        // DeepSeek memiliki konteks window besar, tapi kita hemat biaya.
        $recentMessages = array_slice($messages, -$this->maxHistoryMessages);

        foreach ($recentMessages as $msg) {
            $optimized[] = [
                'role' => $msg['role'], // 'user' atau 'assistant'
                'content' => $msg['content'],
            ];
        }

        return $optimized;
    }

    /**
     * Fungsi Chat Utama dengan Retry Logic & Error Handling Canggih.
     */
    public function chat(array $historyMessages): array
    {
        if (empty($this->apiKey)) {
            return $this->errorResponse('API Key belum disetting.');
        }

        $payload = [
            'model' => $this->model,
            'messages' => $this->optimizeMessages($historyMessages),
            'temperature' => 0.8, // Sedikit lebih kreatif (0.7 - 1.0)
            'max_tokens' => 800,
            'presence_penalty' => 0.3, // Mencegah pengulangan kata
            'frequency_penalty' => 0.3,
        ];

        try {
            // Menggunakan retry() bawaan Laravel untuk koneksi yang tidak stabil
            $response = Http::retry(3, 100) // Coba 3x, jeda 100ms
                ->timeout(30)
                ->withToken($this->apiKey)
                ->post($this->baseUrl . '/chat/completions', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'BINU sedang berpikir keras, tapi belum nemu jawabannya nih.. 🤔';
                
                return [
                    'success' => true,
                    'message' => $reply,
                    'usage' => $data['usage'] ?? [],
                ];
            }

            // Log Error Detail dari API
            Log::error('DeepSeek API Error', ['status' => $response->status(), 'body' => $response->body()]);
            return $this->errorResponse('Maaf, server BINU lagi sibuk banget. Coba lagi ya!');

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            return $this->errorResponse('Koneksi internet bermasalah. Cek sinyal kamu ya!');
        } catch (\Exception $e) {
            Log::error('DeepSeek Exception', ['message' => $e->getMessage()]);
            return $this->errorResponse('Terjadi kesalahan teknis pada sistem BINU.');
        }
    }

    /**
     * Helper untuk format error yang konsisten
     */
    private function errorResponse(string $message): array
    {
        return [
            'success' => false,
            'message' => $message . ' 😥',
            'error' => true
        ];
    }
}