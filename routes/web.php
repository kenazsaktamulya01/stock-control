<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;

// Rute untuk login
Route::get('/login', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rute untuk logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk barang yang memerlukan autentikasi
Route::resource('/barang', BarangController::class)->middleware('auth');

// Rute halaman utama
Route::get('/', function () {
    return view('welcome');
});
