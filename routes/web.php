<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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
    Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
    Route::get('/petugas/dashboard', fn() => view('petugas.dashboard'))->name('petugas.dashboard');
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

