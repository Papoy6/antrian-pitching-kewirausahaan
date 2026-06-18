<?php

use App\Http\Controllers\Admin\AntreanController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\KelompokController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('peserta.dashboard');
    }

    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Autentikasi
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Area Peserta
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::get('/dashboard', [PesertaController::class, 'dashboard'])->name('dashboard');

    Route::get('/kelompok/buat', [PesertaController::class, 'create'])->name('kelompok.create');
    Route::post('/kelompok', [PesertaController::class, 'store'])->name('kelompok.store');

    Route::get('/kelompok/upload-ulang', [PesertaController::class, 'editUpload'])->name('kelompok.edit-upload');
    Route::post('/kelompok/upload-ulang', [PesertaController::class, 'storeUpload'])->name('kelompok.store-upload');

    Route::get('/jadwal', [PesertaController::class, 'jadwal'])->name('jadwal');
    Route::post('/jadwal/{jadwal}/pilih', [PesertaController::class, 'pilihJadwal'])->name('jadwal.pilih');

    Route::get('/e-receipt', [PesertaController::class, 'eReceipt'])->name('e-receipt');
});

/*
|--------------------------------------------------------------------------
| Area Admin / Petugas BPA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/antrean', [AntreanController::class, 'index'])->name('antrean');
    Route::post('/antrean/{kelompok}/panggil', [AntreanController::class, 'panggil'])->name('antrean.panggil');

    Route::get('/kelompok/{kelompok}', [KelompokController::class, 'show'])->name('kelompok.show');
    Route::post('/kelompok/{kelompok}/verifikasi', [KelompokController::class, 'verifikasi'])->name('kelompok.verifikasi');
    Route::post('/kelompok/{kelompok}/tolak', [KelompokController::class, 'tolak'])->name('kelompok.tolak');
    Route::post('/kelompok/{kelompok}/konfirmasi', [KelompokController::class, 'konfirmasi'])->name('kelompok.konfirmasi');
    Route::get('/kelompok/{kelompok}/e-receipt', [KelompokController::class, 'eReceipt'])->name('kelompok.e-receipt');

    Route::resource('jadwal', JadwalController::class)->except(['show', 'edit', 'create']);
});

/*
|--------------------------------------------------------------------------
| API ringan untuk live monitoring (polling AJAX)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/api/status', [StatusController::class, 'index'])->name('api.status');
});