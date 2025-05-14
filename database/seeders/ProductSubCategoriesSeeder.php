<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('product_sub_categories')->insert([
            ['name' => 'Soda', 'category_id' => 1, 'description' => 'Carbonated soft drinks'],
            ['name' => 'Juice', 'category_id' => 1, 'description' => 'Fresh fruit juices'],
            ['name' => 'Chips', 'category_id' => 2, 'description' => 'Snacks and chips'],
            ['name' => 'Cereal', 'category_id' => 2, 'description' => 'Breakfast cereals'],
            ['name' => 'Skincare', 'category_id' => 3, 'description' => 'Skin care products'],
            ['name' => 'Makeup', 'category_id' => 3, 'description' => 'Cosmetics and makeup items'],
            ['name' => 'Vitamins', 'category_id' => 3, 'description' => 'Health supplements and vitamins'],
            ['name' => 'Perfume', 'category_id' => 3, 'description' => 'Fragrances and perfumes'],
        ]);
    }
}
