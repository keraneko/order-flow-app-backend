<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderDestinationRequest;
use App\Models\Order;

class OrderDestinationController extends Controller
{
    public function update(UpdateOrderDestinationRequest $request, Order $order)
    {
        $destination = $request->validated();
            if($order->delivery_type  === 'pickup'){
                $order->update([
                'pickup_store_id' => $destination['pickup_store_id']
                ]);
            }

        return $order;
    }
}
