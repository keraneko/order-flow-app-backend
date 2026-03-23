<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->delete();
        $now = now();
        $customer = DB::table('customers')->where('name', '熊本太郎')->first();
        $store = DB::table('stores')->where('code', '000001')->first();
        $product = DB::table('products')->where('name', 'からあげ弁当')->first();
        //1件目
        $order = Order::create([
             'customer_id' => $customer->id,
             'order_store_id' => $store->id,
             'ordered_at' => $now,
             'status' => 'received',
             'total_amount' => 500,
             'delivery_date' => '2026-03-23',
             'delivery_from' => '08:00:00',
             'delivery_to' => '08:30:00',
             'delivery_type' => 'pickup',
             'pickup_store_id' => $store->id,
             'note' => 'seeder1番目',
            ],
        );

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 500,
            ]
        );
        //2件目
         $order = Order::create([
             'customer_id' => $customer->id,
             'order_store_id' => $store->id,
             'ordered_at' => $now,
             'status' => 'received',
             'total_amount' => 500,
             'delivery_date' => '2026-03-23',
             'delivery_from' => '08:00:00',
             'delivery_to' => '08:30:00',
             'delivery_type' => 'delivery',
             'delivery_address' => '熊本県熊本市中央区渡鹿',
             'delivery_postal_code' => '8610011',
             'note' => 'seeder2番目',
            ],
        );

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 500,
            ]
        );
        //3件目(価格差分の確認)
        $order = Order::create([
             'customer_id' => $customer->id,
             'order_store_id' => $store->id,
             'ordered_at' => $now,
             'status' => 'completed',
             'total_amount' => 2000,
             'delivery_date' => '2026-03-23',
             'delivery_from' => '08:00:00',
             'delivery_to' => '08:30:00',
             'delivery_type' => 'pickup',
             'pickup_store_id' => $store->id,
             'note' => 'seeder3番目',
            ],
        );

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 1000,
            ]
        );
        //4件目
        $order = Order::create([
             'customer_id' => $customer->id,
             'order_store_id' => $store->id,
             'ordered_at' => $now,
             'status' => 'canceled',
             'total_amount' => 500,
             'delivery_date' => '2026-03-23',
             'delivery_from' => '08:00:00',
             'delivery_to' => '08:30:00',
             'delivery_type' => 'delivery',
             'delivery_address' => '熊本県熊本市東区月出５丁目',
             'delivery_postal_code' => '8610022',
             'note' => 'seeder4番目',
            ],
        );

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
            'unit_price' => 500,
            ]
        );

    }
}
