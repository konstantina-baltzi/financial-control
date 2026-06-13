<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bills', [BillController::class, 'index']);
Route::get('/bills', [BillController::class, 'index']);      // Λίστα λογαριασμών
Route::get('/bills/create', [BillController::class, 'create']); // Εμφάνιση της φόρμας
Route::post('/bills', [BillController::class, 'store']);       // Αποθήκευση της φόρμας