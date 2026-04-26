<?php

namespace App\Http\Controllers;


use App\Http\Requests\UpdateOrderScheduleRequest;
use App\Models\Order;
use Carbon\Carbon;

class OrderScheduleController extends Controller
{
    public function update(UpdateOrderScheduleRequest $request, Order $order)
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

            $schedule = $request->validated();
        
        $deliveryType = $order->delivery_type;
        $date =  $schedule['delivery_date'];
        $from = $schedule['delivery_from'];
        $to =null;
        if($deliveryType === 'pickup'){
            $dt = Carbon::createFromFormat('Y-m-d H:i', $date.' '.$from);
            $to = $dt->copy()->addMinutes(30)->format('H:i');
        }else{
            $to = $schedule['delivery_to'];
        }

        $order->update([
            'delivery_date' => $date,
            'delivery_from' => $from,
            'delivery_to' => $to,
        ]);

        return $order;

    }
}
