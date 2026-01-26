<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\OrderController;

//product
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products',[ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::patch('/products/{product}',[ProductController::class, 'update']);
Route::delete('/products/{product}',[ProductController::class, 'destroy']);

Route::get('/stores', [StoreController::class, 'index']);

Route::post('/orders', [OrderController::class, 'store']);
