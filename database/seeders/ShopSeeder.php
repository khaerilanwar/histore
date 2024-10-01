<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name_shops = ['Pasarbatang', 'Tegal', 'Brebes'];
        foreach ($name_shops as $shop) {
            Shop::create(
                [
                    'id' => strtoupper(Str::random(4)),
                    'name' => $shop,
                    'address' => fake()->address()
                ]
            );
        }
    }
}
