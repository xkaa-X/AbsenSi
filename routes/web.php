<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Guest Routes (Hanya untuk user yang belum login)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('index');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

// Authenticated Routes (Hanya untuk user yang sudah login)
Route::middleware('auth')->group(function () {
    
    // Student-Only Routes
    Route::middleware('role:siswa')->group(function () {
        Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');
        Route::post('/siswa/absen', [SiswaDashboardController::class, 'absen'])->name('siswa.absen.proses');
    });

    // Admin-Only Routes
    Route::middleware('role:admin')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD Resource Routes
        Route::resource('jurusan', JurusanController::class);
        Route::resource('kelas', KelasController::class)->parameters(['kelas' => 'kelas']);
        Route::resource('siswa', SiswaController::class);
        Route::resource('absensi', AbsensiController::class);
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    // Fallback GET logout untuk kenyamanan testing siswa
    Route::get('/logout-get', [AuthController::class, 'logout'])->name('logout.get');
});
