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
            ['transaction_id' => 1, 'product_id' => 1, 'qty' => 2, 'unit_price' => 1000000, 'subtotal' => 2000000],
            ['transaction_id' => 2, 'product_id' => 2, 'qty' => 1, 'unit_price' => 500000, 'subtotal' => 500000],
            ['transaction_id' => 3, 'product_id' => 3, 'qty' => 3, 'unit_price' => 1500000, 'subtotal' => 4500000],
            ['transaction_id' => 2, 'product_id' => 4, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 3, 'product_id' => 5, 'qty' => 4, 'unit_price' => 1000000, 'subtotal' => 4000000],
            ['transaction_id' => 3, 'product_id' => 1, 'qty' => 2, 'unit_price' => 500000, 'subtotal' => 1000000],
            ['transaction_id' => 1, 'product_id' => 2, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 1, 'product_id' => 3, 'qty' => 3, 'unit_price' => 1500000, 'subtotal' => 4500000],
            ['transaction_id' => 2, 'product_id' => 4, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 2, 'product_id' => 5, 'qty' => 4, 'unit_price' => 1000000, 'subtotal' => 4000000],
            ['transaction_id' => 3, 'product_id' => 1, 'qty' => 2, 'unit_price' => 500000, 'subtotal' => 1000000],
            ['transaction_id' => 3, 'product_id' => 2, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 3, 'product_id' => 3, 'qty' => 3, 'unit_price' => 1500000, 'subtotal' => 4500000],
            ['transaction_id' => 4, 'product_id' => 4, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 4, 'product_id' => 5, 'qty' => 4, 'unit_price' => 1000000, 'subtotal' => 4000000],
            ['transaction_id' => 5, 'product_id' => 1, 'qty' => 2, 'unit_price' => 500000, 'subtotal' => 1000000],
            ['transaction_id' => 5, 'product_id' => 2, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 5, 'product_id' => 3, 'qty' => 3, 'unit_price' => 1500000, 'subtotal' => 4500000],
            ['transaction_id' => 6, 'product_id' => 4, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 6, 'product_id' => 5, 'qty' => 4, 'unit_price' => 1000000, 'subtotal' => 4000000],
            ['transaction_id' => 7, 'product_id' => 1, 'qty' => 2, 'unit_price' => 500000, 'subtotal' => 1000000],
            ['transaction_id' => 7, 'product_id' => 2, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 7, 'product_id' => 3, 'qty' => 3, 'unit_price' => 1500000, 'subtotal' => 4500000],
            ['transaction_id' => 8, 'product_id' => 4, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 8, 'product_id' => 5, 'qty' => 4, 'unit_price' => 1000000, 'subtotal' => 4000000],
            ['transaction_id' => 9, 'product_id' => 1, 'qty' => 2, 'unit_price' => 500000, 'subtotal' => 1000000],
            ['transaction_id' => 9, 'product_id' => 2, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 9, 'product_id' => 3, 'qty' => 3, 'unit_price' => 1500000, 'subtotal' => 4500000], 
            ['transaction_id' => 10, 'product_id' => 4, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 10, 'product_id' => 5, 'qty' => 4, 'unit_price' => 1000000, 'subtotal' => 4000000],
            ['transaction_id' => 11, 'product_id' => 1, 'qty' => 2, 'unit_price' => 500000, 'subtotal' => 1000000],
            ['transaction_id' => 11, 'product_id' => 2, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 11, 'product_id' => 3, 'qty' => 3, 'unit_price' => 1500000, 'subtotal' => 4500000],
            ['transaction_id' => 12, 'product_id' => 4, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 12, 'product_id' => 5, 'qty' => 4, 'unit_price' => 1000000, 'subtotal' => 4000000],
            ['transaction_id' => 13, 'product_id' => 1, 'qty' => 2, 'unit_price' => 500000, 'subtotal' => 1000000],
            ['transaction_id' => 13, 'product_id' => 2, 'qty' => 1, 'unit_price' => 2000000, 'subtotal' => 2000000],
            ['transaction_id' => 13, 'product_id' => 3, 'qty' => 3, 'unit_price' => 1500000, 'subtotal' => 4500000]
        ]);
    }
}
