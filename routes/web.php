<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/', [AuthController::class, 'login'])->name('login.post');
    Route::get('/login', [AuthController::class, 'showLoginForm']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/resetpassword', [AuthController::class, 'showResetPasswordForm'])->name('resetpassword');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('produk', ProdukController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('pemasok', \App\Http\Controllers\PemasokController::class);
    Route::resource('pembelian', \App\Http\Controllers\PembelianController::class);
    Route::get('/stok', [\App\Http\Controllers\StokController::class, 'index'])->name('stok.index');
    Route::resource('penjualan', \App\Http\Controllers\PenjualanController::class);

    // Laporan Routes
    Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/export-excel', [\App\Http\Controllers\LaporanController::class, 'exportExcel'])->name('laporan.export.excel');
    Route::get('/laporan/export-pdf', [\App\Http\Controllers\LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');
});