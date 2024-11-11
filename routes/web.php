<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PengadaanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\KartuStokController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('barang', BarangController::class);
Route::resource('pengadaan', PengadaanController::class);
Route::resource('penjualan', PenjualanController::class);
Route::get('kartu-stok', [KartuStokController::class, 'index'])->name('kartu-stok.index');
