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
    // 1 Adet Admin Hesabı 
    \App\Models\User::create([
        'name' => 'Admin Emre',
        'email' => 'admin@test.com',
        'password' => bcrypt('123456'),
        'role' => 'admin'
    ]);

    // 5 Adet Örnek Kullanıcı 
    \App\Models\User::factory(5)->create(['role' => 'user']);

    // 20 Adet Ürün 
    for ($i = 1; $i <= 20; $i++) {
        \App\Models\Product::create([
            'name' => 'Evcil Hayvan Ürünü ' . $i,
            'price' => rand(50, 500),
            'stock' => rand(5, 100),
            'image' => 'f1.png' 
        ]);
    }
}
}
