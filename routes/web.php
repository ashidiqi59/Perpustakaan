<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    // Halaman utama perpustakaan
    $popularBooks = \App\Models\Book::orderBy('stock', 'desc')->take(5)->get();
    return view('home', compact('popularBooks'));
})->name('home');

Route::get('/admin', function () {
    // Halaman admin dashboard
    return view('admin');
})->name('admin.dashboard');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
