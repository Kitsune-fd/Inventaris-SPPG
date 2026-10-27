<?php

use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\BahanMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenggunaanBahanController;
use App\Http\Controllers\SekolahPenerimaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
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

    // Master Data Resources
    Route::resource('bahan-baku', BahanBakuController::class)->parameters([
        'bahan-baku' => 'bahanBaku'
    ]);
    Route::resource('kategori', KategoriController::class)->parameters([
        'kategori' => 'kategori'
    ]);
    Route::resource('supplier', SupplierController::class)->parameters([
        'supplier' => 'supplier'
    ]);
    Route::resource('sekolah', SekolahPenerimaController::class)->only(['index']);

    // Manajemen Stok
    Route::get('/bahan-masuk', [BahanMasukController::class, 'index'])->name('bahan-masuk.index');
    Route::get('/penggunaan-bahan', [PenggunaanBahanController::class, 'index'])->name('penggunaan-bahan.index');

    // Laporan & Manajemen Pengguna
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
});
