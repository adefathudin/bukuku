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
            ['name' => 'Soda', 'description' => 'Carbonated soft drinks', 'created_by' => 1],
            ['name' => 'Juice', 'description' => 'Fresh fruit juices', 'created_by' => 1],
            ['name' => 'Chips', 'description' => 'Snacks and chips', 'created_by' => 1],
            ['name' => 'Cereal', 'description' => 'Breakfast cereals', 'created_by' => 1],
            ['name' => 'Skincare', 'description' => 'Skin care products', 'created_by' => 1],
            ['name' => 'Makeup', 'description' => 'Cosmetics and makeup items', 'created_by' => 1],
            ['name' => 'Vitamins', 'description' => 'Health supplements and vitamins', 'created_by' => 1],
            ['name' => 'Perfume', 'description' => 'Fragrances and perfumes', 'created_by' => 1],
        ]);
    }
}
