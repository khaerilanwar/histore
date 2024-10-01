<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Shop;
use App\Models\StockShop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shops = Shop::all();
        $products = Product::all();

        // Melakukan looping tiap toko
        foreach ($shops as $shop) {
            // Melakukan looping tiap produk
            foreach ($products as $product) {
                StockShop::create(
                    [
                        'stock' => fake()->numberBetween(1, 100),
                        'product_id' => $product->id,
                        'shop_id' => $shop->id
                    ]
                );
            }
        }
    }
}
