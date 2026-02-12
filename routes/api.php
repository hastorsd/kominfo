<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ApiController::class);

Route::get('/categories', [ApiController::class, 'categories'])->name('categories');
Route::get('/suppliers', [ApiController::class, 'suppliers'])->name('suppliers');
