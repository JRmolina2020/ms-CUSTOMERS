<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CustomerController;
Route::prefix('customers/')->name('customers.')->group(function () {
    Route::post('register', [CustomerController::class, 'store'])->name('store');
    Route::put('update/{id}', [CustomerController::class, 'update'])->name('update');
    Route::delete('delete/{id}', [CustomerController::class, 'destroy'])->name('delete');
    Route::get('list', [CustomerController::class, 'index'])->name('list');
    Route::get('search/{id}', [CustomerController::class, 'search'])->name('search');
});