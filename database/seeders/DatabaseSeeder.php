<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Member;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Staff;
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

        // Membuat user development
        Staff::factory(18)->create();

        // Membuat user dengan role kasir
        User::factory(18)->cashier()->create();

        Staff::create(
            [
                'nik' => 3329091909020009,
                'name' => 'Muhammad Khaeril Anwar',
                'ttl' => 'Brebes, 19 September 2002',
                'email' => 'khaerilanwar1992@gmail.com',
                'no_hp' => '085870627026',
                'alamat' => fake()->address(),
                'salary' => 2104000
            ]
        );

        User::create(
            [
                'nik' => '12210952',
                'password' => Hash::make('sayang'),
                'role' => 2,
                'shop_id' => fake()->randomElement(Shop::all()->pluck('id')),
                'nik_ktp' => 3329091909020009
            ]
        );

        User::create(
            [
                'nik' => 'admin',
                'password' => Hash::make('admin'),
                'role' => 1,
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
