<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\OrderController;

//products
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products',[ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::patch('/products/{product}',[ProductController::class, 'update']);
Route::delete('/products/{product}',[ProductController::class, 'destroy']);

//Stores
Route::get('/stores', [StoreController::class, 'index']);
Route::post('/stores', [StoreController::class, 'store']);
Route::get('/stores/{store}', [StoreController::class, 'show']);
Route::patch('/stores/{store}',[StoreController::class, 'update']);

//order
Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{order}', [OrderController::class, 'show']);