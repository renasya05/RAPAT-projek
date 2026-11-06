<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\StrukturOrganisasiController;


/*
|--------------------------------------------------------------------------
| Halaman Umum
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => redirect()->route('login'));


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/aulas', [DashboardController::class, 'aulas'])->name('aulas');

    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi');


    /*
    |--------------------------------------------------------------------------
    | Pendaftaran Aula
    |--------------------------------------------------------------------------
    |
    | Cek ketersediaan harus berada sebelum /pendaftaran/{aula}.
    |
    */

    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {

        Route::get('availability/check', [PendaftaranController::class, 'availability'])->name('availability');

        Route::get('{aula}', [PendaftaranController::class, 'create'])->name('create');

        Route::post('/', [PendaftaranController::class, 'store'])->name('store');

    });


    /*
    |--------------------------------------------------------------------------
    | Riwayat Pendaftaran
    |--------------------------------------------------------------------------
    */

    Route::prefix('riwayat-pendaftaran')->name('pendaftaran.')->group(function () {

        Route::get('/', [PendaftaranController::class, 'history'])->name('history');

        Route::get('{pendaftaran}', [PendaftaranController::class, 'show'])->name('show');

        Route::put('{pendaftaran}/cancel', [PendaftaranController::class, 'cancel'])->name('cancel');

    });

});


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {

    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('laporan', [AdminController::class, 'laporan'])->name('laporan');


    /*
    |--------------------------------------------------------------------------
    | Data Aula
    |--------------------------------------------------------------------------
    */

    Route::prefix('aulas')->name('aulas.')->group(function () {

        Route::get('/', [AdminController::class, 'aulas'])->name('index');

        Route::get('create', [AdminController::class, 'createAula'])->name('create');

        Route::post('/', [AdminController::class, 'storeAula'])->name('store');

        Route::get('{aula}', [AdminController::class, 'showAula'])->name('show');

        Route::get('{aula}/edit', [AdminController::class, 'editAula'])->name('edit');

        Route::put('{aula}', [AdminController::class, 'updateAula'])->name('update');

        Route::delete('{aula}', [AdminController::class, 'destroyAula'])->name('destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | Struktur Organisasi (Bidang/Unit dan Subbagian/Seksi)
    |--------------------------------------------------------------------------
    */

    Route::prefix('struktur-organisasi')->name('struktur.')->group(function () {

        Route::get('/', [StrukturOrganisasiController::class, 'index'])->name('index');

        Route::post('unit', [StrukturOrganisasiController::class, 'storeUnit'])->name('unit.store');

        Route::put('unit/{unit}', [StrukturOrganisasiController::class, 'updateUnit'])->name('unit.update');

        Route::delete('unit/{unit}', [StrukturOrganisasiController::class, 'destroyUnit'])->name('unit.destroy');

        Route::post('unit/{unit}/seksi', [StrukturOrganisasiController::class, 'storeSeksi'])->name('seksi.store');

        Route::put('seksi/{seksi}', [StrukturOrganisasiController::class, 'updateSeksi'])->name('seksi.update');

        Route::delete('seksi/{seksi}', [StrukturOrganisasiController::class, 'destroySeksi'])->name('seksi.destroy');

    });


    /*
    |--------------------------------------------------------------------------
    | Pendaftaran
    |--------------------------------------------------------------------------
    */

    Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {

        Route::get('/', [AdminController::class, 'history'])->name('index');

        Route::get('{pendaftaran}', [AdminController::class, 'show'])->name('show');

        Route::put('{pendaftaran}/approve', [AdminController::class, 'approve'])->name('approve');

        Route::put('{pendaftaran}/reject', [AdminController::class, 'reject'])->name('reject');

    });

});