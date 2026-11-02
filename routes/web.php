<?php

use App\Http\Controllers\Admin\AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\Pasien\DaftarPoliController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    Route::resource('polis', AdminPoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class)->except('show');
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::get('/jadwal-periksa', [JadwalPeriksaController::class, 'index'])
        ->name('jadwal-periksa.index');

    Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])
        ->name('periksa-pasien.index');
    Route::get('/periksa-pasien/{daftarPoli}/periksa', [PeriksaPasienController::class, 'create'])
        ->name('periksa-pasien.create');
    Route::post('/periksa-pasien/{daftarPoli}/periksa', [PeriksaPasienController::class, 'store'])
        ->name('periksa-pasien.store');

    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])
        ->name('riwayat-pasien.index');
    Route::get('/riwayat-pasien/{periksa}', [RiwayatPasienController::class, 'show'])
        ->name('riwayat-pasien.show');
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');

    Route::get('/daftar', [DaftarPoliController::class, 'index'])
        ->name('pasien.daftar');
    Route::post('/daftar', [DaftarPoliController::class, 'store'])
        ->name('pasien.daftar.store');
});

if (app()->environment('local')) {
    Route::get('/preview/dashboard/{role}', function (string $role) {
        abort_unless(in_array($role, ['admin', 'dokter', 'pasien'], true), 404);

        return view("{$role}.dashboard");
    })->whereIn('role', ['admin', 'dokter', 'pasien'])->name('preview.dashboard');
}
