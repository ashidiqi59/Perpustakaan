<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeaturedBookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AttendanceController;

Route::get('/', [BookController::class, 'publicIndex'])->name('home');

// Public Book Routes
Route::get('/books/{book}', [BookController::class, 'publicShow'])->name('books.show');

// Public Collection Route
Route::get('/koleksi', [BookController::class, 'collection'])->name('books.collection');

// ============================================================
// User Routes (protected by auth middleware)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/my-loans', [LoanController::class, 'myLoans'])->name('my-loans');
    Route::get('/my-attendance', [AttendanceController::class, 'userHistory'])->name('my-attendance');
    Route::post('/borrow', [LoanController::class, 'borrow'])->name('borrow');

    // Return request (user generates return barcode)
    Route::post('/loans/{loan}/request-return', [LoanController::class, 'requestReturn'])->name('loans.request-return');
    Route::post('/loans/{loan}/cancel', [LoanController::class, 'cancelLoan'])->name('loans.cancel');
    Route::post('/loans/{loan}/cancel-return', [LoanController::class, 'cancelReturn'])->name('loans.cancel-return');

    // Profile & Biodata Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Kartu Anggota: generate barcode jika belum ada
    Route::post('/member-barcode/generate', [AttendanceController::class, 'generateBarcode'])->name('member-barcode.generate');
});

// ============================================================
// Petugas Routes (only for petugas and admin)
// ============================================================
Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::post('/scan/loan', [PetugasController::class, 'scanLoan'])->name('scan.loan');
    Route::post('/scan/return', [PetugasController::class, 'scanReturn'])->name('scan.return');
    Route::post('/api/scan', [PetugasController::class, 'apiScan'])->name('api.scan');

    // Presensi / Kartu Anggota
    Route::post('/api/scan-member', [AttendanceController::class, 'apiScan'])->name('api.scan-member');
    Route::get('/attendance', [AttendanceController::class, 'history'])->name('attendance.history');
});

// ============================================================
// Admin Routes
// ============================================================
Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');

// Admin Users Routes (View, Edit, Delete, Create Petugas)
Route::resource('/admin/users', UserController::class)->names([
    'index'   => 'admin.users.index',
    'create'  => 'admin.users.create',
    'store'   => 'admin.users.store',
    'show'    => 'admin.users.show',
    'edit'    => 'admin.users.edit',
    'update'  => 'admin.users.update',
    'destroy' => 'admin.users.destroy',
])->middleware('auth');

// Admin Books Routes (CRUD)
Route::resource('/admin/books', BookController::class)->names([
    'index'   => 'admin.books.index',
    'create'  => 'admin.books.create',
    'store'   => 'admin.books.store',
    'show'    => 'admin.books.show',
    'edit'    => 'admin.books.edit',
    'update'  => 'admin.books.update',
    'destroy' => 'admin.books.destroy',
])->middleware('auth');

// Admin Featured Books (Buku Beranda) Routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/featured-books', [FeaturedBookController::class, 'index'])->name('featured-books.index');
    Route::post('/featured-books/{book}', [FeaturedBookController::class, 'update'])->name('featured-books.update');
});

// Public API for featured books
Route::get('/api/featured-books', [FeaturedBookController::class, 'apiFeatured'])->name('api.featured-books');

// Admin Loans Routes (CRUD)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/loans', [LoanController::class, 'adminIndex'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'adminCreate'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'adminStore'])->name('loans.store');
    Route::get('/loans/{loan}', [LoanController::class, 'adminShow'])->name('loans.show');
    Route::get('/loans/{loan}/edit', [LoanController::class, 'adminEdit'])->name('loans.edit');
    Route::put('/loans/{loan}', [LoanController::class, 'adminUpdate'])->name('loans.update');
    Route::delete('/loans/{loan}', [LoanController::class, 'adminDestroy'])->name('loans.destroy');
});

// ============================================================
// Auth Routes
// ============================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Google OAuth Routes
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// API Routes for Registration Validation
Route::post('/api/check-npm', [AuthController::class, 'checkNpm'])->name('api.check-npm');
Route::post('/api/check-email', [AuthController::class, 'checkEmail'])->name('api.check-email');
