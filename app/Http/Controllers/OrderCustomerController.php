<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderCustomerRequest;
use App\Models\Order;

class OrderCustomerController extends Controller
{
    public function update(UpdateOrderCustomerRequest $request, Order $order)
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
        
        $customer = $request->validated();
        $order->customer->update([
            'name' => $customer['name'],
            'phone' => $customer['phone'],
            'address' => $customer['address'],
        ]);

        return $order->customer;
    }
}
