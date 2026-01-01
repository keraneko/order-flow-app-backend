<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('products')->insert([
            ['name' => 'からあげ弁当', 'price' => 550, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'のり弁当', 'price' => 480, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'チキン南蛮弁当','price' => 620, 'created_at' => $now, 'updated_at' => $now],
            ['name' => '鮭弁当', 'price' => 590, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'ハンバーグ弁当', 'price' => 600, 'created_at' => $now, 'updated_at' => $now],
            ['name' => '野菜炒め弁当', 'price' => 590, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'オムライス', 'price' => 600, 'created_at' => $now, 'updated_at' => $now],
            ['name' => '生姜焼き弁当', 'price' => 640, 'created_at' => $now, 'updated_at' => $now],
        ]);

    }
}
