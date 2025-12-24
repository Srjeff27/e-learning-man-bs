<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 0. DATA USER (DEFAULT ADMIN)
        $admin = \App\Models\User::firstOrCreate(
            ['email' => 'admin@sman2kaur.sch.id'],
            [
                'name' => 'Administrator',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );
        $this->command->info('User Admin berhasil dibuat/ditemukan.');

        // 1. DATA GURU
        $teachers = [
            [
                'name' => 'Drs. H. Ahmad Dahlan, M.Pd.',
                'nip' => '19650101 199003 1 001',
                'subject' => 'Kepala Sekolah',
                'is_active' => true,
                'bio' => 'Kepala Sekolah yang visioner dan berdedikasi tinggi.',
            ],
            [
                'name' => 'Siti Aminah, S.Pd., M.Si.',
                'nip' => '19750505 200012 2 005',
                'subject' => 'Matematika',
                'is_active' => true,
                'bio' => 'Guru Matematika yang menyenangkan dan inovatif.',
            ],
            [
                'name' => 'Budi Santoso, S.Kom.',
                'nip' => '19880808 201101 1 008',
                'subject' => 'TIK / Informatika',
                'is_active' => true,
                'bio' => 'Ahli teknologi dan pemrograman.',
            ],
            [
                'name' => 'Ratna Sari, S.Pd.',
                'nip' => '19900202 201403 2 010',
                'subject' => 'Bahasa Inggris',
                'is_active' => true,
                'bio' => 'Mengajar dengan hati dan metode kreatif.',
            ],
            [
                'name' => 'Dedi Kurniawan, S.Pd.Or.',
                'nip' => '19851111 200904 1 012',
                'subject' => 'PJOK',
                'is_active' => true,
                'bio' => 'Selalu bersemangat memajukan olahraga sekolah.',
            ],
        ];

        foreach ($teachers as $t) {
            \App\Models\Teacher::updateOrCreate(
                ['nip' => $t['nip']],
                [
                    'full_name' => $t['name'],
                    'subject_specialty' => $t['subject'],
                    'is_active' => $t['is_active'],
                    'bio' => $t['bio'],
                ]
            );
        }
        $this->command->info('Data Guru berhasil dibuat.');


        // 2. DATA BERITA
        $categories = ['Berita', 'Prestasi', 'Artikel', 'Pengumuman'];
        for ($i = 1; $i <= 10; $i++) {
            $title = "Judul Berita " . $i . " Terbaru Hari Ini";
            $slug = Str::slug($title);

            \App\Models\News::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'content' => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>',
                    'featured_image' => 'news_placeholder.jpg',
                    'category' => $categories[array_rand($categories)],
                    'is_published' => true,
                    'published_at' => Carbon::now()->subDays(rand(0, 30)),
                    'is_featured' => $i <= 3,
                    'views' => rand(10, 500),
                    'author_id' => $admin->id,
                ]
            );
        }
        $this->command->info('Data Berita berhasil dibuat.');


        // 3. DATA GALERI (FOTO & VIDEO)
        // Foto
        for ($i = 1; $i <= 6; $i++) {
            \App\Models\Gallery::updateOrCreate(
                ['title' => "Kegiatan Siswa " . $i],
                [
                    'description' => "Dokumentasi kegiatan siswa di sekolah.",
                    'type' => 'photo',
                    'file_path' => 'gallery_placeholder.jpg',
                    'category' => 'Kegiatan',
                    'is_featured' => true,
                    'uploaded_by' => $admin->id,
                ]
            );
        }
        // Video
        $videos = [
            'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'https://www.youtube.com/embed/ScMzIvxBSi4',
        ];
        foreach ($videos as $idx => $url) {
            \App\Models\Gallery::updateOrCreate(
                ['title' => "Video Profil Sekolah " . ($idx + 1)],
                [
                    'description' => "Video profil singkat SMAN 2 KAUR.",
                    'type' => 'video',
                    'file_path' => $url,
                    'category' => 'Profil',
                    'is_featured' => true,
                    'uploaded_by' => $admin->id,
                ]
            );
        }
        $this->command->info('Data Galeri berhasil dibuat.');


        // 4. DATA CALENDAR / EVENTS
        $events = [
            [
                'title' => 'Hari Pertama Sekolah',
                'description' => 'Awal masuk tahun ajaran baru 2025/2026',
                'event_date' => '2025-07-14 07:00:00',
                'semester' => 'ganjil',
                'academic_year' => '2025/2026',
                'event_type' => 'primary',
                'category' => 'Akademik',
                'is_all_day' => true,
                'color' => '#3b82f6',
            ],
            [
                'title' => 'Masa Pengenalan Lingkungan Sekolah (MPLS)',
                'description' => 'Kegiatan untuk siswa baru',
                'event_date' => '2025-07-15 07:00:00',
                'end_date' => '2025-07-17 14:00:00',
                'semester' => 'ganjil',
                'academic_year' => '2025/2026',
                'event_type' => 'primary',
                'category' => 'Kesiswaan',
                'color' => '#3b82f6',
            ],
            [
                'title' => 'HUT RI ke-80',
                'description' => 'Upacara bendera peringatan kemerdekaan',
                'event_date' => '2025-08-17 07:00:00',
                'semester' => 'ganjil',
                'academic_year' => '2025/2026',
                'event_type' => 'danger',
                'category' => 'Hari Besar',
                'is_all_day' => true,
                'color' => '#ef4444',
            ],
            [
                'title' => 'Penilaian Tengah Semester (PTS)',
                'description' => 'Ujian tengah semester ganjil',
                'event_date' => '2025-09-22 07:00:00',
                'end_date' => '2025-09-27 12:00:00',
                'semester' => 'ganjil',
                'academic_year' => '2025/2026',
                'event_type' => 'warning',
                'category' => 'Evaluasi',
                'color' => '#f59e0b',
            ],
            [
                'title' => 'Penilaian Akhir Semester (PAS)',
                'description' => 'Ujian akhir semester ganjil',
                'event_date' => '2025-12-01 07:00:00',
                'end_date' => '2025-12-06 12:00:00',
                'semester' => 'ganjil',
                'academic_year' => '2025/2026',
                'event_type' => 'warning',
                'category' => 'Evaluasi',
                'color' => '#f59e0b',
            ],
            [
                'title' => 'Libur Semester Ganjil',
                'description' => 'Libur akhir semester',
                'event_date' => '2025-12-22 00:00:00',
                'end_date' => '2026-01-03 23:59:59',
                'semester' => 'ganjil',
                'academic_year' => '2025/2026',
                'event_type' => 'success',
                'category' => 'Libur',
                'color' => '#22c55e',
            ],
            [
                'title' => 'Masuk Semester Genap',
                'description' => 'Awal kegiatan belajar semester genap',
                'event_date' => '2026-01-05 07:00:00',
                'semester' => 'genap',
                'academic_year' => '2025/2026',
                'event_type' => 'primary',
                'category' => 'Akademik',
                'is_all_day' => true,
                'color' => '#3b82f6',
            ],
            [
                'title' => 'Ujian Sekolah (Kelas XII)',
                'description' => 'Ujian akhir untuk kelas 12',
                'event_date' => '2026-03-16 07:00:00',
                'end_date' => '2026-03-21 12:00:00',
                'semester' => 'genap',
                'academic_year' => '2025/2026',
                'event_type' => 'warning',
                'category' => 'Evaluasi',
                'color' => '#f59e0b',
            ],
            [
                'title' => 'Libur Hari Raya Idul Fitri',
                'description' => 'Perkiraan libur lebaran',
                'event_date' => '2026-03-31 00:00:00',
                'end_date' => '2026-04-07 23:59:59',
                'semester' => 'genap',
                'academic_year' => '2025/2026',
                'event_type' => 'success',
                'category' => 'Hari Besar',
                'color' => '#22c55e',
            ],
            [
                'title' => 'Penilaian Akhir Tahun (PAT)',
                'description' => 'Ujian kenaikan kelas',
                'event_date' => '2026-06-08 07:00:00',
                'end_date' => '2026-06-13 12:00:00',
                'semester' => 'genap',
                'academic_year' => '2025/2026',
                'event_type' => 'warning',
                'category' => 'Evaluasi',
                'color' => '#f59e0b',
            ],
            [
                'title' => 'Pembagian Rapor',
                'description' => 'Pembagian hasil belajar semester genap',
                'event_date' => '2026-06-19 08:00:00',
                'semester' => 'genap',
                'academic_year' => '2025/2026',
                'event_type' => 'info',
                'category' => 'Akademik',
                'is_all_day' => true,
                'color' => '#06b6d4',
            ],
        ];

        foreach ($events as $event) {
            \App\Models\Event::updateOrCreate(
                ['title' => $event['title'], 'event_date' => $event['event_date']],
                $event
            );
        }
        $this->command->info('Data Kalender Akademik berhasil dibuat.');


        // 5. DATA BANNER (Teks Pengumuman)
        \App\Models\Banner::updateOrCreate(
            ['title' => 'Selamat Datang di SMAN 2 KAUR'],
            [
                'content' => 'Mewujudkan Generasi Cerdas, Berkarakter, dan Berprestasi.',
                'link' => '/profil',
                'link_text' => 'Selengkapnya',
                'order' => 1,
                'is_active' => true,
            ]
        );
        \App\Models\Banner::updateOrCreate(
            ['title' => 'Penerimaan Peserta Didik Baru (PPDB)'],
            [
                'content' => 'Telah dibuka pendaftaran siswa baru tahun ajaran 2025/2026.',
                'link' => '/kontak',
                'link_text' => 'Daftar Sekarang',
                'order' => 2,
                'is_active' => true,
            ]
        );
        $this->command->info('Data Banner berhasil dibuat.');


        // 6. DATA KONTAK
        \App\Models\Contact::updateOrCreate(
            ['email' => 'budi@example.com', 'subject' => 'informasi'],
            [
                'name' => 'Budi Utomo',
                'message' => 'Halo min, kapan pendaftaran PPDB dibuka?',
                'is_read' => false,
            ]
        );
        \App\Models\Contact::updateOrCreate(
            ['email' => 'siti@example.com', 'subject' => 'kerjasama'],
            [
                'name' => 'Siti Aisyah',
                'message' => 'Kami dari Universitas Bengkulu ingin mengajukan sosialisasi.',
                'is_read' => true,
            ]
        );
        $this->command->info('Data Pesan Kontak berhasil dibuat.');
    }
}
