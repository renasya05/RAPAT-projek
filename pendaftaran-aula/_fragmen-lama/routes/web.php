<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? (auth()->user()->isAdmin()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('dashboard'))
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/pendaftaran/create', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::post('/pendaftaran/{pendaftaran}/cancel', [PendaftaranController::class, 'cancel'])->name('pendaftaran.cancel');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/pendaftaran/{pendaftaran}/approve', [AdminController::class, 'approve'])->name('pendaftaran.approve');
        Route::post('/pendaftaran/{pendaftaran}/reject', [AdminController::class, 'reject'])->name('pendaftaran.reject');

        Route::get('/riwayat', [AdminController::class, 'history'])->name('history');

        Route::get('/aula', [AdminController::class, 'aulas'])->name('aulas');
        Route::get('/aula/create', [AdminController::class, 'createAula'])->name('aulas.create');
        Route::post('/aula', [AdminController::class, 'storeAula'])->name('aulas.store');
        Route::get('/aula/{aula}/edit', [AdminController::class, 'editAula'])->name('aulas.edit');
        Route::put('/aula/{aula}', [AdminController::class, 'updateAula'])->name('aulas.update');
        Route::delete('/aula/{aula}', [AdminController::class, 'destroyAula'])->name('aulas.destroy');
    });
});
