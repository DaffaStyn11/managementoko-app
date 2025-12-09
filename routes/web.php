<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/resetpassword', function () {
    return view('auth.resetpassword');
})->name('resetpassword');

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