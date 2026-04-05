<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::create(
            [
                'name' => '株式会社くまもと',
                'email' => 'test@test.com',
                'password' => Hash::make('password123'),
                'login_id' => '0000001',

            ]
        );
    }
}
