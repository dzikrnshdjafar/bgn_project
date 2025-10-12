<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OuterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationSetController;
use App\Http\Controllers\SekolahController;
use App\Http\Controllers\SppgController;

Route::get('/', [OuterController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // items
    Route::resource('items', ItemController::class)->middleware('role:Admin');

    // users
    Route::resource('users', App\Http\Controllers\UserController::class)->middleware('role:Admin|Operator BGN');

    // sekolah - for Operator Sekolah
    Route::get('/sekolah/edit', [SekolahController::class, 'edit'])->name('sekolah.edit')->middleware('role:Operator Sekolah');
    Route::put('/sekolah/update', [SekolahController::class, 'update'])->name('sekolah.update')->middleware('role:Operator Sekolah');

    // sppg - for Operator SPPG
    Route::get('/sppg/edit', [SppgController::class, 'edit'])->name('sppg.edit')->middleware('role:Operator SPPG');
    Route::put('/sppg/update', [SppgController::class, 'update'])->name('sppg.update')->middleware('role:Operator SPPG');

    // aplication_setting
    Route::get('/appsets/edit', [ApplicationSetController::class, 'edit'])->name('appsets.edit');
    Route::put('/appsets/update-first', [ApplicationSetController::class, 'update'])->name('appsets.update');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
