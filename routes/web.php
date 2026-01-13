<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Halaman Utama
Route::get('/', function () {
    return view('main');
})->name('home');

// Halaman Film
Route::get('/movies', function () { return view('movies'); })->name('movies');
Route::get('/film', function () { return view('film'); })->name('film');

// --- AUTH ROUTE ---

// Menampilkan Halaman (Blade)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

// Proses Ajax dari Firebase (Javascript mengirim ke sini)
Route::post('/login-firebase', [AuthController::class, 'firebaseLogin']);
Route::post('/register-firebase', [AuthController::class, 'firebaseRegister']);

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Contoh Halaman Khusus Admin (Opsional)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return "Halo " . Auth::user()->name . ", Role Anda: " . Auth::user()->role;
    });
    
    // Route khusus Admin
    Route::get('/admin/dashboard', function() {
        if(Auth::user()->role !== 'admin') return redirect('/');
        return "Selamat Datang di Halaman Admin";
    });
});