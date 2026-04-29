<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderCustomerRequest;
use App\Models\Order;

class OrderCustomerController extends Controller
{
    public function update(UpdateOrderCustomerRequest $request, Order $order)
    {
        $user = $request->user();
        if (! $user->can('update', $order)) {
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
