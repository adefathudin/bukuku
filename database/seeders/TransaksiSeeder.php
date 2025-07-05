<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('transaksi')->insert([
            [
                'kategori_id' => 1,
                'deskripsi' => 'Beli tiket bus',
                'jumlah' => 150000,
                'tanggal' => date('Y-m-d H:i:s', strtotime('-30 days')),
                'tipe' => 2,
            ],
            [
                'kategori_id' => 2,
                'deskripsi' => 'Makan siang di restoran',
                'jumlah' => 75000,
                'tanggal' => date('Y-m-d H:i:s', strtotime('-9 days')),
                'tipe' => 2,
            ],
            [
                'kategori_id' => 6,
                'deskripsi' => 'Gaji bulan Juni',
                'jumlah' => 5000000,
                'tanggal' => date('Y-m-d H:i:s', strtotime('-1 days')),
                'tipe' => 1,
            ],
            [
                'kategori_id' => 7,
                'deskripsi' => 'Bonus tahunan',
                'jumlah' => 1000000,
                'tanggal' => date('Y-m-d H:i:s'),
                'tipe' => 1,
            ],
            [
                'kategori_id' => 3,
                'deskripsi' => 'Beli bahan makanan',
                'jumlah' => 200000,
                'tanggal' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'tipe' => 2,
            ],
            [
                'kategori_id' => 4,
                'deskripsi' => 'Pembayaran listrik',
                'jumlah' => 300000,
                'tanggal' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'tipe' => 2,
            ],
            [
                'kategori_id' => 5,
                'deskripsi' => 'Beli buku',
                'jumlah' => 50000,
                'tanggal' => date('Y-m-d H:i:s'),
                'tipe' => 2,
            ],
        ]);
    }
}
