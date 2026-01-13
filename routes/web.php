<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini kita mendaftarkan semua jalur aplikasi.
| Perhatikan bagian ->name('...'), itu kuncinya agar {{ route(...) }} berfungsi.
|
*/

// 1. Halaman Depan (Beranda)
Route::get('/', function () {
    return view('main');
})->name('home'); // <-- Nama ini dipanggil di navbar "Beranda"

// 2. Halaman Daftar Film
Route::get('/movies', function () {
    return view('movies'); // Pastikan file movies.blade.php ada
})->name('movies');

// 3. Halaman Detail Film (Untuk tombol "Book Now")
Route::get('/film', function () {
    return view('film'); // Pastikan file film.blade.php ada
})->name('film');


// --- AREA AUTHENTICATION (Login & Register) ---

// Halaman Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login'); // <-- Nama ini dipanggil di navbar "Login"

// Halaman Register
Route::get('/register', function () {
    return view('auth.register');
})->name('register'); // <-- Nama ini dipanggil di navbar "Daftar"


// --- LOGIKA BACKEND (Firebase & Logout) ---

// Proses Login & Register (Menerima data dari Javascript)
Route::post('/login-firebase', [AuthController::class, 'firebaseLogin']);
Route::post('/register-firebase', [AuthController::class, 'firebaseRegister']);

// Proses Logout (Tombol Keluar)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Admin (Opsional, jika Anda punya)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth']); // Hanya bisa diakses jika sudah login