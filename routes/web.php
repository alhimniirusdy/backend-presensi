<?php

use App\Http\Controllers\AbsenController;
use App\Http\Controllers\AbsenQrController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\OrangTuaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaOrangTuaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/beranda');

Route::middleware(['auth'])->group(function () {
    // beranda
    Route::resource('beranda', BerandaController::class);
    // absen qr
    Route::resource('absenqr', AbsenQrController::class);
    // Absen
    Route::resource('absen', AbsenController::class);
    // Guru
    Route::resource('guru', GuruController::class);
    // Jadwal
    Route::resource('jadwal', JadwalController::class);
    // kelas
    Route::resource('kelas', KelasController::class);
    // orang tua siswa
    Route::resource('ortu_siswa', SiswaOrangTuaController::class);
    // orang tua
    Route::resource('orangtua', OrangTuaController::class);
    // siswa
    Route::resource('siswa', SiswaController::class);
    // user
    Route::resource('user', UserController::class);
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update/{user}', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/change-password', [ProfileController::class, 'changePasswordForm'])->name('profile.change-password-form');
    Route::post('profile/change-password/{user}', [ProfileController::class, 'changePassword'])->name('profile.change-password');
});
