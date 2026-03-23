<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('customers')->insert([
            ['name' => '熊本太郎', 'address' => '熊本県熊本市中央区' , 'phone' => '01200001111', 'created_at' => $now, 'updated_at' => $now,],
            ['name' => '福岡二郎', 'address' => '福岡県福岡市博多区博多' , 'phone' => '0120111222', 'created_at' => $now, 'updated_at' => $now,],
        ]);
    }
}
