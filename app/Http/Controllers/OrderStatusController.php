<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\UpdateOrderStatusRequest;

class OrderStatusController extends Controller
{
    public function update(UpdateOrderStatusRequest $request, Order $order) 
    {
        $user = $request->user();

        if (! $user->can('update', $order)) {
            abort(403);
        }
        $status = $request->validated()['status'];
        $order->update([
            'status' => $status
        ]);

        return response()->json($order->status);
    }
}
