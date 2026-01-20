# 🎬 BOOKINGIN - Sistem Pemesanan Tiket Bioskop Modern

**BOOKINGIN** adalah aplikasi berbasis web yang dibangun menggunakan **Laravel** dan terintegrasi dengan **Firebase** untuk autentikasi dan penyimpanan data transaksi secara *real-time*. Aplikasi ini menawarkan pengalaman pemesanan tiket bioskop yang cepat, aman, dan responsif dengan antarmuka modern (Glassmorphism & Dark Mode).

![Bookingin Banner](public/Images/the-premiere-1.jpg)

---

## 🚀 Fitur Utama

### 👤 Pengguna (User)
- **Autentikasi Modern**: Login & Register menggunakan **Firebase Authentication**.
- **Jelajah Film**: Melihat daftar film *Now Showing* (Sedang Tayang) dan *Upcoming*.
- **Detail Film**: Informasi lengkap mengenai sinopsis dan poster film.
- **Pemesanan Tiket**: Memilih film, jadwal, dan jumlah kursi.
- **Simulasi Pembayaran**: Alur pembayaran tiket yang interaktif.
- **E-Ticket**: Menerima tiket digital setelah transaksi berhasil.
- **Profil Pengguna**: Melihat informasi akun yang terintegrasi.

### 🛡️ Admin (Administrator)
- **Dashboard Statistik**: Memantau total pendapatan, tiket terjual, dan jumlah film aktif.
- **Laporan Real-time**: Melihat data transaksi tiket yang masuk langsung dari **Firebase Realtime Database**.
- **Manajemen Film**: Menambah film baru (judul, poster, status tayang) dan menghapus film lama.
- **Keamanan**: Akses dashboard dilindungi oleh Middleware khusus admin.

---

## 🛠️ Teknologi yang Digunakan

- **Backend**: [Laravel 11](https://laravel.com) (PHP Framework)
- **Frontend**: Blade Templating, [Tailwind CSS](https://tailwindcss.com), JavaScript (ES6)
- **Database Relasional**: MySQL (Data User & Film)
- **NoSQL / Realtime**: [Firebase Realtime Database](https://firebase.google.com) (Data Transaksi Tiket)
- **Autentikasi**: Firebase Auth (Email/Password) & Laravel Sanctum/Session
- **Assets Bundler**: Vite

---

## ⚙️ Persyaratan Sistem

Sebelum menjalankan proyek ini, pastikan komputer Anda memiliki:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database
- Akun Google Firebase (untuk file `firebase_credentials.json`)

---

## 📥 Cara Instalasi

Ikuti langkah-langkah berikut untuk menjalankan proyek di komputer lokal:

### 1. Clone Repositori
git clone [https://github.com/username-anda/bookingin.git](https://github.com/username-anda/bookingin.git)
cd bookingin

### 2. Install Dependencies
Install paket PHP dan Node.js yang diperlukan:
composer install
npm install

### 3. Konfigurasi Environment (.env)
Salin file .env.example menjadi .env:
cp .env.example .env

Buka file .env dan atur konfigurasi database MySQL Anda:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bookingin_db
DB_USERNAME=root
DB_PASSWORD=

Tambahkan lokasi file kredensial Firebase Anda (simpan file JSON dari Firebase Console ke storage/app/):
FIREBASE_CREDENTIALS=storage/app/firebase_credentials.json

### 4. Konfigurasi Frontend (Firebase JS)
Buka file resources/views/auth/login.blade.php dan register.blade.php, lalu sesuaikan konfigurasi Firebase SDK dengan project Anda:
const firebaseConfig = {
    apiKey: "API_KEY_ANDA",
    authDomain: "PROJECT_ID.firebaseapp.com",
    projectId: "PROJECT_ID",
    // ... konfigurasi lainnya
};

### 5. Generate Key & Migrasi Database
Generate key aplikasi Laravel dan jalankan migrasi tabel:
php artisan key:generate
php artisan migrate

### 6. Build Assets & Jalankan Server
Compile aset frontend dan jalankan server lokal:
npm run build
php artisan serve

## 🔐 Akun Admin Demo

Secara default, aplikasi ini tidak menyediakan akun admin bawaan (seeder) demi alasan keamanan. Anda dapat membuat akun admin sendiri dengan langkah berikut:

1.  **Daftar Akun**: Buka halaman `/register` dan buat akun baru seperti pengguna biasa.
2.  **Akses Database**: Buka pengelola database lokal Anda (seperti phpMyAdmin, DBeaver, atau TablePlus).
3.  **Ubah Role**:
    * Cari tabel `users`.
    * Temukan baris data akun yang baru saja Anda buat.
    * Ubah nilai pada kolom **`role`** dari `'user'` menjadi **`'admin'`**.
4.  **Akses Dashboard**: Logout dari aplikasi, lalu Login kembali. Sistem akan mendeteksi peran Anda dan otomatis mengarahkan ke **Dashboard Admin**.

---

## 📂 Struktur Folder Penting

Memahami struktur folder akan membantu Anda dalam mengembangkan fitur lebih lanjut:

- **`app/Http/Controllers`**
  - `AdminController.php`: Mengelola logika dashboard, statistik pendapatan, dan laporan real-time dari Firebase.
  - `AuthController.php`: Menangani proses autentikasi (Login/Register) menggunakan Firebase Auth & Laravel Session.
  - `BookingController.php`: Mengurus alur pemesanan tiket, validasi kursi, dan penyimpanan transaksi.

- **`resources/views`**
  - `admin/dashboard.blade.php`: Tampilan panel admin dengan grafik dan tabel laporan.
  - `auth/`: Berisi file `login.blade.php` dan `register.blade.php` dengan desain Glassmorphism.
  - `main.blade.php`: Halaman utama (Landing Page) yang menampilkan daftar film.

- **`routes/web.php`**
  - Berisi definisi seluruh rute URL aplikasi, termasuk rute yang diproteksi oleh Middleware Admin.

- **`storage/app`**
  - `firebase_credentials.json`: File kunci rahasia untuk koneksi ke Firebase (pastikan file ini ada).

---

## 🤝 Kontribusi

Kami sangat terbuka terhadap kontribusi! Jika Anda ingin menambahkan fitur baru atau memperbaiki bug:

1.  **Fork** repositori ini ke akun GitHub Anda.
2.  Buat **Branch** baru untuk fitur Anda (`git checkout -b fitur-baru`).
3.  Lakukan **Commit** perubahan Anda (`git commit -m 'Menambahkan fitur pembayaran QRIS'`).
4.  **Push** ke branch tersebut (`git push origin fitur-baru`).
5.  Buat **Pull Request** dan jelaskan perubahan yang Anda buat.

---

## 📝 Lisensi

Proyek ini didistribusikan di bawah lisensi **[MIT License](https://opensource.org/licenses/MIT)**.
Anda bebas untuk menggunakan, memodifikasi, dan mendistribusikan ulang kode sumber ini untuk keperluan pribadi maupun komersial.

---

**Happy Coding! 🚀**
*Dibuat oleh Tim Bookingin*
