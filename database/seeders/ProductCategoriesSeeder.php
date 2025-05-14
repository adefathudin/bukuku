<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('product_categories')->insert([
            ['name' => 'Drinks', 'description' => 'Beverages and refreshments'],
            ['name' => 'Food', 'description' => 'Groceries and food items'],
            ['name' => 'Health & Beauty', 'description' => 'Health and beauty products'],
        ]);
    }
}
