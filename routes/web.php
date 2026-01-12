<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'publicIndex'])->name('home');

// Public Book Routes
Route::get('/books/{book}', [BookController::class, 'publicShow'])->name('books.show');

Route::get('/admin', function () {
    return view('admin');
})->name('admin.dashboard')->middleware('auth');

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

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
