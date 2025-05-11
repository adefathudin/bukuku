<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \DB::table('products')->insert([
            [
                'name' => 'Samsung Galaxy S25 Ultra',
                'price' => 22999000,
                'stock' => 27,
                'image' => 'sample-samsungs25.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Iphone 15 Pink',
                'price' => 11749000,
                'stock' => 9,
                'image' => 'sample-iphone15pink.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Huawei Watch D2 - Black',
                'price' => 4999000,
                'stock' => 15,
                'image' => 'sample-huaweid2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
