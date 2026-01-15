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
        User::factory()->create([
            'npm' => '12345678',
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => 'Password12',
            'role' => User::ROLE_ADMIN,
        ]);

        User::factory()->create([
            'npm' => '714250017',
            'name' => 'Riko Rizky',
            'email' => 'rikorizky20@gmail.com',
            'password' => 'Mautauaja12',
            'role' => User::ROLE_PENGUNJUNG,
        ]);

        User::factory()->create([
            'npm' => '714250042',
            'name' => 'Muhammad Aris',
            'email' => 'aris@gmail.com',
            'password' => 'Password12',
            'role' => User::ROLE_PENGUNJUNG,
        ]);

        $this->call(BooksSeeder::class);
    }
}
