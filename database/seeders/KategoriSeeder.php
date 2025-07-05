<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('kategori')->insert([
            ['tipe' => 2, 'nama_kategori' => 'Transportasi'],
            ['tipe' => 2, 'nama_kategori' => 'Makanan'],
            ['tipe' => 2, 'nama_kategori' => 'Minuman'],
            ['tipe' => 2, 'nama_kategori' => 'Kesehatan'],
            ['tipe' => 2, 'nama_kategori' => 'Hiburan'],
            ['tipe' => 1, 'nama_kategori' => 'Gaji'],
            ['tipe' => 1, 'nama_kategori' => 'Bonus'],
            ['tipe' => 1, 'nama_kategori' => 'Investasi'],
            ['tipe' => 1, 'nama_kategori' => 'Lainnya'],
        ]);        
    }
}
