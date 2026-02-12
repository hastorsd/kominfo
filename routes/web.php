<?php

use App\Http\Controllers\FetchApiController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// route tampilan penjualan soal no 1
Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');

// route tampilan products soal no 3
Route::get('/products', [FetchApiController::class, 'index'])->name('products.index');
Route::get('/get-products', [FetchApiController::class, 'fetch'])->name('products.fetch');
