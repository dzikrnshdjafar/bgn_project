<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OuterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationSetController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\DapurSehatController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanHarianController;

Route::get('/', [OuterController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // items
    Route::resource('items', ItemController::class)->middleware('role:Admin');

    // makanans
    Route::resource('makanans', MakananController::class)->middleware('role:Admin|Operator BGN|Operator SPPG');

    // siswas
    Route::resource('siswas', SiswaController::class)->middleware('role:Admin|Operator BGN|Operator Sekolah');
    Route::post('siswas/{siswa}/toggle-kehadiran', [SiswaController::class, 'toggleKehadiran'])->name('siswas.toggleKehadiran')->middleware('role:Admin|Operator BGN|Operator Sekolah');

    // laporan harian
    Route::resource('laporan-harian', LaporanHarianController::class)->middleware('role:Operator Sekolah|Operator SPPG');
    Route::post('laporan-harian/{id}/update-status', [LaporanHarianController::class, 'updateStatusPengantaran'])->name('laporan-harian.updateStatus')->middleware('role:Operator SPPG');

    // users
    Route::resource('users', App\Http\Controllers\UserController::class)->middleware('role:Admin|Operator BGN');

    // sekolah - for Operator Sekolah
    Route::get('/sekolah/edit', [SekolahController::class, 'edit'])->name('sekolah.edit')->middleware('role:Operator Sekolah');
    Route::put('/sekolah/update', [SekolahController::class, 'update'])->name('sekolah.update')->middleware('role:Operator Sekolah');

    // dapur_sehat - for Operator SPPG
    Route::get('/dapur-sehat/edit', [DapurSehatController::class, 'edit'])->name('dapur_sehat.edit')->middleware('role:Operator SPPG');
    Route::put('/dapur-sehat/update', [DapurSehatController::class, 'update'])->name('dapur_sehat.update')->middleware('role:Operator SPPG');

    // aplication_setting
    Route::get('/appsets/edit', [ApplicationSetController::class, 'edit'])->name('appsets.edit');
    Route::put('/appsets/update-first', [ApplicationSetController::class, 'update'])->name('appsets.update');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
