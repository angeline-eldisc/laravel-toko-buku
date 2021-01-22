<?php

use Illuminate\Database\Seeder;
use App\Order;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::create([
            'user_id' => 4,
            'total_price' => 190000,
            'invoice_number' => 'INV-'.rand(000000000,999999999),
            'status' => 'SUBMIT'
        ])->books()->sync([
            '1' => ['quantity' => '1'],
            '3' => ['quantity' => '3']
        ]);
        
        Order::create([
            'user_id' => 5,
            'total_price' => 450000,
            'invoice_number' => 'INV-'.rand(000000000,999999999),
            'status' => 'SUBMIT'
        ])->books()->sync([
            '1' => ['quantity' => '1'],
            '2' => ['quantity' => '5'],
            '3' => ['quantity' => '1']
        ]);

        
        Order::create([
            'user_id' => 6,
            'total_price' => 180000,
            'invoice_number' => 'INV-'.rand(000000000,999999999),
            'status' => 'SUBMIT'
        ])->books()->sync([
            '1' => ['quantity' => '2'],
            '2' => ['quantity' => '1']
        ]);
    }
}
