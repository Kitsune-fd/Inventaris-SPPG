<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BahanMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenggunaanBahanController;
use App\Http\Controllers\SekolahPenerimaController;
use App\Http\Controllers\StokBahanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Admin Routes
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Master Data (Katalog Bahan & Sekolah)
    Route::resource('bahan-baku', BahanBakuController::class)->parameters([
        'bahan-baku' => 'bahanBaku'
    ]);
    Route::resource('kategori', KategoriController::class)->parameters([
        'kategori' => 'kategori'
    ]);
    Route::resource('sekolah', SekolahPenerimaController::class)->parameters([
        'sekolah' => 'sekolah'
    ]);

    // Manajemen Stok
    Route::get('/stok-bahan', [StokBahanController::class, 'index'])->name('stok-bahan.index');
    Route::resource('bahan-masuk', BahanMasukController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('penggunaan-bahan', PenggunaanBahanController::class)->only(['index', 'create', 'store', 'destroy']);

    // Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
});
