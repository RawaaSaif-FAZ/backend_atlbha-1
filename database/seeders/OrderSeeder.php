<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'order_number' => '0001',
            'user_id' => 1,
            'quantity' => 4,
            'total_price' => 1000,
            'tax' => 1.2,
            'discount' => 0,
            'order_status' => 'new',
            'payment_status' => "new",

        ]);
          Order::create([
            'order_number' => '0002',
            'user_id' => 2,
            'quantity' => 5,
            'total_price' => 1100,
            'tax' => 2.3,
            'discount' => 400,
            'order_status' => 'new',
            'payment_status' => "t",

        ]);
    }
}
