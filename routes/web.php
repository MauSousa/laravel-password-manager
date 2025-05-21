<?php

declare(strict_types=1);

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', [PasswordController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('passwords')->middleware(['auth', 'verified'])->name('passwords.')->group(function () {
    Route::post('/', [PasswordController::class, 'store'])->name('store');
    Route::get('/{password}/edit', [PasswordController::class, 'edit'])->name('edit');
    Route::patch('/{password}', [PasswordController::class, 'update'])->name('update');
    Route::delete('/{password}', [PasswordController::class, 'destroy'])->name('destroy');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
