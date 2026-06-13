<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/bills', [BillController::class, 'index']);
Route::get('/bills', [BillController::class, 'index']);      // bill list 
Route::get('/bills/create', [BillController::class, 'create']); // bill add form
Route::post('/bills', [BillController::class, 'store']);       // save form
Route::delete('/bills/{id}', [BillController::class, 'destroy']); //delete form
Route::get('/bills/{id}/edit', [BillController::class, 'edit']); //show form edit
Route::put('/bills/{id}', [BillController::class, 'update']);    // save edit (PUT)
