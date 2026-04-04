<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateOrderCustomerRequest;
use App\Models\Order;

class OrderCustomerController extends Controller
{
    public function update(UpdateOrderCustomerRequest $request, Order $order)
    {
        $customer = $request->validated();
        $order->customer->update([
            'name' => $customer['name'],
            'phone' => $customer['phone'],
            'address' => $customer['address'],
        ]);

        return $order->customer;
    }
}
