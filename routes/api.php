<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemsController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\OrderScheduleController;
use App\Http\Controllers\OrderDestinationController;
use App\Http\Controllers\OrderDeliveryTypeController;
use App\Http\Controllers\OrderCustomerController;
use Illuminate\Http\Request;

Route::get('/user',function(Request $request){
    $user = $request->user();
    return [
        'id' => $user->id,
        'name' => $user->name,
        'login_id' => $user->login_id
    ];
})->middleware('auth:sanctum');

//Order作成関連
Route::get('/stores', [StoreController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/products', [ProductController::class, 'index']);

Route::middleware('auth:sanctum')->group(function(){

    //products    
    Route::post('/products',[ProductController::class, 'store']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::patch('/products/{product}',[ProductController::class, 'update']);
    Route::delete('/products/{product}',[ProductController::class, 'destroy']);

    //Stores
    Route::post('/stores', [StoreController::class, 'store']);
    Route::get('/stores/{store}', [StoreController::class, 'show']);
    Route::patch('/stores/{store}',[StoreController::class, 'update']);

    //Order
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    //OrderItems
    Route::patch('/orders/{order}/items',[OrderItemsController::class, 'update']);

    //OrderStatus
    Route::patch('/orders/{order}/status',[OrderStatusController::class, 'update']);

    //OrderSchedule
    Route::patch('/orders/{order}/schedule',[OrderScheduleController::class, 'update']);

    //OrderDestination
    Route::patch('/orders/{order}/destination',[OrderDestinationController::class, 'update']);

    //OrderDeriveryType
    Route::patch('/orders/{order}/deliveryType',[OrderDeliveryTypeController::class, 'update']);

    //OrderCustomer
    Route::patch('/orders/{order}/customer', [OrderCustomerController::class, 'update']);

});