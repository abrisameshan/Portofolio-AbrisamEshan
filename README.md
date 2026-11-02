# 🌐 Portfolio SIJA — Hybrid Creative & Engineering

Website portofolio modern bertema **Clean & Modern Monochrome** yang dirancang khusus untuk siswa SMK jurusan **SIJA (Sistem Informasi, Jaringan, dan Aplikasi)** yang memiliki perpaduan talenta:
1. 📷 **Photographer** (Galeri foto interaktif dengan Lightbox & HUD Metadata EXIF kamera).
2. 💻 **Software Developer** (Showcase web modern dibangun dengan **Laravel 11**, **Vue.js 3**, **Inertia.js**, & **Tailwind CSS v4**).
3. 🛡️ **Cybersecurity & Networking Enthusiast** (Interactive Terminal CLI emulator, lab MikroTik & Cisco, tooling reconnaissance).

---

## 🚀 Fitur Utama

- **Hero & Persona Identity**: Menampilkan profil hybrid (SIJA 4-Years, Developer, Photographer) lengkap dengan live status.
- **Tiga Pilar Keahlian**:
  - *Photography & Visual Arts* (Lightroom, Photoshop, Street/Portrait, Manual Exposure).
  - *Software & Web Development* (PHP, Laravel 11, Vue 3, Inertia.js, Tailwind CSS, REST APIs).
  - *Networking & Cybersecurity* (Linux Administration, MikroTik RouterOS, Cisco Packet Tracer, Wireshark, Nmap, Basic CTF).
- **Galeri Fotografi & Lightbox EXIF**:
  - Filter kategori (*Street*, *Portrait*, *Tech & Lab*, *Architecture*).
  - Tampilan foto monokromatik dengan hover effect berwarna.
  - Lightbox modal dengan pembacaan data teknis kamera (Kamera, Lensa, Aperture, Shutter Speed, ISO, Lokasi).
  - Navigasi keyboard (panah kiri/kanan & tombol `Esc`).
- **Showcase Proyek Rekayasa & Lab**:
  - Filter kategori (*Web Development*, *Networking & Labs*, *Cybersecurity*).
  - Link langsung ke GitHub repository & Live demo.
- **Interactive Terminal CLI (`~`)**:
  - Fitur interaktif khas anak jaringan/cybersecurity yang dapat dibuka kapan saja melalui tombol navigasi atau menekan tombol backtick (`` ` ``).
  - Perintah yang didukung: `help`, `whoami`, `skills`, `neofetch`, `projects`, `nmap`, `cat bio`, `clear`, `exit`.
- **Formulir Kontak Terintegrasi**:
  - Pilihan kategori layanan (*General*, *Photography*, *Laravel/Vue Project*, *Network & Lab*).
  - Validasi otomatis dan pesan tersimpan di database SQLite lokal.

---

## 🛠️ Cara Menjalankan Project

### 1. Buka Terminal di folder project:
```bash
cd C:\Users\abris\.gemini\antigravity\scratch\portfolio-sija
```

### 2. Jalankan Backend Laravel:
```bash
php -d extension=pdo_sqlite artisan serve
```
> Aplikasi backend akan berjalan di `http://127.0.0.1:8000`.

### 3. Jalankan Frontend Vite (Mode Pengembangan):
Buka terminal baru di folder yang sama:
```bash
npm.cmd run dev
```

### 4. Build untuk Production:
Jika ingin membuat aset statis tanpa menjalankan server vite:
```bash
npm.cmd run build
```

---

## 📂 Struktur Berkas Penting

```
portfolio-sija/
├── app/
│   ├── Http/Controllers/
│   │   └── PortfolioController.php      # Mengatur data profil, foto, project & kontak
│   └── Models/
│       └── ContactMessage.php           # Model pesan kontak
├── database/
│   ├── database.sqlite                  # Database SQLite lokal
│   └── migrations/                      # Migrasi tabel pesan kontak
├── resources/
│   ├── views/
│   │   └── app.blade.php                # Template utama Inertia + Font
│   ├── css/
│   │   └── app.css                      # Tailwind CSS v4 styling & scrollbar
│   └── js/
│       ├── app.js                       # Inisialisasi Vue 3 & Inertia
│       ├── Pages/
│       │   └── Home.vue                 # Halaman utama portofolio
│       └── Components/
│           ├── Navbar.vue               # Navigasi sticky monokrom
│           ├── HeroSection.vue          # Hero banner & statistik
│           ├── SkillPillars.vue         # 3 pilar disiplin SIJA
│           ├── PhotoGallery.vue         # Galeri foto + Lightbox EXIF
│           ├── ProjectShowcase.vue      # Kartu proyek web, lab & cyber
│           ├── TerminalDrawer.vue       # Interactive CLI simulator
│           ├── ContactSection.vue       # Form kontak Inertia
│           └── Footer.vue               # Footer & copyright
```
