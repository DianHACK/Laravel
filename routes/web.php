<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ControllerDashboard;
use App\Http\Controllers\ControllerBarang;
use App\Http\Controllers\ControllerBarangTerlaris;
use App\Http\Controllers\ControllerKategori;
use App\Http\Controllers\ControllerRak;
use App\Http\Controllers\ControllerPenjualan;
use App\Http\Controllers\ControllerKeranjang;
use App\Http\Controllers\ControllerLaporan;
use App\Http\Controllers\ControllerLaporanKeuntungan;
use App\Http\Controllers\ControllerProfile;
use App\Http\Controllers\ControllerRiwayatTransaksi;
use App\Http\Controllers\ControllerUser;
use App\Http\Controllers\ControllerStokBarang;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// LOGIN DAN REGISTER
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

// SEMUA ROUTE WAJIB LOGIN
Route::middleware('auth')->group(function () {
    // Profile User
    Route::get('/profile', [ControllerProfile::class, 'index'])->name('profile.index');
    Route::put('/profile/update', [ControllerProfile::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [ControllerProfile::class, 'updatePassword'])->name('profile.password');

    // Dashboard
    Route::get('/dashboard', [ControllerDashboard::class, 'dashboard'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // KHUSUS ADMIN
    Route::middleware('role:admin')->group(function () {

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

        // Laporan Penjualan
        Route::get('/laporan', [ControllerLaporan::class, 'index'])->name('laporan.index');
        Route::get('/laporan/detail/{id}', [ControllerLaporan::class, 'detail'])->name('laporan.detail');

        // User Management
        Route::get('/users', [ControllerUser::class, 'index'])->name('users.index');
        Route::get('/users/create', [ControllerUser::class, 'create'])->name('users.create');
        Route::post('/users', [ControllerUser::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [ControllerUser::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [ControllerUser::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [ControllerUser::class, 'destroy'])->name('users.destroy');

        Route::get('/stok-menipis', [ControllerBarang::class, 'stokMenipis'])->name('barang.stokMenipis');

        // Expired Barang
        Route::get('/expired-barang', [ControllerBarang::class, 'expiredBarang'])->name('barang.expired');

        // Stok Barang Masuk / Keluar
        Route::get('/stok', [ControllerStokBarang::class, 'index'])->name('stok.index');
        Route::get('/stok/create', [ControllerStokBarang::class, 'create'])->name('stok.create');
        Route::post('/stok', [ControllerStokBarang::class, 'store'])->name('stok.store');
            });

        Route::get('/barang-terlaris', [ControllerBarangTerlaris::class, 'index'])->name('barang.terlaris');
        Route::get('/laporan-keuntungan', [ControllerLaporanKeuntungan::class, 'index'])->name('laporan.keuntungan');

    // TRANSAKSI UNTUK ADMIN DAN KASIR
    Route::middleware('role:admin,kasir')->group(function () {

        // Penjualan
        Route::get('/penjualan', [ControllerPenjualan::class, 'index'])->name('penjualan.index');
        Route::post('/penjualan/tambah-keranjang/{id}', [ControllerPenjualan::class, 'tambahKeranjang'])->name('penjualan.tambahKeranjang');

        // Keranjang
        Route::get('/keranjang', [ControllerKeranjang::class, 'index'])->name('keranjang.index');
        Route::put('/keranjang/{id}', [ControllerKeranjang::class, 'update'])->name('keranjang.update');
        Route::delete('/keranjang/{id}', [ControllerKeranjang::class, 'destroy'])->name('keranjang.destroy');
        Route::post('/keranjang/checkout', [ControllerKeranjang::class, 'checkout'])->name('keranjang.checkout');

        // Struk
        Route::get('/penjualan/struk/{id}', [ControllerKeranjang::class, 'struk'])->name('penjualan.struk');

        //Riwayat Transaksi
        Route::get('/riwayat-transaksi', [ControllerRiwayatTransaksi::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat-transaksi/detail/{id}', [ControllerRiwayatTransaksi::class, 'detail'])->name('riwayat.detail');
    });

});
