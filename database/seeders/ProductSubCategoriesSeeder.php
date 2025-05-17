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
            ['name' => 'Soda', 'category_id' => 1, 'description' => 'Carbonated soft drinks', 'created_by' => 1],
            ['name' => 'Juice', 'category_id' => 1, 'description' => 'Fresh fruit juices', 'created_by' => 1],
            ['name' => 'Chips', 'category_id' => 2, 'description' => 'Snacks and chips', 'created_by' => 1],
            ['name' => 'Cereal', 'category_id' => 2, 'description' => 'Breakfast cereals', 'created_by' => 1],
            ['name' => 'Skincare', 'category_id' => 3, 'description' => 'Skin care products', 'created_by' => 1],
            ['name' => 'Makeup', 'category_id' => 3, 'description' => 'Cosmetics and makeup items', 'created_by' => 1],
            ['name' => 'Vitamins', 'category_id' => 3, 'description' => 'Health supplements and vitamins', 'created_by' => 1],
            ['name' => 'Perfume', 'category_id' => 3, 'description' => 'Fragrances and perfumes', 'created_by' => 1],
        ]);
    }
}
