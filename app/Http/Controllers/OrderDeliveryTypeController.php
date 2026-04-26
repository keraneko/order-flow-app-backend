<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderDeliveryTypeRequest;
use App\Models\Order;
use Carbon\Carbon;

class OrderDeliveryTypeController extends Controller
{
    public function update(UpdateOrderDeliveryTypeRequest $request, Order $order)
    {
        $user = $request->user();
        $canUpdate = ($user->role === 'admin') ||
            (
                $user->role === 'store_user' &&
                $user->store_id === $order->order_store_id
            );
        if(!$canUpdate){
            abort(403);
        }

        $deliveryType = $request->validated();

        if($deliveryType['delivery_type'] === 'pickup'){
            $date = $order->delivery_date;
            $from = $order->delivery_from;
            $dt = Carbon::createFromFormat('Y-m-d H:i:s', $date.' '.$from);
            $to = $dt->copy()->addMinutes(30)->format('H:i:s');
            
            $order->update([
                'delivery_type' => $deliveryType['delivery_type'],
                'pickup_store_id' => $deliveryType['pickup_store_id'],
                'delivery_postal_code' => null,
                'delivery_address' => null,
                'delivery_to' => $to,
            ]);
        }
        elseif($deliveryType['delivery_type'] === 'delivery'){
            $order->update([
                'delivery_type' => $deliveryType['delivery_type'],
                'pickup_store_id' => null,
                'delivery_postal_code' => $deliveryType['delivery_postal_code'],
                'delivery_address' => $deliveryType['delivery_address'],
            ]);
        }

        return $order;
    }
}