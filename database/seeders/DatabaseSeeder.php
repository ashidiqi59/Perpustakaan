<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'npm'      => '12345678',
            'name'     => 'Admin',
            'password' => bcrypt('Admin123'),
            'role'     => User::ROLE_ADMIN,
        ]);

        User::firstOrCreate(['email' => 'rikorizky20@gmail.com'], [
            'npm'      => '714250017',
            'name'     => 'Riko Rizky',
            'password' => bcrypt('Mautauaja12'),
            'role'     => User::ROLE_PENGUNJUNG,
        ]);

        User::firstOrCreate(['email' => 'aris@gmail.com'], [
            'npm'      => '714250042',
            'name'     => 'Muhammad Aris',
            'password' => bcrypt('Password12'),
            'role'     => User::ROLE_PENGUNJUNG,
        ]);

        User::firstOrCreate(['email' => 'petugas@gmail.com'], [
            'npm'      => null,
            'name'     => 'Petugas Perpustakaan',
            'password' => bcrypt('Petugas123'),
            'role'     => User::ROLE_PETUGAS,
        ]);

        $this->call(BooksSeeder::class);
    }
}
