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
                'name' => 'Leo Kripik Kentang',
                'description' => 'Keripik kentang dengan rasa yang gurih dan renyah.',
                'price' => 15000,
                'category_id' => 2,
                'sub_category_id' => 3,
                'stock' => 100,
                'image' => 'sample-68252622a05af.jpeg',
                'created_by' => 1,
            ],
            [
                'name' => 'Coca-Cola',
                'description' => 'Minuman bersoda dengan rasa manis dan segar.',
                'price' => 10000,
                'category_id' => 1,
                'sub_category_id' => 1,
                'stock' => 200,
                'image' => 'sample-6825267ebef34.jpeg',
                'created_by' => 1,
            ],
            [
                'name' => 'Pepsi',
                'description' => 'Minuman bersoda dengan rasa manis dan menyegarkan.',
                'price' => 10000,
                'category_id' => 1,
                'sub_category_id' => 1,
                'stock' => 150,
                'image' => 'sample-682526afb2686.jpeg',
                'created_by' => 1,
            ],
            [
                'name' => 'Indomie Goreng',
                'description' => 'Mie instan goreng dengan bumbu spesial.',
                'price' => 5000,
                'category_id' => 2,
                'sub_category_id' => 3,
                'stock' => 300,
                'image' => 'sample-682526e07ae86.jpeg',
                'created_by' => 1,
            ],
            [
                'name' => 'Nutella',
                'description' => 'Selai cokelat hazelnut yang lezat.',
                'price' => 50000,
                'category_id' => 2,
                'sub_category_id' => 3,
                'stock' => 50,
                'image' => 'sample-6825272902130.jpeg',
                'created_by' => 1,
            ],
            [
                'name' => 'Lifebuoy Sabun Mandi',
                'description' => 'Sabun mandi dengan formula antibakteri.',
                'price' => 20000,
                'category_id' => 3,
                'sub_category_id' => 5,
                'stock' => 80,
                'image' => 'sample-6825276ef3993.png',
                'created_by' => 1,
            ],
            [
                'name' => 'Pond\'s Krim Wajah',
                'description' => 'Krim wajah untuk menjaga kelembapan kulit.',
                'price' => 30000,
                'category_id' => 3,
                'sub_category_id' => 5,
                'stock' => 60,
                'image' => 'sample-682527b2310dd.jpeg',
                'created_by' => 1,
            ],
            [
                'name' => 'Sunsilk Shampoo',
                'description' => 'Shampoo untuk menjaga kesehatan rambut.',
                'price' => 25000,
                'category_id' => 3,
                'sub_category_id' => 5,
                'stock' => 70,
                'image' => 'sample-682528115a01e.jpeg',
                'created_by' => 1,
            ],
            [
                'name' => 'L\'Oreal Makeup Foundation',
                'description' => 'Foundation makeup untuk tampilan yang sempurna.',
                'price' => 150000,
                'category_id' => 3,
                'sub_category_id' => 6,
                'stock' => 40,
                'image' => 'sample-6825284776eaa.jpeg',
                'created_by' => 1,
            ],
        ]);
    }
}
