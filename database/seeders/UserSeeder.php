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
            ['name' => 'Admin', 'email' => 'admin@pos.com', 'role' => 'admin', 'active' => true, 'password' => Hash::make('admin123'), 'created_by' => 1],
            ['name' => 'Kasir', 'email' => 'kasir@pos.com', 'role' => 'kasir', 'active' => true, 'password' => Hash::make('kasir123'), 'created_by' => 1],
        ]);
    }
}
