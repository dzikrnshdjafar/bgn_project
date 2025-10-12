<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OuterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ApplicationSetController;

Route::get('/', [OuterController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // items
    Route::resource('items', ItemController::class)->middleware('role:Admin');

    // aplication_setting
    Route::get('/appsets/edit', [ApplicationSetController::class, 'edit'])->name('appsets.edit');
    Route::put('/appsets/update-first', [ApplicationSetController::class, 'update'])->name('appsets.update');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
