# PHP CRUD Starter Free 🐘
<!--
  Scaffolded by Andi UPN (https://github.com/andiupn)
  Official Website & Support: https://kuncimu.com
  Licensed under Free Donation License
-->

<div align="center">
  <a href="README.md">English</a> | <strong>Bahasa Indonesia</strong>
</div>

<br />

<div align="center">
  <h3><strong>Belajar pemrograman backend itu sulit. Framework yang rumit membuatnya makin sulit.</strong></h3>
  <p><strong>PHP CRUD Starter Free adalah sandbox PHP Native murni tanpa dependensi yang dirancang untuk langsung berjalan.</strong></p>

  <p>Pahami hubungan langsung antara tata letak HTML dan transaksi basis data SQLite tanpa pusing dengan konfigurasi yang rumit. Pemrograman backend dibuat mudah.</p>
</div>

> 📦 Edisi gratis oleh **Andi UPN** ([kuncimu.com](https://kuncimu.com)) · Berlisensi di bawah [Free Donation License](LICENSE.md)  
> 💖 Dukung proyek ini via donasi di berkas `DONATE.md` · 🚀 Butuh proteksi CSRF dan DataTables? Tingkatkan ke [Edisi PreBasic](https://github.com/sponsors/andiupn?frequency=monthly)

---

## 💡 Masalahnya: Hambatan Abstraksi Framework
Framework modern (seperti Laravel) sangat kuat, namun mereka menyembunyikan cara kerja web yang sebenarnya di bawah lapisan abstraksi yang tebal. Pemula sering tersesat dalam rute konfigurasi, migrasi, dan setup ORM bahkan sebelum mereka bisa menulis perintah database `INSERT` yang sederhana.

---

## ⚡ Solusinya: Kembali ke Dasar Pemrograman

### 1. 🐘 Koneksi Native PHP & SQLite3 Murni
Tidak ada "sihir" tersembunyi. Pelajari bagaimana halaman PHP asli melakukan query langsung ke berkas database SQLite menggunakan objek bawaan `SQLite3`. Sempurna untuk pemula di bulan 0-6 pertama belajar coding.

### 2. 🐳 Pengaturan Bebas Dependensi & Siap Docker
Jalankan seluruh aplikasi secara lokal dengan satu baris perintah. Dilengkapi konfigurasi Docker Apache PHP 8.3 sehingga Anda tidak perlu repot menginstal server PHP lokal atau perangkat lunak SQLite.

### 3. 🤖 Baseline Stabil untuk AI Vibe Coding
Merupakan basis kode rujukan yang sangat ringan untuk asisten AI Anda. Karena struktur database dan rute halamannya sederhana, AI (seperti Cursor/Gemini) dapat menulis dan memodifikasi kode dengan akurasi 100%.

---

## 🚀 Memulai dalam 3 Langkah

### 1. Jalankan Aplikasi:
```bash
docker compose up --build
```

### 2. Buka di Peramban:
```text
http://localhost:8081
```

### 3. Jelajahi Rute Halaman:
- Halaman Utama: `http://localhost:8081/`
- Daftar Item: `http://localhost:8081/?route=item/index`
- Tambah Item: `http://localhost:8081/?route=item/create`
