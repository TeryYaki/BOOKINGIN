<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Models\Movie;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController; // Buat controller ini atau pakai MainController


Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

// --- ROUTE PUBLIC ---
Route::get('/', function () {
    $nowShowing = Movie::where('status', 'now_showing')->latest()->get();
    $upcoming = Movie::where('status', 'upcoming')->latest()->get();
    return view('main', compact('nowShowing', 'upcoming'));
})->name('home');

Route::get('/movies', function () {
    $movies = Movie::latest()->get();
    return view('movies', compact('movies'));
})->name('movies');

Route::get('/film/{id}', function ($id) {
    $movie = Movie::findOrFail($id); 
    return view('film', compact('movie')); 
})->name('film');

// [BARU] Route API untuk Cek Kursi (Diletakkan di luar Auth agar Guest bisa lihat kursi)
Route::get('/api/seats', [BookingController::class, 'getOccupiedSeats'])->name('api.seats');

// Auth View & Logic
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/login-firebase', [AuthController::class, 'firebaseLogin']);
Route::post('/register-firebase', [AuthController::class, 'firebaseRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- ADMIN ROUTES (Middleware: Login & Role Admin) ---
Route::middleware(['auth', 'is_admin'])->group(function () {
    
    // Tampilan Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Proses Tambah Film
    Route::post('/admin/movie', [AdminController::class, 'store'])->name('admin.store');

    // [DIPINDAHKAN KE SINI] Proses Edit Film (Agar aman, hanya Admin)
    Route::put('/admin/movie/{id}', [AdminController::class, 'update'])->name('admin.update');

    // Proses Hapus Film
    Route::delete('/admin/movie/{id}', [AdminController::class, 'destroy'])->name('admin.delete');

    // ... di dalam Route::middleware(['auth', 'is_admin'])->group(function () { ...

    // CRUD STUDIO
    Route::get('/admin/studio/create', [App\Http\Controllers\StudioController::class, 'create'])->name('studio.create');
    Route::post('/admin/studio', [App\Http\Controllers\StudioController::class, 'store'])->name('studio.store');

    // CRUD JADWAL (SHOWTIME)
    Route::get('/admin/showtime/create', [App\Http\Controllers\ShowtimeController::class, 'create'])->name('showtime.create');
    Route::post('/admin/showtime', [App\Http\Controllers\ShowtimeController::class, 'store'])->name('showtime.store');

// ...
});


// --- USER ROUTES (Middleware: Login Only) ---
Route::middleware(['auth'])->group(function () {
    // Booking Flow
    Route::post('/booking/process', [BookingController::class, 'process'])->name('booking.process');
    Route::get('/payment', [BookingController::class, 'showPayment'])->name('payment.show');
    Route::get('/payment/success', [BookingController::class, 'success'])->name('payment.success');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});