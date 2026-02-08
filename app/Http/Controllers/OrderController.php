<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{

    public function index()
    {
        return Order::select('id', 'ordered_at', 'status', 'total_amount')->orderby('ordered_at', 'desc')->get();
    }

    public function store(StoreOrderRequest $request)
    {
        $result = DB::transaction(function() use($request){
            $customerData = $request->input('customer');
            $customer = Customer::create([
                'name' => $customerData['name'],
                'address' => $customerData['address'],
                'phone' => $customerData['phone'] 
            ]);

            $order = Order::create([
            'customer_id' => $customer->id,
            'order_store_id' =>(int)$customerData['orderStoreId'],
            'employee_id' => null,
            'ordered_at' =>now(),
            'status' => 'received',
            'total_amount' =>  $request->input('totalAmount'),
            'delivery_type' =>$customerData['deliveryType'] ,
            'pickup_store_id' => $customerData['deliveryType'] === 'pickup' ? (int) $customerData['pickupStoreId'] : null,
            'delivery_address' => $customerData['deliveryType'] === 'delivery' ? $customerData['deliveryAddress'] : null ,
            'delivery_postal_code' => $customerData['deliveryType'] === 'delivery' ? $customerData['deliveryPostalCode'] : null ,
            'note' => $customerData['note'] ?? null,

            ]);

            $items  = $request->input('items');
            foreach($items as $item){
            $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['id'],
            'quantity'=> $item['quantity'],
            'unit_price'=>$item['price'],

            ]);}

            return [
                'customer_id'=>$customer->id,
                'order_id' => $order->id,
            ];
        });
        return response()->json($result);
    }

}
