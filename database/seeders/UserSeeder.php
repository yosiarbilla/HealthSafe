<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'dokter',
                'email' => 'dokter@apoteksetiabudi.com',
                'password' => Hash::make('dokter123'),
                'role' => 'dokter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'administrasi',
                'email' => 'admin@apoteksetiabudi.com',
                'password' => Hash::make('admin123'),
                'role' => 'administrasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'superadmin',
                'email' => 'superadmin@apoteksetiabudi.com',
                'password' => Hash::make('superadmin123'),
                'role' => 'superadmin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
