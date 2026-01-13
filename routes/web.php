<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Models\Movie;

// Route Public
Route::get('/', function () {
    $nowShowing = Movie::where('status', 'now_showing')->latest()->get();
    $upcoming = Movie::where('status', 'upcoming')->latest()->get();
    return view('main', compact('nowShowing', 'upcoming'));
})->name('home');

Route::get('/movies', function () {
    $movies = Movie::latest()->get();
    return view('movies', compact('movies'));
})->name('movies');

// 3. Halaman Detail Film (Dinamis mengambil ID)
Route::get('/film/{id}', function ($id) {
    $movie = Movie::findOrFail($id); // Cari film berdasarkan ID, jika tidak ada tampilkan 404
    return view('film', compact('movie')); // Kirim data $movie ke view
})->name('film');

// Auth
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/login-firebase', [AuthController::class, 'firebaseLogin']);
Route::post('/register-firebase', [AuthController::class, 'firebaseRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ... (kode public di atas biarkan saja) ...

// ADMIN DASHBOARD (Sekarang sudah aman pakai alias 'is_admin')
Route::middleware(['auth', 'is_admin'])->group(function () {
    
    // Tampilan Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Proses Tambah Film
    Route::post('/admin/movie', [AdminController::class, 'store'])->name('admin.store');

    // Proses Hapus Film
    Route::delete('/admin/movie/{id}', [AdminController::class, 'destroy'])->name('admin.delete');
});

// --- BAGIAN INI KITA KOSONGKAN DULU AGAR TIDAK ERROR ---
// Nanti kita isi lagi setelah Middleware jadi.