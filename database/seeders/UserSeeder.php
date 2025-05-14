<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('users')->insert([
            ['name' => 'Admin', 'email' => 'admin@pos.com', 'role' => 'admin', 'password' => Hash::make('admin123')],
            ['name' => 'Kasir', 'email' => 'kasir@pos.com', 'role' => 'kasir', 'password' => Hash::make('kasir123')]
        ]);
    }
}
