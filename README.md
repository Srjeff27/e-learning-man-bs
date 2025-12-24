# 🎓 SMAN 2 KAUR - Sistem Informasi Sekolah

<p align="center">
  <img src="public/images/logo.webp" alt="Logo SMAN 2 KAUR" width="120">
</p>

<p align="center">
  <strong>Website Sistem Informasi Sekolah Modern dengan AI Chatbot Terintegrasi</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/Tailwind%20CSS-4.x-38B2AC?style=flat-square&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Alpine.js-3.x-8BC0D0?style=flat-square&logo=alpine.js" alt="Alpine.js">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php" alt="PHP">
</p>

---

## 📋 Daftar Isi

- [Tentang Project](#-tentang-project)
- [Fitur Unggulan](#-fitur-unggulan)
- [Tech Stack](#-tech-stack)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Struktur Project](#-struktur-project)
- [Panduan Penggunaan](#-panduan-penggunaan)
- [API Endpoints](#-api-endpoints)
- [Screenshot](#-screenshot)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 🎯 Tentang Project

**SMAN 2 KAUR** adalah sistem informasi sekolah berbasis web yang dirancang untuk memudahkan pengelolaan dan penyebaran informasi di lingkungan sekolah. Website ini dilengkapi dengan **AI Chatbot (BINU)** yang dapat menjawab pertanyaan pengunjung secara real-time menggunakan teknologi DeepSeek AI.

### Tujuan Utama:
- Menyediakan informasi sekolah yang akurat dan mudah diakses
- Memfasilitasi komunikasi antara sekolah, siswa, dan orang tua
- Mengotomatisasi proses administrasi sekolah
- Memberikan layanan informasi 24/7 melalui AI Chatbot

---

## ✨ Fitur Unggulan

### 🌐 Website Publik

| Fitur | Deskripsi |
|-------|-----------|
| **🏠 Beranda Dinamis** | Hero slider dengan berita terbaru, statistik sekolah, dan quick links |
| **📰 Berita & Pengumuman** | Sistem manajemen konten untuk berita sekolah dengan kategori dan pencarian |
| **🖼️ Galeri Multimedia** | Galeri foto dan video kegiatan sekolah dengan lightbox viewer |
| **👨‍🏫 Profil Guru & Staff** | Direktori lengkap guru dan staff dengan foto dan informasi jabatan |
| **📅 Kalender Akademik** | Kalender interaktif menampilkan jadwal kegiatan dan hari libur |
| **📞 Halaman Kontak** | Form kontak dengan validasi dan peta lokasi |
| **🔍 Visi & Misi** | Halaman informasi visi, misi, dan tujuan sekolah |

### 🤖 AI Chatbot (BINU)

**BINU** (Buddy Informatif untuk Navigasi Umum) adalah asisten virtual berbasis AI yang terintegrasi di seluruh halaman website.

| Kemampuan | Deskripsi |
|-----------|-----------|
| **💬 Percakapan Natural** | Menjawab pertanyaan dalam Bahasa Indonesia dengan gaya ramah |
| **📚 Knowledge Base** | Informasi sekolah seperti jadwal, kontak, pendaftaran PPDB |
| **🔄 Session Persistence** | Menyimpan riwayat percakapan untuk konteks yang lebih baik |
| **⚡ Real-time Response** | Respons cepat menggunakan DeepSeek API |
| **📱 Mobile Friendly** | UI responsif dengan floating button di pojok kanan bawah |

### 👨‍💼 Panel Admin

| Fitur | Deskripsi |
|-------|-----------|
| **📊 Dashboard** | Overview statistik website dan aktivitas terbaru |
| **📝 Manajemen Berita** | CRUD berita dengan editor teks dan upload gambar |
| **🖼️ Manajemen Galeri** | Upload dan organisasi foto/video kegiatan |
| **👤 Manajemen User** | Pengelolaan akun admin, guru, dan siswa |
| **🏫 Profil Sekolah** | Edit informasi sekolah (visi, misi, fasilitas) |
| **📅 Kalender Event** | Manajemen event dan kegiatan sekolah |
| **🎯 Banner Management** | Pengaturan banner pengumuman di halaman utama |
| **📬 Manajemen Kontak** | Melihat dan merespons pesan dari form kontak |

### 👨‍🏫 Dashboard Guru

| Fitur | Deskripsi |
|-------|-----------|
| **🏫 Kelas Saya** | Daftar kelas yang diampu dengan jumlah siswa |
| **📋 Absensi** | Input dan rekap absensi siswa per pertemuan |
| **📚 Materi Pembelajaran** | Upload dan share materi ajar (PDF, dokumen) |
| **📝 Tugas** | Buat dan kelola tugas dengan deadline |
| **📊 Laporan** | Generate laporan absensi dan nilai dalam PDF |
| **📅 Jadwal Mengajar** | Lihat jadwal mengajar mingguan |

### 👨‍🎓 Dashboard Siswa

| Fitur | Deskripsi |
|-------|-----------|
| **📅 Jadwal Pelajaran** | Lihat jadwal pelajaran mingguan |
| **📚 Materi** | Akses materi pembelajaran dari guru |
| **📝 Tugas** | Lihat dan kumpulkan tugas |
| **📊 Nilai** | Lihat nilai tugas dan ujian |

---

## 🛠️ Tech Stack

### Backend
- **Framework**: Laravel 12.x
- **PHP**: 8.2+
- **Database**: SQLite (default) / MySQL / PostgreSQL
- **Authentication**: Laravel Fortify
- **PDF Generation**: DomPDF

### Frontend
- **CSS Framework**: Tailwind CSS 4.x
- **JavaScript**: Alpine.js 3.x
- **Build Tool**: Vite 7.x
- **Icons**: Heroicons (SVG inline)

### AI Integration
- **Chatbot Engine**: DeepSeek AI API
- **Model**: deepseek-chat

### Optimizations
- **Image Format**: WebP dengan fallback PNG
- **Caching**: Browser caching 1 tahun untuk static assets
- **Compression**: GZIP untuk CSS/JS
- **Lazy Loading**: Images dan content below-fold

---

## 💻 Persyaratan Sistem

| Komponen | Minimum | Recommended |
|----------|---------|-------------|
| PHP | 8.2 | 8.3+ |
| Composer | 2.x | Latest |
| Node.js | 18.x | 20.x LTS |
| npm | 9.x | 10.x |
| RAM | 512MB | 2GB+ |

### PHP Extensions Required:
- BCMath, Ctype, Fileinfo, JSON
- Mbstring, OpenSSL, PDO, Tokenizer
- XML, GD (untuk image processing)

---

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/website-sekolah-sma.git
cd website-sekolah-sma
```

### 2. Quick Setup (Recommended)

```bash
composer setup
```

Perintah ini akan otomatis:
- Install PHP dependencies
- Copy `.env.example` ke `.env`
- Generate application key
- Jalankan migrasi database
- Install npm dependencies
- Build assets production

### 3. Manual Setup

```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Install npm dependencies
npm install

# Build assets untuk production
npm run build

# Atau untuk development
npm run dev
```

### 4. Jalankan Server Development

```bash
# Cara mudah (server + queue + logs + vite sekaligus)
composer dev

# Atau manual
php artisan serve
```

Akses website di: `http://localhost:8000`

---

## ⚙️ Konfigurasi

### Environment Variables (.env)

```env
# Application
APP_NAME="SMAN 2 KAUR"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database (SQLite default)
DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite

# Untuk MySQL
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=sman2kaur
# DB_USERNAME=root
# DB_PASSWORD=

# DeepSeek AI API (untuk Chatbot)
DEEPSEEK_API_KEY=your_deepseek_api_key_here

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
```

### Konfigurasi Chatbot

API Key DeepSeek dapat diperoleh dari [platform.deepseek.com](https://platform.deepseek.com). 
Tambahkan ke `.env`:

```env
DEEPSEEK_API_KEY=sk-xxxxxxxxxxxxxxxxxxxxx
```

---

## 📁 Struktur Project

```
website-sekolah-sma/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controllers untuk panel admin
│   │   │   ├── Teacher/        # Controllers untuk dashboard guru
│   │   │   ├── Student/        # Controllers untuk dashboard siswa
│   │   │   ├── ChatbotController.php
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       ├── AdminMiddleware.php
│   │       ├── RoleMiddleware.php
│   │       └── CacheControlMiddleware.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── News.php
│   │   ├── Gallery.php
│   │   ├── Teacher.php
│   │   ├── Student.php
│   │   ├── Classroom.php
│   │   ├── ChatSession.php
│   │   └── ... (21 models)
│   └── Services/
│       ├── DeepSeekService.php     # AI Chatbot integration
│       └── ImageOptimizationService.php
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── images/
│   │   ├── logo.webp
│   │   └── icon-chatbot.webp
│   └── build/                  # Compiled assets
├── resources/
│   ├── css/
│   │   └── app.css            # Tailwind CSS
│   ├── js/
│   │   └── app.js             # Alpine.js
│   └── views/
│       ├── layouts/
│       ├── pages/              # Public pages
│       ├── admin/              # Admin panel views
│       ├── teacher/            # Teacher dashboard views
│       └── partials/           # Reusable components
├── routes/
│   └── web.php
├── storage/
│   └── app/public/            # User uploads
├── .env.example
├── composer.json
├── package.json
├── tailwind.config.js
└── vite.config.js
```

---

## 📖 Panduan Penggunaan

### Akun Default (Setelah Seeding)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@sman2kaur.sch.id | password |
| Guru | guru@sman2kaur.sch.id | password |
| Siswa | siswa@sman2kaur.sch.id | password |

### Alur Penggunaan

#### 1. Pengunjung (Guest)
```
🌐 Homepage → 📰 Baca Berita → 🖼️ Lihat Galeri → 💬 Chat dengan BINU
                                                   ↓
                                        🤖 Tanya informasi sekolah
```

#### 2. Admin
```
🔐 Login → 📊 Dashboard → Pilih Menu:
                          ├── 📝 Kelola Berita
                          ├── 🖼️ Kelola Galeri
                          ├── 👤 Kelola User
                          ├── 🏫 Edit Profil Sekolah
                          └── 📅 Kelola Kalender
```

#### 3. Guru
```
🔐 Login → 📊 Dashboard → Pilih Menu:
                          ├── 🏫 Lihat Kelas
                          ├── ✅ Input Absensi
                          ├── 📚 Upload Materi
                          ├── 📝 Buat Tugas
                          └── 📊 Generate Laporan
```

#### 4. Siswa
```
🔐 Login → 📊 Dashboard → Pilih Menu:
                          ├── 📅 Lihat Jadwal
                          ├── 📚 Download Materi
                          ├── 📝 Kerjakan Tugas
                          └── 📊 Lihat Nilai
```

---

## 🔌 API Endpoints

### Chatbot API

| Method | Endpoint | Deskripsi |
|--------|----------|-----------|
| POST | `/chatbot/session` | Membuat/mendapatkan session chat |
| POST | `/chatbot/send` | Mengirim pesan ke chatbot |
| POST | `/chatbot/clear` | Menghapus history chat |

### Contoh Request

```javascript
// Mengirim pesan
fetch('/chatbot/send', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
    },
    body: JSON.stringify({
        session_id: 'uuid-session-id',
        message: 'Kapan jadwal masuk sekolah?'
    })
});
```

---

## 📸 Screenshot

### Homepage
![Homepage](docs/screenshots/homepage.png)

### AI Chatbot BINU
![Chatbot](docs/screenshots/chatbot.png)

### Admin Dashboard
![Admin Dashboard](docs/screenshots/admin-dashboard.png)

### Teacher Dashboard
![Teacher Dashboard](docs/screenshots/teacher-dashboard.png)

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan buat Pull Request atau buka Issue untuk:

1. 🐛 Bug reports
2. 💡 Feature requests
3. 📝 Documentation improvements
4. 🎨 UI/UX enhancements

### Development Workflow

```bash
# 1. Fork repository
# 2. Clone fork Anda
git clone https://github.com/YOUR_USERNAME/website-sekolah-sma.git

# 3. Buat branch baru
git checkout -b feature/nama-fitur

# 4. Lakukan perubahan dan commit
git commit -m "feat: menambahkan fitur baru"

# 5. Push dan buat Pull Request
git push origin feature/nama-fitur
```

---

## 📄 Lisensi

Project ini dilisensikan di bawah [MIT License](LICENSE).

---

## 👨‍💻 Developer

<p align="center">
  <strong>Developed with ❤️ for SMAN 2 KAUR</strong>
</p>

<p align="center">
  <em>© 2024 SMAN 2 KAUR. All Rights Reserved.</em>
</p>
