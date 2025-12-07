<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/resetpassword', function () {
    return view('auth.resetpassword');
})->name('resetpassword');

Route::get('/dashboard', function () {
    return view('pages.dashboard.index');
})->name('dashboard');

Route::get('/produk', function () {
    return view('pages.produk.index');
})->name('produk');

Route::get('/pemasok', function () {
    return view('pages.pemasok.index');
})->name('pemasok');

Route::get('/stok', function () {
    return view('pages.stok.index');
})->name('stok');

Route::get('/penjualan', function () {
    return view('pages.penjualan.index');
})->name('penjualan');

Route::get('/pembelian', function () {
    return view('pages.pembelian.index');
})->name('pembelian');

Route::get('/laporan', function () {
    return view('pages.laporan.index');
})->name('laporan');