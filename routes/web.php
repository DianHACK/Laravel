<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControllerDashboard;
use App\Http\Controllers\ControllerBarang;
use App\Http\Controllers\ControllerKategori;
use App\Http\Controllers\ControllerRak;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// LOGIN & REGISTER
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// HALAMAN YANG WAJIB LOGIN
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [ControllerDashboard::class, 'dashboard'])->name('dashboard');

    // Barang
    Route::get('/barang', [ControllerBarang::class, 'barang'])->name('barang.index');
    Route::get('/barang/create', [ControllerBarang::class, 'create'])->name('barang.create');
    Route::post('/barang', [ControllerBarang::class, 'store'])->name('barang.store');
    Route::get('/barang/{id}/edit', [ControllerBarang::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{id}', [ControllerBarang::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}', [ControllerBarang::class, 'destroy'])->name('barang.destroy');

    // Kategori
    Route::get('/kategori', [ControllerKategori::class, 'index'])->name('kategori.index');
    Route::get('/kategori/create', [ControllerKategori::class, 'create'])->name('kategori.create');
    Route::post('/kategori', [ControllerKategori::class, 'store'])->name('kategori.store');
    Route::get('/kategori/{id}/edit', [ControllerKategori::class, 'edit'])->name('kategori.edit');
    Route::put('/kategori/{id}', [ControllerKategori::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [ControllerKategori::class, 'destroy'])->name('kategori.destroy');

    // Rak
    Route::get('/rak', [ControllerRak::class, 'index'])->name('rak.index');
    Route::get('/rak/create', [ControllerRak::class, 'create'])->name('rak.create');
    Route::post('/rak', [ControllerRak::class, 'store'])->name('rak.store');
    Route::get('/rak/{id}/edit', [ControllerRak::class, 'edit'])->name('rak.edit');
    Route::put('/rak/{id}', [ControllerRak::class, 'update'])->name('rak.update');
    Route::delete('/rak/{id}', [ControllerRak::class, 'destroy'])->name('rak.destroy');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
