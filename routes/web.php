<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoanController;

Route::get('/', [BookController::class, 'publicIndex'])->name('home');

// Public Book Routes
Route::get('/books/{book}', [BookController::class, 'publicShow'])->name('books.show');

// Public Collection Route
Route::get('/koleksi', [BookController::class, 'collection'])->name('books.collection');

// User Loan Routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    Route::get('/my-loans', [LoanController::class, 'myLoans'])->name('my-loans');
    Route::post('/borrow', [LoanController::class, 'borrow'])->name('borrow');
});

Route::get('/admin', function () {
    return view('admin');
})->name('admin.dashboard')->middleware('auth');

// Admin Users Routes (View, Edit, Delete only - NO Create)
Route::resource('/admin/users', UserController::class)->names([
    'index' => 'admin.users.index',
    'edit' => 'admin.users.edit',
    'update' => 'admin.users.update',
    'destroy' => 'admin.users.destroy',
])->middleware('auth');
// Note: 'create' and 'store' routes are intentionally omitted

// Admin Books Routes (CRUD)
Route::resource('/admin/books', BookController::class)->names([
    'index' => 'admin.books.index',
    'create' => 'admin.books.create',
    'store' => 'admin.books.store',
    'show' => 'admin.books.show',
    'edit' => 'admin.books.edit',
    'update' => 'admin.books.update',
    'destroy' => 'admin.books.destroy',
])->middleware('auth');

// Admin Loans Routes (CRUD)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/loans', [LoanController::class, 'adminIndex'])->name('loans.index');
    Route::get('/loans/create', [LoanController::class, 'adminCreate'])->name('loans.create');
    Route::post('/loans', [LoanController::class, 'adminStore'])->name('loans.store');
    Route::get('/loans/{loan}', [LoanController::class, 'adminShow'])->name('loans.show');
    Route::get('/loans/{loan}/edit', [LoanController::class, 'adminEdit'])->name('loans.edit');
    Route::put('/loans/{loan}', [LoanController::class, 'adminUpdate'])->name('loans.update');
    Route::delete('/loans/{loan}', [LoanController::class, 'adminDestroy'])->name('loans.destroy');
    Route::put('/loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
