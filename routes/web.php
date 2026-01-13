<?php

use Illuminate\Support\Facades\Route;

// Halaman utama (main page)
Route::get('/', function () {
    return view('main');
})->name('home');

// Halaman Login
Route::get('/login', function () {
    return view('auth.login'); // resources/views/auth/login.blade.php
})->name('login');

// Halaman Register
Route::get('/register', function () {
    return view('auth.register'); // resources/views/auth/register.blade.php
})->name('register');

// Halaman film baru
Route::get('/movies', function () {
    return view('movies');
})->name('movies');

Route::get('/film', function () {
    return view('film'); // resources/views/film.blade.php
})->name('film');

Route::post('/register-firebase', [App\Http\Controllers\AuthController::class, 'firebaseRegister']);
