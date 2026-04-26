<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\UpdateOrderItemsRequest;


class OrderItemsController extends Controller
{

    public function update(UpdateOrderItemsRequest $request, Order $order)
    {
        $user = $request->user();

        if (! $user->can('update', $order)) {
            abort(403);
        }
        $status = $order->status;
        
        if($status !== 'received') return response()->json([
            'message' => 'このステータスは変更できません',
        ], 422);

        $payloadItems = $request->validated()['items'];

        $existingItems = $order->items()
        ->select('product_id', 'quantity', 'unit_price')
        ->get()
        ->keyBy('product_id');

        $recreateItems = [];

        foreach ($payloadItems as $payloadItem) {
            $productId = $payloadItem['product_id'];
            $quantity = $payloadItem['quantity'];

            $existingItem = $existingItems->get($productId);

            $unitPrice = $existingItem 
            ? $existingItem->unit_price
            : Product::findOrFail($productId)->price;

            $recreateItems[] =[
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
            ];
        }

        $totalAmount = collect($recreateItems)->sum(function ($item){
            return $item['unit_price'] * $item['quantity'];
        });

        DB::transaction(function() use($order, $recreateItems, $totalAmount){
            $order->items()->delete();
            $order->items()->createMany($recreateItems);
            $order->update([
                'total_amount' => $totalAmount
            ]);
        });

        return response()->json([
            'message'=>'update',
        ]);
        
        
    }
    

}
