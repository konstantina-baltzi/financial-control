<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/bills', [BillController::class, 'index']);
    Route::get('/bills/create', [BillController::class, 'create']);
    Route::post('/bills', [BillController::class, 'store']);
    Route::get('/bills/{id}/edit', [BillController::class, 'edit']);
    Route::put('/bills/{id}', [BillController::class, 'update']);
    Route::delete('/bills/{id}', [BillController::class, 'destroy']);
});
