<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        DB::table('stores')->insert([
            ['code' => '000003',
            'name' => "熊本本店",
            'postal_code' => '8608601',
            'prefecture' => '熊本県',
            'city' => '熊本市中央区',
            'address_line' => '手取本町01',
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
                ],
            ['code' => '000004',
            'name' => "熊本西店",
            'postal_code' => '8615287',
            'prefecture' => '熊本県',
            'city' => '熊本市西区',
            'address_line' => '小島2丁目77-1',
            'is_active' => true,
            'created_at' => $now,
            'updated_at' => $now,
                ],
        ]);
    }
}
