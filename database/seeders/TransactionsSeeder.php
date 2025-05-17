<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('transactions')->insert([            
        ['receipt_number' => 2424242424, 'transaction_date' => date('Y-m-d H:i:s', strtotime('-30 days')), 'total_price' => 150000, 'created_by' => 1],
        ['receipt_number' => 1010101010, 'transaction_date' => date('Y-m-d H:i:s', strtotime('-9 days')), 'total_price' => 75000, 'created_by' => 1],
        ['receipt_number' => 6633442211, 'transaction_date' => date('Y-m-d H:i:s', strtotime('-6 days')), 'total_price' => 85000, 'created_by' => 1],
        ['receipt_number' => 9988776653, 'transaction_date' => date('Y-m-d H:i:s', strtotime('-4 days')), 'total_price' => 310000, 'created_by' => 1],
        ['receipt_number' => 9988776655, 'transaction_date' => date('Y-m-d H:i:s', strtotime('-2 days')), 'total_price' => 240000, 'created_by' => 1],
        ['receipt_number' => 1122334455, 'transaction_date' => date('Y-m-d H:i:s', strtotime('-1 days')), 'total_price' => 140000, 'created_by' => 1],
        ['receipt_number' => 8877665544, 'transaction_date' => date('Y-m-d H:i:s'), 'total_price' => 135000, 'created_by' => 1],

        ]);
    }
}
