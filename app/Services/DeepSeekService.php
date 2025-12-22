<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeepSeekService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.deepseek.com';
    protected string $model = 'deepseek-chat';

    public function __construct()
    {
        $this->apiKey = (string) config('services.deepseek.api_key', '');
    }

    /**
     * Get the system prompt for the school chatbot.
     */
    public function getSystemPrompt(): string
    {
        return <<<EOT
Kamu adalah asisten virtual bernama "BINU" (Buddy Informatif untuk Navigasi Umum) dari SMAN 2 KAUR.
Kamu bertugas membantu siswa, orang tua, dan masyarakat umum dengan informasi seputar sekolah.

Panduan menjawab:
1. Selalu gunakan Bahasa Indonesia yang sopan dan ramah
2. Berikan informasi akurat seputar sekolah SMAN 2 KAUR
3. Untuk pertanyaan di luar konteks sekolah, arahkan kembali ke topik pendidikan
4. Jika tidak tahu jawabannya, katakan dengan jujur dan sarankan menghubungi pihak sekolah
5. Jaga jawaban tetap singkat dan informatif
6. Gunakan emoji secukupnya untuk membuat percakapan lebih ramah 😊

Informasi Sekolah:
- Nama: SMAN 2 KAUR
- Alamat: Jl. Pendidikan No. 123
- Telepon: (021) 1234567
- Email: info@smanegeri1.sch.id
- Website: www.smanegeri1.sch.id
- Jam Operasional: Senin-Jumat, 07:00 - 15:00 WIB
- Akreditasi: A
- Kurikulum: Kurikulum Merdeka

Layanan yang tersedia:
- Informasi pendaftaran siswa baru (PPDB)
- Informasi kegiatan dan ekstrakurikuler
- Jadwal pelajaran dan kalender akademik
- Informasi guru dan staff
- Pertanyaan umum tentang sekolah
EOT;
    }

    /**
     * Send a message to DeepSeek API.
     */
    public function chat(array $messages, ?string $systemPrompt = null): array
    {
        if (empty($this->apiKey)) {
            return [
                'success' => false,
                'message' => 'API key tidak dikonfigurasi. Silakan hubungi administrator.',
                'error' => 'API_KEY_MISSING',
            ];
        }

        try {
            $allMessages = [];

            // Add system prompt
            $allMessages[] = [
                'role' => 'system',
                'content' => $systemPrompt ?? $this->getSystemPrompt(),
            ];

            // Add conversation history
            foreach ($messages as $message) {
                $allMessages[] = [
                    'role' => $message['role'],
                    'content' => $message['content'],
                ];
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->baseUrl . '/chat/completions', [
                    'model' => $this->model,
                    'messages' => $allMessages,
                    'temperature' => 0.7,
                    'max_tokens' => 1000,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'message' => $data['choices'][0]['message']['content'] ?? 'Maaf, saya tidak bisa memberikan respons saat ini.',
                    'usage' => $data['usage'] ?? null,
                ];
            }

            Log::error('DeepSeek API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'message' => 'Maaf, terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi.',
                'error' => 'API_ERROR',
            ];
        } catch (\Exception $e) {
            Log::error('DeepSeek Service Exception', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'Maaf, layanan sementara tidak tersedia. Silakan coba lagi nanti.',
                'error' => 'SERVICE_UNAVAILABLE',
            ];
        }
    }

    /**
     * Simple one-shot chat (without history).
     */
    public function ask(string $question): string
    {
        $result = $this->chat([
            ['role' => 'user', 'content' => $question]
        ]);

        return $result['message'];
    }
}
