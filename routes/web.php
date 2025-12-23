<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OuterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationSetController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\DapurSehatController;
use App\Http\Controllers\MakananController;
use App\Http\Controllers\KategoriMakananController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanHarianController;
use App\Http\Controllers\SppgSekolahController;
use App\Http\Controllers\JadwalMenuController;

Route::get('/', [OuterController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // items
    Route::resource('items', ItemController::class)->middleware('role:Admin');

    // kategori makanans
    Route::resource('kategori-makanans', KategoriMakananController::class)->middleware('role:Admin|Operator BGN|Operator SPPG');

    // makanans
    Route::resource('makanans', MakananController::class)->middleware('role:Admin|Operator BGN|Operator SPPG');

    // siswas
    Route::resource('siswas', SiswaController::class)->middleware('role:Admin|Operator BGN|Operator Sekolah');
    Route::post('siswas/{siswa}/toggle-kehadiran', [SiswaController::class, 'toggleKehadiran'])->name('siswas.toggleKehadiran')->middleware('role:Admin|Operator BGN|Operator Sekolah');

    // laporan harian
    Route::resource('laporan-harian', LaporanHarianController::class)->middleware('role:Operator Sekolah|Operator SPPG');
    Route::post('laporan-harian/{id}/update-status', [LaporanHarianController::class, 'updateStatusPengantaran'])->name('laporan-harian.updateStatus')->middleware('role:Operator SPPG');

    // sppg-sekolah - for Operator SPPG to manage their schools
    Route::get('sppg-sekolah', [SppgSekolahController::class, 'index'])->name('sppg-sekolah.index')->middleware('role:Operator SPPG');
    Route::get('sppg-sekolah/create', [SppgSekolahController::class, 'create'])->name('sppg-sekolah.create')->middleware('role:Operator SPPG');
    Route::post('sppg-sekolah', [SppgSekolahController::class, 'store'])->name('sppg-sekolah.store')->middleware('role:Operator SPPG');
    Route::delete('sppg-sekolah/{id}', [SppgSekolahController::class, 'destroy'])->name('sppg-sekolah.destroy')->middleware('role:Operator SPPG');

    // jadwal-menu - for Operator SPPG to manage menu schedules for their schools
    Route::resource('jadwal-menu', JadwalMenuController::class)->middleware('role:Operator SPPG');

    // kalender-menu - untuk semua user melihat jadwal menu dan memberikan like
    Route::get('/kalender-menu', [App\Http\Controllers\JadwalMenuKalenderController::class, 'index'])->name('kalender-menu.index');
    Route::get('/kalender-menu/get-by-hari', [App\Http\Controllers\JadwalMenuKalenderController::class, 'getMenuByHari'])->name('kalender-menu.getByHari');
    Route::get('/kalender-menu/get-likes-by-month', [App\Http\Controllers\JadwalMenuKalenderController::class, 'getLikesByMonth'])->name('kalender-menu.getLikesByMonth');
    Route::post('/kalender-menu/{id}/toggle-like', [App\Http\Controllers\JadwalMenuKalenderController::class, 'toggleLike'])->name('kalender-menu.toggleLike');
    Route::post('/kalender-menu/{id}/update-jumlah-sisa', [App\Http\Controllers\JadwalMenuKalenderController::class, 'updateJumlahSisa'])->name('kalender-menu.updateJumlahSisa');

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
