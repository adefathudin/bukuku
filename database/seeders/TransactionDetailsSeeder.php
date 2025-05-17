<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('transaction_details')->insert([            
        [
            'transaction_id' => 1,
            'product_id' => 9,
            'qty' => 1,
            'unit_price' => 150000,
            'subtotal' => 150000,
        ],            
        [
            'transaction_id' => 2,
            'product_id' => 3,
            'qty' => 2,
            'unit_price' => 10000,
            'subtotal' => 20000,
        ],
        [
            'transaction_id' => 2,
            'product_id' => 3,
            'qty' => 4,
            'unit_price' => 10000,
            'subtotal' => 40000,
        ],
        [
            'transaction_id' => 2,
            'product_id' => 1,
            'qty' => 1,
            'unit_price' => 15000,
            'subtotal' => 15000,
        ],
        [
            'transaction_id' => 3,
            'product_id' => 1,
            'qty' => 2,
            'unit_price' => 15000,
            'subtotal' => 30000,
        ],
        [
            'transaction_id' => 3,
            'product_id' => 2,
            'qty' => 3,
            'unit_price' => 10000,
            'subtotal' => 30000,
        ],
        [
            'transaction_id' => 3,
            'product_id' => 4,
            'qty' => 5,
            'unit_price' => 5000,
            'subtotal' => 25000,
        ],
        [
            'transaction_id' => 4,
            'product_id' => 4,
            'qty' => 2,
            'unit_price' => 50000,
            'subtotal' => 10000,
        ],
        [
            'transaction_id' => 4,
            'product_id' => 9,
            'qty' => 2,
            'unit_price' => 150000,
            'subtotal' => 300000,
        ],
        [
            'transaction_id' => 5,
            'product_id' => 5,
            'qty' => 1,
            'unit_price' => 50000,
            'subtotal' => 50000,
        ],
        [
            'transaction_id' => 5,
            'product_id' => 6,
            'qty' => 2,
            'unit_price' => 20000,
            'subtotal' => 40000,
        ],
        [
            'transaction_id' => 5,
            'product_id' => 9,
            'qty' => 1,
            'unit_price' => 150000,
            'subtotal' => 150000,
        ],
        [
            'transaction_id' => 6,
            'product_id' => 6,
            'qty' => 4,
            'unit_price' => 20000,
            'subtotal' => 80000,
        ],
        [
            'transaction_id' => 6,
            'product_id' => 7,
            'qty' => 2,
            'unit_price' => 30000,
            'subtotal' => 60000,
        ],
        [
            'transaction_id' => 7,
            'product_id' => 8,
            'qty' => 3,
            'unit_price' => 25000,
            'subtotal' => 75000,
        ],
        [
            'transaction_id' => 7,
            'product_id' => 7,
            'qty' => 2,
            'unit_price' => 30000,
            'subtotal' => 60000,
        ]
    ]);
    }
}
