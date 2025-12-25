<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OuterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationSetController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SppgController;
use App\Http\Controllers\KategoriMenuController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\JadwalMenuController;
use App\Http\Controllers\DistribusiController;

Route::get('/', [OuterController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // items
    Route::resource('items', ItemController::class)->middleware('role:Admin');

    // users
    Route::resource('users', App\Http\Controllers\UserController::class)->middleware('role:Admin|Operator BGN');

    // kategori menus
    Route::resource('kategori-menus', KategoriMenuController::class)->middleware('role:Admin|Operator BGN|Operator SPPG');

    // menus
    Route::resource('menus', MenuController::class)->middleware('role:Admin|Operator BGN|Operator SPPG');

    // jadwal menus
    Route::resource('jadwal-menus', JadwalMenuController::class)->middleware('role:Admin|Operator SPPG');
    Route::get('/jadwal-menus-export-pdf', [JadwalMenuController::class, 'exportPdf'])->name('jadwal-menus.export-pdf')->middleware('role:Admin|Operator SPPG');

    // sekolah - for Operator Sekolah
    Route::get('/sekolah/edit', [SekolahController::class, 'edit'])->name('sekolah.edit')->middleware('role:Operator Sekolah');
    Route::put('/sekolah/update', [SekolahController::class, 'update'])->name('sekolah.update')->middleware('role:Operator Sekolah');

    // sppg - for Operator SPPG
    Route::get('/sppg/edit', [SppgController::class, 'edit'])->name('sppg.edit')->middleware('role:Operator SPPG');
    Route::put('/sppg/update', [SppgController::class, 'update'])->name('sppg.update')->middleware('role:Operator SPPG');

    // distribusi - for Operator Sekolah
    Route::get('/distribusi', [DistribusiController::class, 'index'])->name('distribusi.index')->middleware('role:Operator Sekolah');
    Route::get('/distribusi/today', [DistribusiController::class, 'today'])->name('distribusi.today')->middleware('role:Operator Sekolah');
    Route::post('/distribusi/{distribusi}/konfirmasi', [DistribusiController::class, 'konfirmasi'])->name('distribusi.konfirmasi')->middleware('role:Operator Sekolah');
    Route::post('/distribusi/{distribusi}/batal-konfirmasi', [DistribusiController::class, 'batalKonfirmasi'])->name('distribusi.batal-konfirmasi')->middleware('role:Operator Sekolah');

    // Generate distribusi - for Admin
    Route::post('/distribusi/generate', [DistribusiController::class, 'generateDistribusi'])->name('distribusi.generate')->middleware('role:Admin');
    Route::post('/distribusi/generate/{sppg}', [DistribusiController::class, 'generateBySppg'])->name('distribusi.generate-by-sppg')->middleware('role:Admin|Operator SPPG');
    Route::delete('/distribusi/cancel/{sppg}', [DistribusiController::class, 'cancelBySppg'])->name('distribusi.cancel-by-sppg')->middleware('role:Admin|Operator SPPG');

    // sppg sekolahs management - for Operator SPPG
    Route::get('/sppg/sekolahs', [SppgController::class, 'sekolahs'])->name('sppg.sekolahs')->middleware('role:Operator SPPG');
    Route::post('/sppg/sekolahs/attach', [SppgController::class, 'attachSekolah'])->name('sppg.sekolahs.attach')->middleware('role:Operator SPPG');
    Route::delete('/sppg/sekolahs/{sekolah}/detach', [SppgController::class, 'detachSekolah'])->name('sppg.sekolahs.detach')->middleware('role:Operator SPPG');

    // Admin SPPG management
    Route::get('/admin/sppgs', [SppgController::class, 'index'])->name('admin.sppgs.index')->middleware('role:Admin');
    Route::get('/admin/sppgs/{sppg}/sekolahs', [SppgController::class, 'sekolahs'])->name('admin.sppgs.sekolahs')->middleware('role:Admin');
    Route::post('/admin/sppgs/{sppg}/sekolahs/attach', [SppgController::class, 'attachSekolah'])->name('admin.sppgs.sekolahs.attach')->middleware('role:Admin');
    Route::delete('/admin/sppgs/{sppg}/sekolahs/{sekolah}/detach', [SppgController::class, 'detachSekolah'])->name('admin.sppgs.sekolahs.detach')->middleware('role:Admin');

    // aplication_setting
    Route::get('/appsets/edit', [ApplicationSetController::class, 'edit'])->name('appsets.edit');
    Route::put('/appsets/update-first', [ApplicationSetController::class, 'update'])->name('appsets.update');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
