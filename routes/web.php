<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\JadwalPeriksaController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
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

    Route::resource('obat', ObatController::class, [
        'names' => [
            'index' => 'admin.obat.index',
            'create' => 'admin.obat.create',
            'store' => 'admin.obat.store',
            'edit' => 'admin.obat.edit',
            'update' => 'admin.obat.update',
            'destroy' => 'admin.obat.destroy',
        ],
    ])->except(['show']);
});


Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        return view('dokter.dashboard');
    })->name('dokter.dashboard');

    Route::resource('jadwal-periksa', JadwalPeriksaController::class, [
        'names' => [
            'index' => 'dokter.jadwal-periksa.index',
            'create' => 'dokter.jadwal-periksa.create',
            'store' => 'dokter.jadwal-periksa.store',
            'edit' => 'dokter.jadwal-periksa.edit',
            'update' => 'dokter.jadwal-periksa.update',
            'destroy' => 'dokter.jadwal-periksa.destroy',
        ],
    ])->except(['show']);
});


Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');
});