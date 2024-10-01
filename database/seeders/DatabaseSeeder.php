<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Member;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Shop;
use App\Models\StockShop;
use App\Models\User;
use Illuminate\Contracts\Cache\Store;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat data shop dari seeeder
        $this->call(ShopSeeder::class);
        // Membuat 1 user admin
        User::factory(1)->admin()->create();
        // Membuat user dengan role kasir
        User::factory(3)->cashier()->create();

        // Membuat user development
        User::create(
            [
                'name' => 'Muhammad Khaeril Anwar',
                'nik' => '12210952',
                'email' => 'khaerilanwar1992@gmail.com',
                'no_hp' => '085870627026',
                'alamat' => fake()->address(),
                'password' => Hash::make('sayang'),
                'role' => 2,
                'shop_id' => fake()->randomElement(Shop::all()->pluck('id'))
            ]
        );

        // Membuat data notification
        // Notification::factory(3)->public()->create();
        Notification::factory(12)->private()->create();

        // Membuat data kategori seeder
        $this->call(CategorySeeder::class);

        // Membuat data products
        Product::factory(220)->create();

        // Memanggil In Product Seeder
        $this->call(InProductSeeder::class);

        // Membuat data stock produk tiap toko
        $this->call(StockShopSeeder::class);

        // Membuat data members
        Member::factory(13)->create();

        // Membuat data transactions
        $this->call(TransactionSeeder::class);

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
