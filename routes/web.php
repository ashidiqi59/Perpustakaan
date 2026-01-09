<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Halaman utama perpustakaan
    return view('home');
});