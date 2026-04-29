<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderDestinationRequest;
use App\Models\Order;

class OrderDestinationController extends Controller
{
    public function update(UpdateOrderDestinationRequest $request, Order $order)
    {
        $user = $request->user();
        if (! $user->can('update', $order)) {
            abort(403);
        }

        $destination = $request->validated();
            if($order->delivery_type  === 'pickup'){
                $order->update([
                'pickup_store_id' => $destination['pickup_store_id']
                ]);
            }
            
            if($order->delivery_type  === 'delivery'){
                $order->update([
                'delivery_postal_code' => $destination['delivery_postal_code'],
                'delivery_address' => $destination['delivery_address'],
                ]);
            }

        return $order;
    }
}
