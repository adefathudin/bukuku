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
            ['receipt_number' => '1746866886', 'transaction_date' => date('Y-m-d H:i:s', strtotime('-7 days')), 'total_price' => 1800000, 'user_id' => 1],
            ['receipt_number' => '1746866887', 'transaction_date' => date('Y-m-d H:i:s', strtotime('-6 days')), 'total_price' => 2000000, 'user_id' => 1],
            ['receipt_number' => '1746866888', 'transaction_date' => date('Y-m-d H:i:s', strtotime('-5 days')), 'total_price' => 1500000, 'user_id' => 1],
            ['receipt_number' => '1746866889', 'transaction_date' => date('Y-m-d H:i:s', strtotime('-4 days')), 'total_price' => 2500000, 'user_id' => 1],
            ['receipt_number' => '1746866890', 'transaction_date' => date('Y-m-d H:i:s', strtotime('-3 days')), 'total_price' => 3000000, 'user_id' => 1],
            ['receipt_number' => '1746866898', 'transaction_date' => date('Y-m-d H:i:s', strtotime('-2 days')), 'total_price' => 7000000, 'user_id' => 1],
            ['receipt_number' => '1746866891', 'transaction_date' => date('Y-m-d H:i:s', strtotime('-2 days')), 'total_price' => 3500000, 'user_id' => 1],
            ['receipt_number' => '1746866892', 'transaction_date' => date('Y-m-d H:i:s', strtotime('-2 days')), 'total_price' => 4000000, 'user_id' => 1],
            ['receipt_number' => '1746866894', 'transaction_date' => date('Y-m-d H:i:s'), 'total_price' => 5000000, 'user_id' => 1],
            ['receipt_number' => '1746866896', 'transaction_date' => date('Y-m-d H:i:s'), 'total_price' => 6000000, 'user_id' => 1],
            ['receipt_number' => '1746866895', 'transaction_date' => date('Y-m-d H:i:s'), 'total_price' => 5500000, 'user_id' => 1],
            ['receipt_number' => '1746866897', 'transaction_date' => date('Y-m-d H:i:s'), 'total_price' => 6500000, 'user_id' => 1],
            ['receipt_number' => '1746866899', 'transaction_date' => date('Y-m-d H:i:s'), 'total_price' => 7500000, 'user_id' => 1],
        ]);
    }
}
