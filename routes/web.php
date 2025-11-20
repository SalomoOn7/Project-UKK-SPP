<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PetugasPembayaranController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['guest:petugas', 'guest:siswa'])->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
});


// Dashboard petugas (admin & petugas biasa)
Route::middleware('auth:petugas')->group(function () {
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard')->middleware('isAdmin');
    Route::get('/petugas/dashboard', fn() => view('petugas.dashboard'))->name('petugas.dashboard')->middleware('isPetugas');
});

// Dashboard siswa
Route::middleware('auth:siswa')->group(function () {
    Route::get('/siswa/dashboard', fn() => view('siswa.dashboard'))->name('siswa.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth:petugas', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    //CRUD
        Route::resource('petugas', PetugasController::class);
        Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'id_kelas']);
        Route::resource('spp', SppController::class);
        Route::resource('siswa', SiswaController::class)->parameters(['siswa' => 'nisn']);

        // Pembayaran ADMIN
        Route::get('pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::get('pembayaran/{nisn}', [PembayaranController::class, 'bayar'])->name('pembayaran.bayar');
        Route::post('pembayaran/store', [PembayaranController::class, 'store'])->name('pembayaran.store');

        // History / detail / cetak
        Route::get('pembayaran/history/{nisn}', [PembayaranController::class, 'history'])->name('pembayaran.history');
        Route::get('pembayaran/detail/{nisn}', [PembayaranController::class, 'detail'])->name('pembayaran.detail');
        Route::get('pembayaran/{nisn}/cetak', [PembayaranController::class, 'cetakPDF'])->name('pembayaran.cetak');

        // Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('laporan/cari', [LaporanController::class, 'cari'])->name('laporan.cari');
        Route::get('laporan/cetak/{id_kelas}', [LaporanController::class, 'cetakPDF'])->name('laporan.cetak');
    });

// Petugas
Route::middleware(['auth:petugas', 'isPetugas'])->prefix('petugas')->name('petugas.')->group(function () {

        Route::get('pembayaran', [PetugasPembayaranController::class, 'index'])->name('pembayaran.index'); 
        Route::get('pembayaran/bayar/{nisn}', [PetugasPembayaranController::class, 'bayar'])->name('pembayaran.bayar');
        Route::post('pembayaran/store', [PetugasPembayaranController::class, 'store'])->name('pembayaran.store');

        Route::get('pembayaran/history/{nisn}', [PetugasPembayaranController::class, 'history'])->name('pembayaran.history');
        Route::get('pembayaran/detail/{nisn}', [PetugasPembayaranController::class, 'detail'])->name('pembayaran.detail');
        Route::get('pembayaran/cetak/{nisn}', [PetugasPembayaranController::class, 'cetakPDF'])->name('pembayaran.cetak');

        Route::get('laporan', [PetugasPembayaranController::class, 'index'])->name('laporan.index');
        Route::get('laporan/cari', [PetugasPembayaranController::class, 'cari'])->name('laporan.cari');
        Route::get('laporan/cetak/{id_kelas}', [PetugasPembayaranController::class, 'cetakPDF'])->name('laporan.cetak');
    });
