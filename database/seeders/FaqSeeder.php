<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'category' => 'Pendaftaran',
                'question' => 'Bagaimana cara mendaftar siswa baru (PPDB)?',
                'answer' => 'Pendaftaran siswa baru dilakukan secara online melalui website PPDB Dinas Pendidikan. Persyaratan meliputi: ijazah/SKHUN SMP, akta kelahiran, kartu keluarga, pas foto 3x4. Pendaftaran biasanya dibuka pada bulan Juni-Juli setiap tahunnya.',
            ],
            [
                'category' => 'Pendaftaran',
                'question' => 'Berapa biaya pendaftaran dan SPP bulanan?',
                'answer' => 'Sebagai sekolah negeri, biaya pendidikan sangat terjangkau. Untuk informasi biaya terbaru, silakan hubungi bagian Tata Usaha sekolah atau kunjungi langsung ke sekolah.',
            ],
            [
                'category' => 'Akademik',
                'question' => 'Kurikulum apa yang digunakan?',
                'answer' => 'SMAN 2 KAUR menggunakan Kurikulum Merdeka yang memberikan fleksibilitas bagi siswa dalam memilih mata pelajaran sesuai minat dan bakat.',
            ],
            [
                'category' => 'Akademik',
                'question' => 'Jam operasional sekolah?',
                'answer' => 'Kegiatan belajar mengajar berlangsung Senin-Jumat, pukul 07:00 - 15:00 WIB. Pada hari tertentu ada kegiatan ekstrakurikuler sampai pukul 17:00 WIB.',
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'Apa saja fasilitas yang tersedia di sekolah?',
                'answer' => 'Fasilitas meliputi: laboratorium IPA (Fisika, Kimia, Biologi), laboratorium komputer, perpustakaan, lapangan olahraga, musholla, kantin, UKS, dan ruang kelas ber-AC.',
            ],
            [
                'category' => 'Ekstrakurikuler',
                'question' => 'Apa saja ekstrakurikuler yang tersedia?',
                'answer' => 'Tersedia berbagai ekstrakurikuler: OSIS, Pramuka, PMR, Paskibra, Basket, Futsal, Voli, Badminton, Seni Musik, Paduan Suara, English Club, KIR (Karya Ilmiah Remaja), Robotika, dan Jurnalistik.',
            ],
            [
                'category' => 'Kontak',
                'question' => 'Bagaimana cara menghubungi sekolah?',
                'answer' => 'Anda dapat menghubungi sekolah melalui: Telepon (021) 1234567, Email info@smanegeri1.sch.id, atau datang langsung ke Jl. Pendidikan No. 123 pada jam operasional.',
            ],
            [
                'category' => 'Akademik',
                'question' => 'Bagaimana sistem penilaian di sekolah?',
                'answer' => 'Penilaian menggunakan sistem berbasis kompetensi meliputi: penilaian harian, penilaian tengah semester (PTS), penilaian akhir semester (PAS), dan penilaian proyek/praktikum.',
            ],
        ];

        foreach ($faqs as $index => $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['order' => $index + 1, 'is_active' => true])
            );
        }

        $this->command->info('FAQ seeder completed with ' . count($faqs) . ' questions.');
    }
}
