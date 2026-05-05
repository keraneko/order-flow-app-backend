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

        if(! $user->can('updateReceivedOrder', $order)){
            return response()->json([
                'message' => '受注以外のステータスは更新できません'
            ],422);
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
