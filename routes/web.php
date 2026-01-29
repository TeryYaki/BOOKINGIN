<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Models\Movie;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MovieController;

// --- ROUTE PUBLIC ---

Route::get('/', function () {
    $nowShowing = Movie::where('status', 'now_showing')->latest()->get();
    $upcoming = Movie::where('status', 'upcoming')->latest()->get();
    return view('main', compact('nowShowing', 'upcoming'));
})->name('home');

// [FIXED] Only keep this ONE line for movies. Delete the other one.
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');

Route::get('/film/{id}', function ($id) {
    $movie = Movie::findOrFail($id); 
    return view('film', compact('movie')); 
})->name('film');

Route::get('/api/seats', [BookingController::class, 'getOccupiedSeats'])->name('api.seats');

// --- AUTH ---
Route::get('/login', function () { return view('auth.login'); })->name('login');
Route::get('/register', function () { return view('auth.register'); })->name('register');
Route::post('/login-firebase', [AuthController::class, 'firebaseLogin']);
Route::post('/register-firebase', [AuthController::class, 'firebaseRegister']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- ADMIN ---
Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // Movie
    Route::post('/admin/movie', [AdminController::class, 'store'])->name('admin.store');
    Route::put('/admin/movie/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/admin/movie/{id}', [AdminController::class, 'destroy'])->name('admin.delete');

    // Studio
    Route::get('/admin/studio/create', [App\Http\Controllers\StudioController::class, 'create'])->name('studio.create');
    Route::post('/admin/studio', [App\Http\Controllers\StudioController::class, 'store'])->name('studio.store');
    Route::delete('/admin/studio/{id}', [App\Http\Controllers\StudioController::class, 'destroy'])->name('studio.delete');

    // Showtime
    Route::get('/admin/showtime/create', [App\Http\Controllers\ShowtimeController::class, 'create'])->name('showtime.create');
    Route::post('/admin/showtime', [App\Http\Controllers\ShowtimeController::class, 'store'])->name('showtime.store');
});

// --- USER ---
Route::middleware(['auth'])->group(function () {
    Route::post('/booking/process', [BookingController::class, 'process'])->name('booking.process');
    Route::get('/payment', [BookingController::class, 'showPayment'])->name('payment.show');
    Route::get('/payment/success', [BookingController::class, 'success'])->name('payment.success');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});